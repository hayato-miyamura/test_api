<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CookieCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cookie = Cookie::get('name');

        // nameキーがあるCookieがない場合ログイン画面へリダイレクト。ある場合通常通りAPIを使用可能。
        if(empty($cookie)) {
            Auth::logout();
            return redirect('/login');
        }
        
        return $next($request);
    }
}
