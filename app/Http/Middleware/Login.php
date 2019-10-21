<?php

namespace App\Http\Middleware;

use Closure;

class Login
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
        //后置中间件
        $response = $next($request);
        if(!$request->session()->has('uid')){
            return redirect('week_test/login');
        }
        return $response;
    }
}
