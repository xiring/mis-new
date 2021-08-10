<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AccountantMiddleware
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
        if(Auth::check()) {
            switch (Auth::user()->user_type) {
                case 6:
                    Session::put('school_id', Auth::user()->accountant->school->id);
                    return $next($request);
                    break;

                default:
                    return redirect('/login');
                    break;
            }
        }else{
            return redirect('/login');
        }
    }
}
