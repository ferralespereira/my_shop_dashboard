<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M260311194823CreateUserTable implements RevertibleMigrationInterface
{
    public function up(MigrationBuilder $b): void
    {
        $column = $b->columnBuilder();

        $b->createTable('user', [
            'id'         => $column::uuid()->notNull()->primaryKey(),
            'email'      => $column::string(255)->notNull()->unique(),
            'password'   => $column::string(255)->notNull(),
            'created_at' => $column::dateTime()->notNull(),
            'updated_at' => $column::dateTime()->notNull(),
        ]);
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable('user');
    }
}