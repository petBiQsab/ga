<?php

declare(strict_types=1);

namespace App\DataObjects\Sync;

use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class FetchedUserGroup extends Data
{
    public function __construct(
        public ?string $userGuid,
        public string $groupGuid,
        public ?string $parentGroupGuid,
    ) {
    }
}
