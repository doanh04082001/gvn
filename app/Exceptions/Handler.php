<?php

namespace App\Exceptions;

use App\Exceptions\Traits\ApiHandler;
use App\Exceptions\Traits\JsonHandler;
use App\Exceptions\Traits\WebHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiHandler, WebHandler, JsonHandler;

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
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()) {
            $map = $this->mapExceptionResponse($e);
            extract($map);
            if ($code) {
                return $this->responseJsonError($message, $code, $status);
            }

            if (isApi() || isSaleApi()) {
                return $this->handleApiException($request, $e);
            }
        }

        if (isWeb()) {
            return $this->handleWebException($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Redirect when unauthenticate exception
     *
     * @param  \Illuminate\Http\Request  $request
     * @param AuthenticationException $exception
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return $this->responseJsonUnauthenticated();
        }

        if (Arr::get($exception->guards(), 0) == 'admin') {
            return redirect()->route('admin.login');
        }

        return redirect(webUrl());
    }
}
