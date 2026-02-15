<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        switch ($guard) {
            case 'admin':
                if(Auth::guard($guard)->check()){
                  return redirect(route('admin.home'));
                }
                break;
            case 'user':
                if(Auth::guard($guard)->check()){
                  return redirect(route('hrm.home'));
                }
                break;
            case 'payroll':
                if(Auth::guard($guard)->check()){
                  return redirect(route('payroll.home'));
                }
                break;
            default:
                if (Auth::guard($guard)->check()) {
                    return response(["res"=>"exist"]);
                }
                break;
        }

        return $next($request);
    }

}
