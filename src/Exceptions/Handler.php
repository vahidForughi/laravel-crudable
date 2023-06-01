<?php

namespace Generaltools\Crudable\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ProblemExeption;
use Illuminate\Validation\TokenExeption;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Generaltools\Crudable\Utils\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        AuthorizationException::class,
        NotFoundHttpException::class,
        HttpException::class,
        ModelNotFoundException::class,
        AuthenticationException::class,
        ValidationException::class,
        TokenExeption::class,
        ProblemExeption::class
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (AuthorizationException $e, $request) {
            if ($request->is('api/*')) {
                return Response::error(403, 'AuthorizationException', 'Un Authorize');
            }
        });
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return Response::error(404, 'NotFoundHttpException', 'Page Not Found');
            }
        });
        $this->renderable(function (HttpException $e, $request) {
            if ($request->is('api/*')) {
                return Response::error(404, 'HttpException', 'Not Found');
            }
        });
        $this->renderable(function (ModelNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                return Response::error(404, 'ModelNotFoundException', 'Model Not Found');
            }
        });
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return Response::error(403, 'AuthenticationException', 'Un_Authenticated');
            }
        });
        $this->renderable(function (ValidationException $e, $request) {
            if ($request->is('api/*')) {
                return Response::error(401, $e->errors(), 'Validation Exception');
            }
        });
        $this->renderable(function (TokenExeption $e, $request) {
            if ($request->is('api/*')) {
                return Response::error(401, $e->errors(), 'Token Exeption');
            }
        });
        $this->renderable(function (ProblemExeption $e, $request) {
            if ($request->is('api/*')) {
                return Response::error(401, $e->errors(), 'Problem Exeption');
            }
        });
    }
}
