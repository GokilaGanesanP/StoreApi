<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenRequiredException;


use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;


use Throwable;

class Handler extends ExceptionHandler
{

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    // dd(get_class($exception)); 

    public function render($request, Throwable $exception)
{
    if ($exception instanceof TokenExpiredException) {
        Log::warning('TokenExpiredException');           

        return response()->json([
            'error' => 'TokenExpiredException',
            'messages' => 'Token has expired',
        ], 401);
    }
   
    if ($exception instanceof ThrottleRequestsException) {
        Log::warning('ThrottleRequestsException');
        return response()->json([
            'error' => 'ThrottleRequestsException',
            'message' => 'Too many requests',
        ], 429);
    }
    
    if ($exception instanceof TokenInvalidException) {
        Log::warning('TokenInvalidException');           

        return response()->json([
            'error' => 'Invalid Token',
            'messages' => 'Invalid Token',
        ], 401);
    }
    
    if ($exception instanceof JWTException) {
        Log::warning('JWTException');
        return response()->json([
            'error' => 'Token is required',
            'messages' => 'Token is required',
        ], 401);
    }

    if ($exception instanceof ValidationException) {
        Log::warning('ValidationException');

        return response()->json([
            'error' => 'Validation error',
            'messages' => $exception->errors(), // Return validation errors
        ], 422);
    }

    if ($exception instanceof AuthenticationException) {
        Log::warning('AuthenticationException');

        return response()->json([
            'error' => 'Unauthenticated',
            'message' => 'You need to be logged in to access this resource.',
        ], 401);
    }

    if ($exception instanceof AuthorizationException) {
        Log::warning('AuthorizationException');

        return response()->json([
            'error' => 'Forbidden',
            'message' => 'You do not have permission to perform this action.',
        ], 403);
    }

    if ($exception instanceof ModelNotFoundException) {
        Log::warning('ModelNotFoundException');
        
        return response()->json([
            'error' => 'Not Found',
            'message' => 'The requested resource could not be found.',
        ], 404);
    }

    if ($exception instanceof NotFoundHttpException) {
        Log::warning('NotFoundHttpException');

        return response()->json([
            'error' => 'Not Found',
            'message' => 'The requested route could not be found.',
        ], 404);
    }
    
    // Default fallback to parent's render method
    return parent::render($request, $exception);
} 
}

