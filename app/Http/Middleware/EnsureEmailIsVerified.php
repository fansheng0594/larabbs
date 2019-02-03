<?php

namespace App\Http\Middleware;

use Closure;

class EnsureEmailIsVerified
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
        // 1.用户是否登录
        // 2.用户是否验证过email
        // 3.并且访问的不是 email 相关 或退出的url
        if ($request->user() &&
            ! $request->user()->hasVerifiedEmail() &&
            ! $request->is('email/*', 'logout')) {

            // 根据客户端返回对应内容
            return $request->expectsJson()
                ? abort('403', '您的邮箱未通过验证')
                : redirect()->route('verification.notice');
        }
        return $next($request);
    }
}

