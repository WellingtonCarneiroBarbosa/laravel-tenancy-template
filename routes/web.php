<?php

use App\Http\Middleware\InitializeTenantByUserTeam;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    InitializeTenantByUserTeam::class,
])->prefix('dashboard')->name('app.')->group(function () {
    require __DIR__ . '/web/routes.php';
});

require __DIR__ . '/students-app-web/routes.php';

require __DIR__ . '/jetstream.php';
