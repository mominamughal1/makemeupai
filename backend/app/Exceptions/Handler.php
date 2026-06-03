<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        if ($this->isApiRequest($request)) {
            if ($e instanceof ModelNotFoundException) {
                return $this->jsonError('Not found', 404);
            }

            if ($e instanceof AuthenticationException) {
                return $this->jsonError('Unauthenticated', 401);
            }

            if ($e instanceof ValidationException) {
                return $this->jsonError(
                    'Validation failed',
                    422,
                    $e->errors()
                );
            }

            if (app()->isProduction()) {
                return $this->jsonError('Server error', 500);
            }
        }

        return parent::render($request, $e);
    }

    protected function isApiRequest(Request $request): bool
    {
        return $request->is('api/*') || $request->expectsJson();
    }

    protected function jsonError(string $message, int $status, ?array $errors = null): JsonResponse
    {
        $payload = [
            'success' => false,
            'message' => $message,
            'data' => (object) [],
        ];

        if ($errors !== null) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }
}
