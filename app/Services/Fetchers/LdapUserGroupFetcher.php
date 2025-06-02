<?php
declare(strict_types=1);

namespace App\Services\Fetchers;

use Adldap\Connections\Provider;
use Adldap\Laravel\Facades\Adldap;
use Adldap\Models\Group;
use App\DataObjects\Sync\FetchedUserGroup;
use App\Exceptions\MultipleRecordsFoundException;
use App\Exceptions\RecordNotFoundException;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Log;

class LdapUserGroupFetcher implements UserGroupFetcher
{
    private const IDENTIFIER = 'LdapUserGroupFetcher';

    /**
     * @param array<int, FetchedUserGroup> $userGroups
     */
    public function __construct(
        private Provider $provider,
        private readonly UserRepository $userRepository,
        private readonly GroupRepository $groupRepository,
        private array $userGroups = [],
    ) {
        $adLdap = Adldap::getFacadeRoot();
        $this->provider = $adLdap->getDefaultProvider();
    }


    /**
     * @inheritDoc
     */
    public function fetch(): array
    {
        $ldapUserGroups = $this->provider->search()
            ->select(
                'description',
                'distinguishedname',
                'member',
                'objectguid'
            )
            ->where('objectCategory', '=', 'CN=Group,CN=Schema,CN=Configuration,DC=bratislava,DC=local')
            ->get();

        foreach ($ldapUserGroups as $ldapUserGroup) {
            if (
                strpos($ldapUserGroup['distinguishedname'][0], 'OU=Struktura pre WEB')
                || strpos($ldapUserGroup['distinguishedname'][0], 'OU=OU-Organizacie')) {

                $groupGuid = $ldapUserGroup->getConvertedGuid();

                if (is_array($ldapUserGroup['member']) || is_object($ldapUserGroup['member'])) {
                    $this->addUserGroups($groupGuid, $ldapUserGroup);
                }
            }
        }

        Log::channel('sync')->info(
            sprintf(
                '%s - fetched %d LDAP records, %d user groups',
                self::IDENTIFIER,
                count($ldapUserGroups),
                count($this->userGroups),
            )
        );

        return $this->userGroups;
    }

    /**
     * @throws RecordNotFoundException
     * @throws MultipleRecordsFoundException
     */
    private function addUserGroups(string $groupGuid, Group $ldapUserGroup): void
    {
        foreach ($ldapUserGroup['member'] as $member) {
            if (!strpos($member, 'OU=Struktura pre WEB')) {
                $user = $this->provider->search()
                    ->select('objectguid')
                    ->where('distinguishedname', '=', $member)
                    ->where(
                        'objectCategory',
                        '=',
                        'CN=Person,CN=Schema,CN=Configuration,DC=bratislava,DC=local'
                    )->paginate(900)
                    ->getResults();

                if (isset($user[0])) {
                    $dbUser = $this->userRepository->findOneByGuid($user[0]->getConvertedGuid());

                    if ($dbUser === null) {
                        continue;
                    }

                    $this->userGroups[] = new FetchedUserGroup(
                        $dbUser->objectguid,
                        $groupGuid,
                        null
                    );
                }
            }

            if (strpos($member, 'OU=Struktura pre WEB') || strpos($member, 'OU=OU-Organizacie')) {
                $tmp = explode("CN=", $member);
                $tmp = explode(",OU", $tmp[1]);
                $result = str_replace('\,', ',', $tmp[0]); // remove slash before comma
                $criteria = [['cn', '=', $result]];
                $dbGroup = $this->groupRepository->findOneByCriteria($criteria);

                if ($dbGroup === null) {
                    throw new RecordNotFoundException(
                        sprintf('Group not found - criteria %s.', json_encode($criteria))
                    );
                }

                $this->userGroups[] = new FetchedUserGroup(
                    null,
                    $dbGroup->objectguid,
                    $groupGuid,
                );
            }
        }
    }
}
