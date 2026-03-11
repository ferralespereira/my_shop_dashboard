<?php

declare(strict_types=1);

namespace App\Domain\User;

use DateTimeImmutable;

final class User
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $password,
        public readonly DateTimeImmutable $createdAt,
        public readonly DateTimeImmutable $updatedAt,
    ) {}

    public static function create(
        string $id,
        string $email,
        string $password,
    ): self {
        $now = new DateTimeImmutable();
        return new self(
            id: $id,
            email: $email,
            password: password_hash($password, PASSWORD_BCRYPT),
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function validatePassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}