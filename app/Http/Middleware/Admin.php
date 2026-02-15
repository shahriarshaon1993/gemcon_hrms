<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Illuminate\Support\Facades\Session;

class Admin
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

        if((Auth::guard('admin')->check()))
        {
            return $next($request);
        }
        else
        {
            if($request->wantsJson()){
                return redirect()->route("autoLogOutAction")->with(['from' => "admin"]);
            } else {
                return redirect()->route('admin.login');
            }
        }
        
    }
}
