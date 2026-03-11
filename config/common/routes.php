<?php

declare(strict_types=1);

use App\Web;
use App\Web\Auth\AuthMiddleware;
use App\Web\Auth\LoginAction;
use App\Web\Auth\LogoutAction;
use App\Web\Auth\RegisterAction;
use App\Web\BusinessCategory\DeleteAction;
use App\Web\BusinessCategory\EditAction;
use App\Web\BusinessCategory\ListAction;
use Yiisoft\Http\Method;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;

return [
    Group::create()
        ->routes(
            // Home
            Route::get('/')
                ->action(Web\HomePage\Action::class)
                ->name('home'),

            // Auth routes (public)
            Route::methods([Method::GET, Method::POST], '/login')
                ->action(LoginAction::class)
                ->name('auth/login'),
            Route::methods([Method::GET, Method::POST], '/register')
                ->action(RegisterAction::class)
                ->name('auth/register'),
            Route::post('/logout')
                ->action(LogoutAction::class)
                ->name('auth/logout'),

            // Business Category routes (protected)
            Group::create('/business-categories')
                ->middleware(AuthMiddleware::class)
                ->routes(
                    Route::get('')
                        ->action(ListAction::class)
                        ->name('business-category/list'),
                    Route::methods([Method::GET, Method::POST], '/{id}')
                        ->action(EditAction::class)
                        ->name('business-category/edit'),
                    Route::post('/{id}/delete')
                        ->action(DeleteAction::class)
                        ->name('business-category/delete'),
                ),
        ),
];