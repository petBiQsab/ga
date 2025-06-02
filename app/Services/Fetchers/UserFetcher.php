<?php

declare(strict_types=1);

namespace App\Services\Fetchers;

use App\DataObjects\Sync\FetchedUser;

interface UserFetcher
{
    /**
     * @return array<int, FetchedUser>
     */
    public function fetch(): array;
}
