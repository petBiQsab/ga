<?php

declare(strict_types=1);

namespace App\DataObjects\Result;

class SynchronizationResult
{
    private int $new = 0;
    private int $updated = 0;
    private int $same = 0;
    private int $failed = 0;

    public function __construct(private readonly int $fetched)
    {

    }

    public function incNew(): void
    {
        $this->new++;
    }

    public function incUpdated(): void
    {
        $this->updated++;
    }

    public function incSame(): void
    {
        $this->same++;
    }

    public function incFailed(): void
    {
        $this->failed++;
    }

    public function getNew(): int
    {
        return $this->new;
    }

    public function getUpdated(): int
    {
        return $this->updated;
    }

    public function getFetched(): int
    {
        return $this->fetched;
    }

    public function getSame(): int
    {
        return $this->same;
    }

    public function getFailed(): int
    {
        return $this->failed;
    }

    public function setNew(int $new): void
    {
        $this->new = $new;
    }

    public function setUpdated(int $updated): void
    {
        $this->updated = $updated;
    }

    public function setSame(int $same): void
    {
        $this->same = $same;
    }

    public function setFailed(int $failed): void
    {
        $this->failed = $failed;
    }
}
