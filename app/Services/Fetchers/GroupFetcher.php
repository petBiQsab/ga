<?php

declare(strict_types=1);

namespace App\Services\Fetchers;

use App\DataObjects\Sync\FetchedGroup;

interface GroupFetcher
{
    /**
     * @return array<int, FetchedGroup>
     */
    public function fetch(): array;
}
