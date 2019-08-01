<?php

namespace Exdeliver\Causeway\Middleware;

use App\Http\Middleware\RedirectIfAuthenticated;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class CausewayGuest extends RedirectIfAuthenticated
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param null    $guard
     *
     * @return RedirectResponse|Redirector|mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $request->session()->flash('info', 'Welcome back '.auth()->user()->name.'.');

            return redirect()
                ->route('causeway.dashboard');
        }

        return $next($request);
    }
}
