<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Illuminate\Support\Facades\Session;

class User
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
        if((Auth::guard('user')->check()))
        {
            return $next($request);
        }
        else
        {
            if($request->wantsJson()){
                return redirect()->route("autoLogOutAction")->with(['from' => "user"]);
            }else{
                return redirect()->route('user.login');
            }
        }
        
    }
}
