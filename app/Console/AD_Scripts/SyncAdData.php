<?php

namespace App\Console\AD_Scripts;

use App\Models\Projektove_portfolio;
use Illuminate\Console\Command;
use App\Http\Controllers\GroupsPeopleController;

class SyncAdData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sync_ad_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync AD users, groups, relationship, managers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $controller = new GroupsPeopleController();
        $controller->updatedb();

        $this->info('Database update triggered.');
        return 0;
    }
}

