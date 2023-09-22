<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Role;
use Auth;

class RoleCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){

            // $user = User::find(2);
            // $user->roles()->detach(1);
            //Auth::user()->roles()->sync(1);

            if(Auth::user()->roles()->where('role_name','user')->exists()){

                return $next($request);

            } else if(Auth::user()->roles()->where('role_name','admin')->exists()){

                return redirect('/dashboard');

            } else {

                return redirect('/homePage')->with('message', 'Brak dostępu!');

            }
        } else {

            return redirect('/auth/login')->with('message', 'Zaloguj się!');

        }

        return $next($request);
    }
}
