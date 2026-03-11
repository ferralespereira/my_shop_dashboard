<?php

declare(strict_types=1);

use App\Web\Auth\RegisterForm;
use Yiisoft\FormModel\Field;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;

/** @var RegisterForm $form */
/** @var string|null $error */
/** @var string|null $csrf */
/** @var UrlGeneratorInterface $urlGenerator */
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <h1 class="h3 text-center mb-4">Register</h1>

                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <?= Html::encode($error) ?>
                        </div>
                    <?php endif ?>

                    <form method="post" action="<?= $urlGenerator->generate('auth/register') ?>">
                        <input type="hidden" name="_csrf" value="<?= $csrf ?>">

                        <?= Field::text($form, 'email')
                            ->label('Email')
                            ->inputClass('form-control')
                            ->containerClass('mb-3') ?>

                        <?= Field::password($form, 'password')
                            ->label('Password')
                            ->inputClass('form-control')
                            ->containerClass('mb-3') ?>

                        <?= Field::password($form, 'passwordConfirm')
                            ->label('Confirm Password')
                            ->inputClass('form-control')
                            ->containerClass('mb-3') ?>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </div>

                        <div class="text-center">
                            <span class="text-muted">Already have an account?</span>
                            <?= Html::a(
                                'Login',
                                $urlGenerator->generate('auth/login'),
                                ['class' => 'text-decoration-none']
                            ) ?>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>