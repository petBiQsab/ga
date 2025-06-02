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
class GroupData extends Data
{
    public function __construct(
        public ?int $id = null,
        public ?string $cn,
        public ?string $skratka,
        public string $objectguid,
        public ?string $typ,
        public ?string $ico,
        public ?string $gestor_utvar,
        public ?CarbonImmutable $createdAt,
        public ?CarbonImmutable $updatedAt,
        public ?CarbonImmutable $deletedAt,
        public string $checksum
    ) {

    }
}
