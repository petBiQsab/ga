<?php

namespace App\Providers;


use App\Console\Reporting\Notifications\RgpNotFinalizedNotification;
use App\Exports\Reports\Data\RgpDataProvider;
use App\Http\Controllers\Auth\AuthCollection;
use App\Http\Controllers\JunkTraining\TestingController;
use App\Http\Controllers\ProjectDetailController;
use App\Http\Interface\DataInterface;
use App\Http\Interface\ExportInterface\ExportInterface;
use App\Http\Interface\PracoviskoInterface;
use App\Http\Interface\ProjectDetailInterface;
use App\Http\Repositories\DataRepository;
use App\Http\Repositories\PracoviskoRepository;
use App\Http\Repositories\ProjectDetailRepository;
use App\Http\Rights\ProjectUserRights;
use App\Mail\Notifications\RGP_not_finilized;
use App\Services\Fetchers\GroupFetcher;
use App\Services\Fetchers\LdapGroupFetcher;
use App\Services\Fetchers\LdapManagerFetcher;
use App\Services\Fetchers\LdapUserFetcher;
use App\Services\Fetchers\LdapUserGroupFetcher;
use App\Services\Fetchers\ManagerFetcher;
use App\Services\Fetchers\UserFetcher;
use App\Services\Fetchers\UserGroupFetcher;
use App\Services\Synchronizers\UsersAndGroupsSynchronizer;
use Illuminate\Log\Logger;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            PracoviskoInterface::class,
            PracoviskoRepository::class,
        );

        $this->app->bind(
            ProjectDetailInterface::class,
            ProjectDetailRepository::class,
        );

        $this->app->bind(
            DataInterface::class,
            DataRepository::class,
        );

        $this->app->bind(UserFetcher::class, LdapUserFetcher::class);
        $this->app->bind(GroupFetcher::class, LdapGroupFetcher::class);
        $this->app->bind(UserGroupFetcher::class, LdapUserGroupFetcher::class);
        $this->app->bind(ManagerFetcher::class, LdapManagerFetcher::class);

        $authConfig = new AuthCollection(\Config::get('userRightsOld.all'));
        $this->app->instance(AuthCollection::class, $authConfig);

        $this->app->when(ProjectDetailController::class)
            ->needs('$rightsConfig')
            ->giveConfig('userRights.rights');


        $this->app->when(RGP_not_finilized::class)
            ->needs('$lang')
            ->giveConfig('lang_sk.months');

        $this->app->when(RgpNotFinalizedNotification::class)
            ->needs('$lang')
            ->giveConfig('lang_sk.months');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
