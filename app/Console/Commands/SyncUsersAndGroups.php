<?php

namespace App\Console\Commands;

use App\Services\Synchronizers\UsersAndGroupsSynchronizer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncUsersAndGroups extends Command
{
    /**
     * @var string
     */
    protected $signature = 'sync:users-groups';

    /**
     * @var string
     */
    protected $description = 'Synchronize users and groups';

    public function __construct(private readonly UsersAndGroupsSynchronizer $synchronizer)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Users and groups synchronization - START');

        try {
            $logger = Log::channel('sync');
            $logger->info("Users and groups synchronization - START");
            $this->synchronizer->synchronize();
            $logger->info("Users and groups synchronization - END");
            $this->info('Users and groups synchronization - END');
        } catch (\Throwable $exception) {
            Log::channel('sync')->error($exception->getMessage());
            $this->error(
                sprintf(
                    'Users and groups synchronization failed. %s - %s',
                    $exception->getMessage(),
                    $exception->getTraceAsString()
                )
            );
        }
    }
}
