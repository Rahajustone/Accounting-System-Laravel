<?php

namespace AccountSystem\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class RedirectIfAdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        $auth=Auth::guard('admins');
        if ($auth->check()) {
            return redirect('/home');
        }

        return $next($request);
    }
}
