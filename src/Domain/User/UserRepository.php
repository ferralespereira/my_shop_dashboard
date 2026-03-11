<?php

declare(strict_types=1);

namespace App\Domain\User;

use DateTimeImmutable;
use Yiisoft\Db\Connection\ConnectionInterface;

final readonly class UserRepository
{
    public function __construct(
        private ConnectionInterface $connection,
    ) {}

    public function save(User $user): void
    {
        $row = [
            'id'         => $user->id,
            'email'      => $user->email,
            'password'   => $user->password,
            'created_at' => $user->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $user->updatedAt->format('Y-m-d H:i:s'),
        ];

        if ($this->exists($user->id)) {
            $this->connection->createCommand()
                ->update('{{%user}}', $row, ['id' => $user->id])
                ->execute();
        } else {
            $this->connection->createCommand()
                ->insert('{{%user}}', $row)
                ->execute();
        }
    }

    public function findByEmail(string $email): ?User
    {
        $row = $this->connection
            ->createQuery()
            ->from('{{%user}}')
            ->where(['email' => $email])
            ->one();

        return $this->createUser($row);
    }

    public function findById(string $id): ?User
    {
        $row = $this->connection
            ->createQuery()
            ->from('{{%user}}')
            ->where(['id' => $id])
            ->one();

        return $this->createUser($row);
    }

    public function emailExists(string $email): bool
    {
        return $this->connection
            ->createQuery()
            ->from('{{%user}}')
            ->where(['email' => $email])
            ->exists();
    }

    public function exists(string $id): bool
    {
        return $this->connection
            ->createQuery()
            ->from('{{%user}}')
            ->where(['id' => $id])
            ->exists();
    }

    private function createUser(?array $row): ?User
    {
        if ($row === null) {
            return null;
        }

        return new User(
            id: $row['id'],
            email: $row['email'],
            password: $row['password'],
            createdAt: new DateTimeImmutable($row['created_at']),
            updatedAt: new DateTimeImmutable($row['updated_at']),
        );
    }
}