<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof BadRequestException) {
            $error = [
                'code' => $exception->getStatusCode(),
                'message' => $exception->getMessage()
            ];

            if ($exception->getDetails()) {
                $error['details'] = $exception->getDetails();
            }

            return response()->json(['error' => $error], $exception->getCode());
        }

        if ($exception instanceof BaseException) {
            $error = ['error' => ['code' => $exception->getStatusCode(), 'message' => $exception->getMessage()]];
            return response()->json($error, $exception->getCode());
        }

        if ($exception instanceof AuthenticationException) {
            $error = ['error' => ['code' => 'unauthenticated', 'message' => $exception->getMessage()]];
            return response()->json($error, 401);
        }

        if ($exception instanceof NotFoundHttpException) {
            $error = ['error' => ['code' => 'not_found', 'message' => 'API token Not Found']];
            return response()->json($error, 404);
        }
        if ($request->wantsJson()) {

            if ($exception instanceof ModelNotFoundException) {
                return response()->json(['error' => 1, 'data' => 'Resource not found'], 404);
            }
            dd($exception);
            return response()->json(['error' => [
                'data' => $exception->getMessage(),
                'error' => $exception->getFile() .' : ' . $exception->getLine(),
                'trace' => $exception->getTraceAsString()],
            ], 500);
        }
        
        return parent::render($request, $exception);
    }
}
