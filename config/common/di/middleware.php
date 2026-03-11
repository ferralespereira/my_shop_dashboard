<?php

declare(strict_types=1);

use App\Web\Auth\AuthMiddleware;
use Yiisoft\Session\SessionInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Yiisoft\Router\UrlGeneratorInterface;

return [
    AuthMiddleware::class => [
        'class' => AuthMiddleware::class,
        '__construct()' => [
            'session' => \Yiisoft\Definitions\Reference::to(SessionInterface::class),
            'responseFactory' => \Yiisoft\Definitions\Reference::to(ResponseFactoryInterface::class),
            'urlGenerator' => \Yiisoft\Definitions\Reference::to(UrlGeneratorInterface::class),
        ],
    ],
];