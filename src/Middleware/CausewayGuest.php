<?php

namespace Exdeliver\Causeway\Middleware;

use App\Http\Middleware\RedirectIfAuthenticated;
use Closure;
use Illuminate\Support\Facades\Auth;

class CausewayGuest extends RedirectIfAuthenticated
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param null $guard
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $request->session()->flash('info', 'Welcome back ' . auth()->user()->name . '.');
            return redirect()
                ->route('causeway.dashboard');
        }

        return $next($request);
    }
}
