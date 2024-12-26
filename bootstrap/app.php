<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function ($request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated',
                    'errors' => [
                        'token' => ['Invalid or expired token']
                    ]
                ], Response::HTTP_UNAUTHORIZED);
            }
            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated',
                    'errors' => [
                        'token' => ['Invalid or expired token']
                    ]
                ], Response::HTTP_UNAUTHORIZED);
            }
        });

        $exceptions->render(function (\Throwable $e, $request) {
            if ($request->is('api/*')) {
                $status = method_exists($e, 'getStatusCode') 
                    ? $e->getStatusCode() 
                    : Response::HTTP_INTERNAL_SERVER_ERROR;

                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'errors' => method_exists($e, 'errors') ? $e->errors() : null
                ], $status);
            }
        });
    })->create();