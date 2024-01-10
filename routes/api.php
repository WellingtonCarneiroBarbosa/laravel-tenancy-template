<?php

use App\Http\Controllers\Application\Auth\GenerateDeviceToken;
use App\Http\Middleware\Applications\API\Authenticate;
use App\Http\Middleware\InitializeTenantByHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware([
    InitializeTenantByHeader::class,
])->prefix('coach-app')->group(function () {
    Route::get('/ola-mundo', function () {
        return 'Olá mundo, o tenant id é ' . tenant('id');
    });

    Route::prefix('/auth')->group(function () {
        Route::post('/generate-token', GenerateDeviceToken::class);
    });

    Route::middleware([Authenticate::class])->group(function () {
        Route::get('/me', function (Request $request) {
            return $request->appUser();
        });
    });
});
