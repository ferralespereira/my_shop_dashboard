<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M260311182519CreateBusinessCategoryTable implements RevertibleMigrationInterface
{
    public function up(MigrationBuilder $b): void
    {
        $column = $b->columnBuilder();

        $b->createTable('business_category', [
            'id'          => $column::uuid()->notNull()->primaryKey(),
            'name'        => $column::string()->notNull(),
            'description' => $column::text()->null(),
            'created_at'  => $column::dateTime()->notNull(),
            'updated_at'  => $column::dateTime()->notNull(),
        ]); 
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable('business_category');
    }
}