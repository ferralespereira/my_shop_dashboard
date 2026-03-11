<?php

declare(strict_types=1);

use Yiisoft\FormModel\Field;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;

/** @var Form $form */
/** @var bool $isNew */
/** @var string $id */
/** @var UrlGeneratorInterface $urlGenerator */
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">
                            <?= $isNew ? 'Create Category' : 'Edit Category' ?>
                        </h1>
                        <?= Html::a(
                            '← Back',
                            $urlGenerator->generate('business-category/list'),
                            ['class' => 'btn btn-outline-secondary btn-sm']
                        ) ?>
                    </div>

                    <form method="post" action="<?= $urlGenerator->generate('business-category/edit', ['id' => $id]) ?>">
                        <input type="hidden" name="_csrf" value="<?= $csrf ?>">

                        <?= Field::text($form, 'name')
                            ->label('Name')
                            ->inputClass('form-control')
                            ->containerClass('mb-3') ?>

                        <?= Field::textarea($form, 'description')
                            ->label('Description')
                            ->inputClass('form-control')
                            ->containerClass('mb-3') ?>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <?= $isNew ? 'Create' : 'Save Changes' ?>
                            </button>
                            <?= Html::a(
                                'Cancel',
                                $urlGenerator->generate('business-category/list'),
                                ['class' => 'btn btn-outline-secondary']
                            ) ?>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>