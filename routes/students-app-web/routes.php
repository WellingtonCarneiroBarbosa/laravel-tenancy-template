<?php

use App\Http\Controllers\StudentsApp\Auth\LoginController;
use App\Http\Controllers\StudentsApp\OnBoarding\InitialOnBoardingController;
use App\Http\Middleware\StudentsApp\Authenticated;
use App\Http\Middleware\StudentsApp\HasCompletedInitialOnBoarding;
use App\Http\Middleware\StudentsApp\KeepSessionForeverToAuthenticatedUsers;
use App\Http\Middleware\StudentsApp\RedirectIfAuthenticated;
use Inertia\Inertia;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;
use Stancl\Tenancy\Middleware\ScopeSessions;

InitializeTenancyByPath::$onFail = function ($exception, $request) {
    return redirect()->route('students-app.index', ['shouldRedirect' => false]);
};

Route::prefix('/students-app')
    ->middleware([
        KeepSessionForeverToAuthenticatedUsers::class,
    ])
    ->name('students-app.')
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
                Route::middleware([
                    HasCompletedInitialOnBoarding::class,
                ])->group(function () {
                    Route::get('/', function () {
                        return Inertia::render('App/Home');
                    })->name('home');
                });

                Route::get('/initial-on-boarding', InitialOnBoardingController::class)->name('initial-on-boarding');
            });
        });
    });
