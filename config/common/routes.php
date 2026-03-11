<?php

declare(strict_types=1);

use App\Web;
use App\Web\BusinessCategory\DeleteAction;
use App\Web\BusinessCategory\EditAction;
use App\Web\BusinessCategory\ListAction;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;
use Yiisoft\Http\Method;

return [
    Group::create()
        ->routes(
            Route::get('/')
                ->action(Web\HomePage\Action::class)
                ->name('home'),

            // Business Category routes
            Route::get('/business-categories')
                ->action(ListAction::class)
                ->name('business-category/list'),

            Route::methods([Method::GET, Method::POST], '/business-categories/{id}')
                ->action(EditAction::class)
                ->name('business-category/edit'),

            Route::post('/business-categories/{id}/delete')
                ->action(DeleteAction::class)
                ->name('business-category/delete'),
        ),
];