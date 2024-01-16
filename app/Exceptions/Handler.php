<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
            $flashableExceptions = [
                ModelNotFoundException::class,
                AuthorizationException::class,
            ];

            if (!$request->routeIs('app.dashboard.*') || !in_array(get_class($e), $flashableExceptions)) {
                return parent::render($request, $e);
            }

            $message = $e->getMessage();

            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                $message = 'Registro não encontrado.';
            }

            if ($e instanceof AuthorizationException) {
                $message = 'Você não tem permissão para performar essa ação.';
            }

            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => $message,
            ]);
        }
    }
}
