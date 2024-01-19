<?php

use App\Http\Controllers\UsersApp\Auth\LoginController;
use App\Http\Middleware\UsersApp\Authenticated;
use App\Http\Middleware\UsersApp\KeepSessionForeverToAuthenticatedUsers;
use App\Http\Middleware\UsersApp\RedirectIfAuthenticated;
use Inertia\Inertia;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;
use Stancl\Tenancy\Middleware\ScopeSessions;

InitializeTenancyByPath::$onFail = function ($exception, $request) {
    return redirect()->route('users-app.index', ['shouldRedirect' => false]);
};

Route::prefix('/users-app')
    ->middleware([
        KeepSessionForeverToAuthenticatedUsers::class,
    ])
    ->name('users-app.')
    ->group(function () {
        Route::get('/', function () {
            return Inertia::render('Index');
        })->middleware(RedirectIfAuthenticated::class)->name('index');

        Route::prefix("/{tenant}")->middleware([
            InitializeTenancyByPath::class,
            ScopeSessions::class,
        ])->group(function () {
            Route::prefix('/auth')->middleware([
                RedirectIfAuthenticated::class,
            ])->name('auth.')->group(function () {
                Route::get('/login', LoginController::class)->name('login');
                Route::post('/login', [LoginController::class, 'authenticate']);
            });

            Route::middleware([
                Authenticated::class . ':sanctum',
            ])->name('app.')->prefix('/app')->group(function () {
                Route::get('/', function () {
                    return Inertia::render('App/Home');
                })->name('home');
            });
        });
    });
