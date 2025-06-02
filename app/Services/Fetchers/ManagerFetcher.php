<?php

declare(strict_types=1);

namespace App\Services\Fetchers;

use App\DataObjects\Sync\FetchedManager;

interface ManagerFetcher
{
    /**
     * @return array<int, FetchedManager>
     */
    public function fetch(): array;
}
