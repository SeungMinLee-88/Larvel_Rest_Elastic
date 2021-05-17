<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use ArgumentCountError;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        TokenExpiredException::class,
        TokenInvalidException::class,
        JWTException::class,
        UnauthorizedHttpException::class,
        QueryException::class
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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {

        if (api_request() == false) {
        if ($e instanceof ModelNotFoundException or $e instanceof NotFoundHttpException) {
            return response(view('errors.notice', [
                'title'       => 'Page Not Found',
                'description' => 'Sorry, the page or resource you are trying to view does not exist.'
            ]), 404);
        }
        if ($e instanceof DeleteResourceFailedException or $e instanceof ResourceException
            or $e instanceof StoreResourceFailedException or $e instanceof UpdateResourceFailedException) {
            dd($e);
        }
        }
        if (api_request()) {
            $code = method_exists($e, 'getStatusCode')
                ? $e->getStatusCode()
                : $e->getCode();
            if ($e instanceof TokenExpiredException) {
                $message = 'token_expired';
            } else if ($e instanceof TokenInvalidException) {
                $message = 'token_invalid';
            } else if ($e instanceof JWTException) {
                $message = $e->getMessage() ?: 'could_not_create_token';
            } else if ($e instanceof NotFoundHttpException) {
                $message = $e->getMessage() ?: 'not_found';
            } else if ($e instanceof UnauthorizedHttpException){
                print_r($e->getMessage());
                $message = $e->getMessage() ?: 'Unauthorized :(';
            } else if ($e instanceof ArgumentCountError){
                print_r($e->getMessage());
                $message = $e->getMessage() ?: 'ArgumentCountError :(';
            } else if ($e instanceof Exception){
                $message = $e->getMessage() ?: 'Something broken :(';
            }

            return response()->json([
                'code' => $code ?: 400,
                'errors' => $message,
            ], $code ?: 400);
        }
        return parent::render($request, $e);
    }
}
