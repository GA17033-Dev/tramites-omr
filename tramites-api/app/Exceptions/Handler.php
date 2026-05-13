<?php

namespace App\Exceptions;

use App\Helpers\Http;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;


class Handler extends ExceptionHandler
{
    /** @var array<int, string> */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (Throwable $e, Request $request) {
            if (! $request->is('api/*') && ! $request->expectsJson()) {
                return null;
            }

            if ($e instanceof ValidationException) {
                return Http::respuesta(Http::RET_VALIDATION, null, $e->errors());
            }

            if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                return Http::respuesta(Http::RET_NOT_FOUND, $e->getMessage() ?: 'Recurso no encontrado');
            }

            if ($e instanceof MethodNotAllowedHttpException) {
                return Http::respuesta(Http::RET_ERROR, 'Método HTTP no permitido para este endpoint');
            }

            if ($e instanceof AuthenticationException) {
                return Http::respuesta(Http::RET_UNAUTH);
            }

            if ($e instanceof HttpExceptionInterface) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: 'Error en la solicitud',
                    'errors'  => (object) [],
                ], $e->getStatusCode());
            }

            return Http::respuesta(Http::RET_ERROR, 'Error interno del servidor');
        });
    }
}
