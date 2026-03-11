<?php

declare(strict_types=1);

namespace App\Web\AboutUs;

use Psr\Http\Message\ResponseInterface;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Yii\View\Renderer\ViewRenderer;

final readonly class Action
{
    public function __construct(
        private ViewRenderer $viewRenderer,
        private UrlGeneratorInterface $urlGenerator,
    ) {}

    public function __invoke(): ResponseInterface
    {
        return $this->viewRenderer->render(__DIR__ . '/template', [
            'urlGenerator' => $this->urlGenerator,
        ]);
    }
}
