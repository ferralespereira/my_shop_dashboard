<?php

declare(strict_types=1);

namespace App\Web\Auth;

use App\Domain\User\User;
use App\Domain\User\UserRepository;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Yiisoft\FormModel\FormHydrator;
use Yiisoft\Http\Status;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Session\SessionInterface;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class RegisterAction
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
        $form = new RegisterForm();

        $this->formHydrator->populateFromPostAndValidate($form, $request);

        if ($form->isValid()) {
            if (!$form->passwordsMatch()) {
                return $this->viewRenderer->render(__DIR__ . '/register', [
                    'form' => $form,
                    'error' => 'Passwords do not match.',
                ]);
            }

            if ($this->userRepository->emailExists($form->email)) {
                return $this->viewRenderer->render(__DIR__ . '/register', [
                    'form' => $form,
                    'error' => 'Email is already registered.',
                ]);
            }

            $user = User::create(
                id: Uuid::uuid7()->toString(),
                email: $form->email,
                password: $form->password,
            );

            $this->userRepository->save($user);

            // Auto login after registration
            $this->session->set('user_id', $user->id);

            return $this->responseFactory
                ->createResponse(Status::SEE_OTHER)
                ->withHeader(
                    'Location',
                    $this->urlGenerator->generate('business-category/list'),
                );
        }

        return $this->viewRenderer->render(__DIR__ . '/register', [
            'form' => $form,
            'error' => null,
        ]);
    }
}