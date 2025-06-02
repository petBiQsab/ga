<?php

declare(strict_types=1);

namespace App\DataObjects\Sync;

use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class FetchedUser extends Data
{
    #[Computed]
    public string $checksum;

    public function __construct(
        public ?string $name,
        public ?string $sn,
        public ?string $givenName,
        public string $email,
        public string $objectguid,
        public ?string $department,
        public ?string $jobTitle,
        public ?bool $activeUser,
    ) {
        $this->checksum = hash(
            'sha256',
            sprintf(
                '%s|%s|%s|%s|%s|%s|%s|%s',
                ($this->name ?? ''),
                ($this->sn ?? ''),
                ($this->givenName ?? ''),
                $this->email,
                $this->objectguid,
                ($this->department ?? ''),
                ($this->jobTitle ?? ''),
                (match ($this->activeUser) {
                    true => '1',
                    false => '0',
                    default => ''
                }),
            )
        );
    }
}
