<?php

declare(strict_types=1);

namespace App\Web\BusinessCategory;

use App\Domain\BusinessCategory\BusinessCategoryRepository;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\Http\Status;
use Yiisoft\Router\HydratorAttribute\RouteArgument;
use Yiisoft\Router\UrlGeneratorInterface;

final readonly class DeleteAction
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private UrlGeneratorInterface $urlGenerator,
        private BusinessCategoryRepository $repository,
    ) {}

    public function __invoke(
        #[RouteArgument('id')]
        string $id,
    ): ResponseInterface {
        $category = $this->repository->findById($id);

        if ($category === null) {
            return $this->responseFactory->createResponse(Status::NOT_FOUND);
        }

        $this->repository->deleteById($id);

        return $this->responseFactory
            ->createResponse(Status::SEE_OTHER)
            ->withHeader(
                'Location',
                $this->urlGenerator->generate('business-category/list'),
            );
    }
}