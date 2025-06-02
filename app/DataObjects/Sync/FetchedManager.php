<?php

declare(strict_types=1);

namespace App\DataObjects\Sync;

use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class FetchedManager extends Data
{
    public function __construct(
        public string $userGuid,
        public string $groupGuid,
    ) {
    }
}
