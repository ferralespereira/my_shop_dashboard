<?php

declare(strict_types=1);

namespace App\Domain\BusinessCategory;

use DateTimeImmutable;

final class BusinessCategory
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly DateTimeImmutable $createdAt,
        public readonly DateTimeImmutable $updatedAt,
    ) {}

    public static function create(
        string $id,
        string $name,
        ?string $description,
    ): self {
        $now = new DateTimeImmutable();
        return new self(
            id: $id,
            name: $name,
            description: $description,
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function update(
        string $name,
        ?string $description,
    ): self {
        return new self(
            id: $this->id,
            name: $name,
            description: $description,
            createdAt: $this->createdAt,
            updatedAt: new DateTimeImmutable(),
        );
    }
}