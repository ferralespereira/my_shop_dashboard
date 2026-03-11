<?php

declare(strict_types=1);

use App\Shared\ApplicationParams;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\View\WebView;

/**
 * @var WebView $this
 * @var ApplicationParams $applicationParams
 * @var UrlGeneratorInterface $urlGenerator
 */

$this->setTitle('About Us');
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h2 fw-bold mb-3">About <?= Html::encode($applicationParams->name) ?></h1>
                    <p class="text-muted mb-4">
                        We build tools that help teams manage their product catalog efficiently,
                        collaborate clearly, and ship updates with confidence.
                    </p>

                    <h2 class="h5 fw-semibold mt-4">What we focus on</h2>
                    <ul class="mb-4">
                        <li>Simple workflows for day-to-day operations.</li>
                        <li>Reliable dashboards with clear data visibility.</li>
                        <li>Fast and secure access for growing teams.</li>
                    </ul>

                    <h2 class="h5 fw-semibold mt-4">Our mission</h2>
                    <p class="mb-4">
                        Our mission is to make business management software practical and approachable,
                        so teams can spend less time fighting tooling and more time serving customers.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
