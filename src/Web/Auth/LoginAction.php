<?php

declare(strict_types=1);

namespace App\Web\Auth;

use App\Domain\User\UserRepository;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\FormModel\FormHydrator;
use Yiisoft\Http\Status;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Session\SessionInterface;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class LoginAction
{
    public function __construct(
        private WebViewRenderer $viewRenderer,
        private FormHydrator $formHydrator,
        private ResponseFactoryInterface $responseFactory,
        private UrlGeneratorInterface $urlGenerator,
        private UserRepository $userRepository,
        private SessionInterface $session,
    ) {}

    public function __invoke(
        ServerRequestInterface $request,
    ): ResponseInterface {
        $form = new LoginForm();

        $this->formHydrator->populateFromPostAndValidate($form, $request);

        if ($form->isValid()) {
            $user = $this->userRepository->findByEmail($form->email);

            if ($user === null || !$user->validatePassword($form->password)) {
                return $this->viewRenderer->render(__DIR__ . '/login', [
                    'form' => $form,
                    'error' => 'Invalid email or password.',
                ]);
            }

            $this->session->set('user_id', $user->id);

            return $this->responseFactory
                ->createResponse(Status::SEE_OTHER)
                ->withHeader(
                    'Location',
                    $this->urlGenerator->generate('business-category/list'),
                );
        }

        return $this->viewRenderer->render(__DIR__ . '/login', [
            'form' => $form,
            'error' => null,
        ]);
    }
}