<?php

namespace Exdeliver\Causeway\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->hasRole('admin')) {
            return $next($request);
        }

        $request->session()->flash('info', '403 Forbidden...');

        return redirect()
            ->to('/');
    }
}
