<?php

namespace App\Console\Commands;

use App\Services\Synchronizers\UsersAndGroupsSynchronizer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ConsolePing extends Command
{
    /**
     * @var string
     */
    protected $signature = 'command:ping';

    /**
     * @var string
     */
    protected $description = 'Ping and log';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $logger = Log::channel('sync');
        $logger->info("Ping");
    }
}
