<?php

use App\Http\Controllers\StudentsApp\Auth\LoginController;
use App\Http\Middleware\StudentsApp\Authenticated;
use App\Http\Middleware\StudentsApp\InitializeTenant;
use App\Http\Middleware\StudentsApp\KeepSessionForeverToAuthenticatedUsers;
use App\Http\Middleware\StudentsApp\RedirectIfAuthenticated;
use App\Http\Middleware\StudentsApp\TenantNotInitialized;
use Inertia\Inertia;

Route::prefix('/students-app')
    ->middleware([
        KeepSessionForeverToAuthenticatedUsers::class,
    ])
    ->name('students-app.')
    ->group(function () {
        Route::get('/', function () {
            return Inertia::render('Index');
        })->middleware(TenantNotInitialized::class, RedirectIfAuthenticated::class)->name('index');

        Route::prefix("/{tenant}")->middleware([
            InitializeTenant::class,
        ])->name('initialized-app.')->group(function () {
            Route::prefix('/auth')->middleware([
                RedirectIfAuthenticated::class,
            ])->name('auth.')->group(function () {
                Route::get('/login', LoginController::class)->name('login');
            });

            Route::middleware([
                Authenticated::class . ':sanctum',
            ])->prefix('/app')->group(function () {
                Route::get('/', function () {
                    return 'home';
                })->name('home');
            });
        });
    });
