<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class IsVerifyEmail
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
        if (!Auth::user()->isVerified()) {
            return redirect(route('customer.verify'));
            /*return redirect()->route('user.login')
                ->with('msg', 'Bạn vui lòng kích hoạt tài khoản.');*/
        }
        return $next($request);

    }

}
