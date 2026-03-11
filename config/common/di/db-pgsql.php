<?php

declare(strict_types=1);

use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\Db\Pgsql\Connection;
use Yiisoft\Db\Pgsql\Driver;

return [
    ConnectionInterface::class => [
        'class' => Connection::class,
        '__construct()' => [
            'driver' => new Driver(
                getenv('DB_DSN'),
                getenv('DB_USERNAME'),
                getenv('DB_PASSWORD'),
            ),
        ],
    ],
];