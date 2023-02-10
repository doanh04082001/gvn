<?php

namespace App\Exceptions\Traits;

use App\Exceptions\InternalServerError;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;

trait ApiHandler
{
    /**
     * Handle Api Exception
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    private function handleApiException($request, Throwable $e)
    {
        switch (get_class($e)) {
            case AuthenticationException::class:
                return $this->responseJsonUnauthenticated();
            case ModelNotFoundException::class:
                return $this->responseJsonNotFound();
            case InternalServerError::class:
                return $this->responseJsonInternalServerError($e);
            case UnauthorizedException::class:
                return $this->responseJsonPermissionError($e);
            default:
                break;
        }

        return parent::render($request, $e);
    }
}
