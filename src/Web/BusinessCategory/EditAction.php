<?php

declare(strict_types=1);

namespace App\Web\BusinessCategory;

use App\Domain\BusinessCategory\BusinessCategory;
use App\Domain\BusinessCategory\BusinessCategoryRepository;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Yiisoft\FormModel\FormHydrator;
use Yiisoft\Http\Status;
use Yiisoft\Router\HydratorAttribute\RouteArgument;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class EditAction
{
    public function __construct(
        private WebViewRenderer $viewRenderer,
        private FormHydrator $formHydrator,
        private ResponseFactoryInterface $responseFactory,
        private UrlGeneratorInterface $urlGenerator,
        private BusinessCategoryRepository $repository,
    ) {}

    public function __invoke(
        #[RouteArgument('id')]
        string $id,
        ServerRequestInterface $request,
    ): ResponseInterface {
        $isNew = $id === 'new';

        $form = new Form();

        if (!$isNew) {
            $category = $this->repository->findById($id);
            if ($category === null) {
                return $this->responseFactory->createResponse(Status::NOT_FOUND);
            }
            $form->name = $category->name;
            $form->description = $category->description;
        }

        $this->formHydrator->populateFromPostAndValidate($form, $request);

        if ($form->isValid()) {
            if ($isNew) {
                $category = BusinessCategory::create(
                    id: Uuid::uuid7()->toString(),
                    name: $form->name,
                    description: $form->description,
                );
            } else {
                $category = $category->update(
                    name: $form->name,
                    description: $form->description,
                );
            }

            $this->repository->save($category);

            return $this->responseFactory
                ->createResponse(Status::SEE_OTHER)
                ->withHeader(
                    'Location',
                    $this->urlGenerator->generate('business-category/list'),
                );
        }

        return $this->viewRenderer->render(__DIR__ . '/edit', [
            'form'  => $form,
            'isNew' => $isNew,
            'id'    => $id,
        ]);
    }
}