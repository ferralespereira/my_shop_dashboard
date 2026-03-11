<?php

declare(strict_types=1);

use App\Domain\BusinessCategory\BusinessCategory;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;

/** @var iterable<BusinessCategory> $categories */
/** @var UrlGeneratorInterface $urlGenerator */
/** @var int $currentPage */
/** @var int $totalPages */
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">Business Categories</h1>
                        <?= Html::a(
                            'Create Category',
                            $urlGenerator->generate('business-category/edit', ['id' => 'new']),
                            ['class' => 'btn btn-primary text-white']
                        ) ?>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= Html::encode($category->name) ?></td>
                                    <td><?= Html::encode($category->description ?? '-') ?></td>
                                    <td><?= $category->createdAt->format('Y-m-d H:i') ?></td>
                                    <td>
                                        <?= Html::a(
                                            'Edit',
                                            $urlGenerator->generate('business-category/edit', ['id' => $category->id]),
                                            ['class' => 'btn btn-sm btn-warning me-1']
                                        ) ?>
                                        <form method="post" action="<?= $urlGenerator->generate('business-category/delete', ['id' => $category->id]) ?>" style="display:inline">
                                            <input type="hidden" name="_csrf" value="<?= $csrf ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                        <nav class="mt-4">
                            <ul class="pagination justify-content-center mb-0">
                                <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $currentPage - 1 ?>">← Previous</a>
                                </li>
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor ?>
                                <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Next →</a>
                                </li>
                            </ul>
                        </nav>
                    <?php endif ?>

                </div>
            </div>
        </div>
    </div>
</div>