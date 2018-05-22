<?php

namespace App\Http\Middleware;

use App\Library\Y;
use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


class AdminAuth
{
    /**
     * andle an incoming request.
     * @param $request
     * @param Closure $next
     * @param $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard)
    {
        Auth::shouldUse($guard);

        //无需验证的，直接过
        if ($request->is(...$this->except)) {
            return $next($request);
        }

        //未登录的，登录
        if (!Auth::check()) {
            if ($request->isMethod('ajax')) {
                return Y::error('登录已过期，请重新登录');
            } else {
                return redirect(route('login'));
            }
        }

        //检查权限
        if (!(Auth::user()->isSuper() || Auth::user()->can(Route::currentRouteName()))) {
            if ($request->isMethod('ajax')) {
                return Y::error('登录已过期，请重新登录');
            } else {
                return redirect(route('login'));
            }
        }

        //验证通过
        return $next($request);
    }

    protected $except = [
        'admin/login',
        'admin/logout',
    ];

}
