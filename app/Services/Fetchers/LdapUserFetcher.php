<?php
declare(strict_types=1);

namespace App\Services\Fetchers;

use Adldap\Laravel\Facades\Adldap;
use App\DataObjects\Sync\FetchedUser;
use Illuminate\Support\Facades\Log;

class LdapUserFetcher implements UserFetcher
{
    private const IDENTIFIER = 'LdapUserFetcher';

    /**
     * @inheritDoc
     */
    public function fetch(): array
    {
        $adLdap = Adldap::getFacadeRoot();
        $provider = $adLdap->getDefaultProvider();
        $ldapUsers = $provider->search()
            ->select(
                'name',
                'mail',
                'objectguid',
                'personalTitle',
                'generationQualifier',
                'givenName',
                'sn',
                'title',
                'department',
                'description',
                'extensionName',
                'distinguishedName'
            )
            ->where('objectCategory', '=', 'CN=Person,CN=Schema,CN=Configuration,DC=bratislava,DC=local')
            ->paginate()
            ->getResults();
        $users = [];
        $emptyGuid = $duplicatedEmails = 0;

        foreach ($ldapUsers as $key => $ldapUser) {
            if ((isset($ldapUser['mail'][0])) or isset($ldapUser['extensionName'][0])) {
                if (empty($ldapUser['mail'][0])) {
                    $email = $ldapUser['extensionName'][0];
                } else {
                    $email = $ldapUser['mail'][0];
                }

                if (!isset($ldapUser['title'][0])) {
                    $jobTitle = null;
                } else {
                    $jobTitle = $ldapUser['title'][0];
                }

                if (!isset($ldapUser['givenName'][0])) {
                    $givenName = null;
                } else {
                    $givenName = $ldapUser['givenName'][0];
                }

                if (!isset($ldapUser['sn'][0])) {
                    $sn = null;
                } else {
                    $sn = $ldapUser['sn'][0];
                }

                if (!isset($ldapUser['name'][0])) {
                    $name = null;
                } else {
                    $name = $ldapUser['name'][0];
                }

                if (!isset($ldapUser['department'][0])) {
                    $department = null;
                } else {
                    $department = $ldapUser['department'][0];
                }

                if (!isset($ldapUser['distinguishedName'][0])) {
                    $distinguishedName = null;
                } else {
                    $distinguishedName = $ldapUser['distinguishedName'][0];
                }

                if (!str_contains($distinguishedName, 'OU=MagistratBA')
                    and !str_contains($distinguishedName, 'OU=Organizacie')
                    and !str_contains($distinguishedName, 'OU=MPP')
                    and !str_contains($distinguishedName, 'OU=Odideni')
                    and !str_contains($distinguishedName, 'OU=MP')) {
                    continue;
                }

                $guid = $ldapUser->getConvertedGuid();
                $active = !str_contains($distinguishedName, 'OU=Odideni');

                if ($guid !== null) {
                    $user = new FetchedUser(
                        $name,
                        $sn,
                        $givenName,
                        $email,
                        $guid,
                        $department,
                        $jobTitle,
                        $active,
                    );

                    if (array_key_exists($user->email, $users)) {
                        Log::channel('sync')->info(
                            self::IDENTIFIER . 'Duplicate email',
                            [
                                'email' => $email,
                                'name' => $name,
                                'objectguid' => $user->objectguid,
                            ]
                        );
                        $duplicatedEmails++;
                        continue;
                    }

                    $users[$user->email] = $user;
                } else {
                    Log::channel('sync')->info(
                        self::IDENTIFIER . 'Empty object GUID',
                        [
                            'email' => $email,
                            'name' => $name,
                        ]
                    );
                    $emptyGuid++;
                }
            }
        }

        Log::channel('sync')->info(
            sprintf(
                '%s - fetched %d LDAP records, %d users, %d duplicated email, %d empty guids',
                self::IDENTIFIER,
                count($ldapUsers),
                count($users),
                $duplicatedEmails,
                $emptyGuid
            )
        );

        return $users;
    }
}
