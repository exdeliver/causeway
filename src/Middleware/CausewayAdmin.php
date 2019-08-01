<?php

namespace Exdeliver\Causeway\Middleware;

use Closure;
use Illuminate\Http\Request;

class CausewayAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->hasRole('admin')) {
            return $next($request);
        }

        $request->session()->flash('info', '403 Forbidden...');

        return redirect()
            ->route('causeway.login');
    }
}
