<?php

declare(strict_types=1);

use App\Web\Auth\LoginForm;
use Yiisoft\FormModel\Field;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;

/** @var LoginForm $form */
/** @var string|null $error */
/** @var string|null $csrf */
/** @var UrlGeneratorInterface $urlGenerator */
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <h1 class="h3 text-center mb-4">Login</h1>

                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <?= Html::encode($error) ?>
                        </div>
                    <?php endif ?>

                    <form method="post" action="<?= $urlGenerator->generate('auth/login') ?>">
                        <input type="hidden" name="_csrf" value="<?= $csrf ?>">

                        <?= Field::text($form, 'email')
                            ->label('Email')
                            ->inputClass('form-control')
                            ->containerClass('mb-3') ?>

                        <?= Field::password($form, 'password')
                            ->label('Password')
                            ->inputClass('form-control')
                            ->containerClass('mb-3') ?>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                        </div>

                        <div class="text-center">
                            <span class="text-muted">Don't have an account?</span>
                            <?= Html::a(
                                'Register',
                                $urlGenerator->generate('auth/register'),
                                ['class' => 'text-decoration-none']
                            ) ?>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>