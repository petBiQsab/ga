<?php
declare(strict_types=1);

namespace App\Services\Fetchers;

use Adldap\Connections\Provider;
use Adldap\Laravel\Facades\Adldap;
use Adldap\Models\Group;
use App\DataObjects\Sync\FetchedManager;
use App\DataObjects\Sync\FetchedUserGroup;
use App\Exceptions\MultipleRecordsFoundException;
use App\Exceptions\RecordNotFoundException;
use App\Models\User;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class LdapManagerFetcher implements ManagerFetcher
{
    private const IDENTIFIER = 'LdapManagerFetcher';

    public function __construct(
        private Provider $provider,
        private readonly UserRepository $userRepository,
    ) {
        $adLdap = Adldap::getFacadeRoot();
        $this->provider = $adLdap->getDefaultProvider();
    }

    /**
     * @inheritDoc
     */
    public function fetch(): array
    {
        $ldapGroups = $this->provider->search()
            ->select(
                'cn',
                'objectguid',
                'managedBy',
                'distinguishedname',
                'member'
            )->where('objectCategory', '=', 'CN=Group,CN=Schema,CN=Configuration,DC=bratislava,DC=local')
            ->get();
        $managers = [];

        foreach ($ldapGroups as $ldapGroup) {
            if (str_contains(
                    $ldapGroup['distinguishedname'][0],
                    "OU=Struktura pre WEB"
                )
                && isset($ldapGroup['managedBy'][0])) {
                $user = $this->provider->search()
                    ->select('objectguid')
                    ->where('distinguishedname', '=', $ldapGroup['managedBy'][0])
                    ->where(
                        'objectCategory',
                        '=',
                        'CN=Person,CN=Schema,CN=Configuration,DC=bratislava,DC=local'
                    )->paginate(900)
                    ->getResults();

                $dbUser = $this->userRepository->findOneByGuid($user[0]->getConvertedGuid());

                if ($dbUser === null) {
                    continue;
                }

                $managers[] = new FetchedManager($dbUser->objectguid, $ldapGroup->getConvertedGuid());
            }
        }

        Log::channel('sync')->info(
            sprintf(
                '%s - fetched %d LDAP records, %d managers',
                self::IDENTIFIER,
                count($ldapGroups),
                count($managers),
            )
        );

        return $managers;
    }
}
