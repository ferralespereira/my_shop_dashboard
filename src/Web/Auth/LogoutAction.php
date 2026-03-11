<?php

declare(strict_types=1);

namespace App\Web\Auth;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\Http\Status;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Session\SessionInterface;

final readonly class LogoutAction
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private UrlGeneratorInterface $urlGenerator,
        private SessionInterface $session,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $this->session->destroy();

        return $this->responseFactory
            ->createResponse(Status::SEE_OTHER)
            ->withHeader(
                'Location',
                $this->urlGenerator->generate('auth/login'),
            );
    }
}