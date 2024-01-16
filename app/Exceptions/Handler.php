<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if (!$request->expectsJson()) {
            $message = $e->getMessage();

            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                $message = 'Registro não encontrado.';
            }

            if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
                $message = 'Você não tem permissão para performar essa ação.';
            }

            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => $message,
            ]);
        }
    }
}
