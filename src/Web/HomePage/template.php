<?php

declare(strict_types=1);

use App\Shared\ApplicationParams;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\View\WebView;

/**
 * @var WebView $this
 * @var ApplicationParams $applicationParams
 * @var UrlGeneratorInterface $urlGenerator
 * @var string|null $csrf
 */

$this->setTitle($applicationParams->name);
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">

                    <!-- Logo / Title -->
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Welcome Back</h2>
                        <p class="text-muted">Sign in to your dashboard</p>
                    </div>

                    <!-- Login Form -->
                    <form action="<?= $urlGenerator->generate('auth/login') ?>" method="POST">
                        <input type="hidden" name="_csrf" value="<?= $csrf ?>">

                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">Email</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="LoginForm[email]"
                                placeholder="you@example.com"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium">Password</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="LoginForm[password]"
                                placeholder="••••••••"
                                required
                            >
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">Sign In</button>
                        </div>
                    </form>

                    <!-- Register link -->
                    <div class="text-center">
                        <span class="text-muted">Don't have an account?</span>
                        <a href="<?= $urlGenerator->generate('auth/register') ?>" class="ms-1">Register</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>