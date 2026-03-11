<?php

declare(strict_types=1);

namespace App\Web\BusinessCategory;

use App\Domain\BusinessCategory\BusinessCategoryRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class ListAction
{
    public function __construct(
        private WebViewRenderer $viewRenderer,
        private BusinessCategoryRepository $repository,
    ) {}

    public function __invoke(
        ServerRequestInterface $request,
    ): ResponseInterface {
        $page = (int)($request->getQueryParams()['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        return $this->viewRenderer->render(__DIR__ . '/list', [
            'categories'  => $this->repository->findAll($limit, $offset),
            'currentPage' => $page,
            'totalPages'  => (int) ceil($this->repository->count() / $limit),
        ]);
    }
}