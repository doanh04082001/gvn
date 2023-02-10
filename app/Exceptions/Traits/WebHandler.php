<?php

namespace App\Exceptions\Traits;

use App\Exceptions\UserAccess\UserBlockException;
use Illuminate\Http\Response;
use Throwable;

trait WebHandler
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
    private function handleWebException($request, Throwable $e)
    {
        if ($e instanceof UserBlockException) {
            auth()->logout();
            
            session()->forget(['current_store', 'user', 'cart']);

            abort(Response::HTTP_FORBIDDEN, __('app.messages.error.user_has_been_blocked'));
        }

        return parent::render($request, $e);
    }
}
