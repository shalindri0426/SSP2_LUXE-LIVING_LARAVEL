<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        //checking whether user authenticated or not, if not redirect to login
        if(!Auth::check()){
            return redirect()->route('login');
        }
        

        //if authenticated, get the role
        $authUserRole=Auth::user()->role;

        switch($role){
            case 'admin':
                if($authUserRole==0){
                    return $next($request);
                }
                break;
            case 'customer':
                if($authUserRole==1){
                    return $next($request);
                }
                break;
        }

        //redirect users according to role
        switch($authUserRole){
            case 0:
                return redirect()->route('admin');
            case 1:
                return redirect()->route('user.user');
        }

        //if no role defined
        return redirect()->route('login');

    }
}
