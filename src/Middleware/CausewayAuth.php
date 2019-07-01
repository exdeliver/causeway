<?php

namespace Exdeliver\Causeway\Middleware;

use App\Http\Middleware\Authenticate;
use Illuminate\Http\Request;

/**
 * Class CausewayAuth
 * @package Exdeliver\Causeway\Middleware
 */
class CausewayAuth extends Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            $request->session()->flash('info', 'You need to be logged in to access this resource.');
            return route('causeway.login');
        }
    }
}
