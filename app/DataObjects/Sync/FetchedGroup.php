<?php

declare(strict_types=1);

namespace App\DataObjects\Sync;

use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class FetchedGroup extends Data
{
    #[Computed]
    public string $checksum;

    public function __construct(
        public ?string $cn,
        public ?string $extensionName,
        public string $objectguid,
        public ?string $type,
        public ?string $identificationNumber,
    ) {
        $this->checksum = hash(
            'sha256',
            sprintf(
                '%s|%s|%s|%s|%s',
                ($this->cn ?? ''),
                ($this->extensionName ?? ''),
                $this->objectguid,
                ($this->type ?? ''),
                ($this->identificationNumber ?? ''),
            )
        );
    }
}
