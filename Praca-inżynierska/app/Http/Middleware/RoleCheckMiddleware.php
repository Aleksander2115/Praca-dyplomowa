<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
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

            if(Auth::user()->roles()->where('user_id', '=', $user)->get() == '2'){ //DOKOŃCZYĆ

                return $next($request);

            } else if(Auth::user()->name == 'Admin Admin'){

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
