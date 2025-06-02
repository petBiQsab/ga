<?php
declare(strict_types=1);

namespace App\Services\Fetchers;

use Adldap\Laravel\Facades\Adldap;
use App\DataObjects\Sync\FetchedGroup;
use Illuminate\Support\Facades\Log;

class LdapGroupFetcher implements GroupFetcher
{
    private const IDENTIFIER = 'LdapGroupFetcher';

    /**
     * @inheritDoc
     */
    public function fetch(): array
    {
        $adLdap = Adldap::getFacadeRoot();
        $provider = $adLdap->getDefaultProvider();
        $ldapGroups = $provider->search()
            ->select(
                'cn',
                'objectguid',
                'info',
                'extensionName',
                'description'
            )->where('objectCategory', '=', 'CN=Group,CN=Schema,CN=Configuration,DC=bratislava,DC=local')
            ->get();;
        $groups = [];

        foreach ($ldapGroups as $ldapGroup) {
            if (str_contains($ldapGroup['distinguishedname'][0], "OU=Struktura pre WEB")
                || str_contains($ldapGroup['distinguishedname'][0], "OU=OU-Organizacie")
                || str_contains($ldapGroup['distinguishedname'][0], "OU=Struktura-ine")) {

                if (!isset($ldapGroup['cn'][0])) {
                    $cn = null;
                } else {
                    $cn = $ldapGroup['cn'][0];
                }

                if (!isset($ldapGroup['extensionName'][0])) {
                    $extensionName = null;
                } else {
                    $extensionName = $ldapGroup['extensionName'][0];
                }

                if (!isset($ldapGroup['info'][0])) {
                    $type = null;
                } else {
                    if (str_contains($ldapGroup['distinguishedname'][0], "OU=OU-Organizacie")) {
                        $type = $ldapGroup['info'][0];
                    } else $type = null;
                }

                if (isset($ldapGroup['description'][0]) && is_numeric($ldapGroup['description'][0])) {
                    $identificationNumber = $ldapGroup['description'][0];
                } else {
                    $identificationNumber = null;
                }

                $group = new FetchedGroup(
                    $cn,
                    $extensionName,
                    $ldapGroup->getConvertedGuid(),
                    $type,
                    $identificationNumber,
                );
                $groups[] = $group;
            }

        }

        Log::channel('sync')->info(
            sprintf(
                '%s - fetched %d LDAP records, %d groups',
                self::IDENTIFIER,
                count($ldapGroups),
                count($groups),
            )
        );

        return $groups;
    }
}
