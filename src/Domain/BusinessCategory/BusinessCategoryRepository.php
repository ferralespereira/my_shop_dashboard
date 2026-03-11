<?php

declare(strict_types=1);

namespace App\Domain\BusinessCategory;

use DateTimeImmutable;
use Yiisoft\Db\Connection\ConnectionInterface;

final readonly class BusinessCategoryRepository
{
    public function __construct(
        private ConnectionInterface $connection,
    ) {}

    public function save(BusinessCategory $category): void
    {
        $row = [
            'id'          => $category->id,
            'name'        => $category->name,
            'description' => $category->description,
            'created_at'  => $category->createdAt->format('Y-m-d H:i:s'),
            'updated_at'  => $category->updatedAt->format('Y-m-d H:i:s'),
        ];

        if ($this->exists($category->id)) {
            $this->connection->createCommand()
                ->update('{{%business_category}}', $row, ['id' => $category->id])
                ->execute();
        } else {
            $this->connection->createCommand()
                ->insert('{{%business_category}}', $row)
                ->execute();
        }
    }

    public function findAll(int $limit = 10, int $offset = 0): iterable
    {
        $rows = $this->connection
            ->createQuery()
            ->from('{{%business_category}}')
            ->limit($limit)
            ->offset($offset)
            ->all();

        foreach ($rows as $row) {
            yield $this->createCategory($row);
        }
    }

    public function findById(string $id): ?BusinessCategory
    {
        $row = $this->connection
            ->createQuery()
            ->from('{{%business_category}}')
            ->where(['id' => $id])
            ->one();

        return $this->createCategory($row);
    }

    public function count(): int
    {
        return (int) $this->connection
            ->createQuery()
            ->from('{{%business_category}}')
            ->count();
    }

    public function deleteById(string $id): void
    {
        $this->connection->createCommand()
            ->delete('{{%business_category}}', ['id' => $id])
            ->execute();
    }

    public function exists(string $id): bool
    {
        return $this->connection
            ->createQuery()
            ->from('{{%business_category}}')
            ->where(['id' => $id])
            ->exists();
    }

    private function createCategory(?array $row): ?BusinessCategory
    {
        if ($row === null) {
            return null;
        }

        return new BusinessCategory(
            id: $row['id'],
            name: $row['name'],
            description: $row['description'] ?? null,
            createdAt: new DateTimeImmutable($row['created_at']),
            updatedAt: new DateTimeImmutable($row['updated_at']),
        );
    }
}