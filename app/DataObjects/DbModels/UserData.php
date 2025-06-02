<?php

declare(strict_types=1);

namespace App\DataObjects\DbModels;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\CamelCaseMapper;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class UserData extends Data
{
    public function __construct(
        public ?int $id = null,
        public ?string $name,
        public ?string $sn,
        #[MapOutputName('givenName')]
        public ?string $givenName,
        public string $email,
        public string $objectguid,
        public ?string $department,
        #[MapOutputName('jobTitle')]
        public ?string $jobTitle,
        #[MapOutputName('activeUser')]
        public ?bool $activeUser,
        public ?CarbonImmutable $emailVerifiedAt,
        public ?string $password,
        public ?string $rememberToken,
        public ?CarbonImmutable $createdAt,
        public ?CarbonImmutable $updatedAt,
        public ?CarbonImmutable $deletedAt,
        public string $checksum
    ) {

    }
}
