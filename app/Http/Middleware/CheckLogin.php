<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is not authenticated
        if (Auth::guest()) {
            // Redirect to the welcome page if not logged in
            return redirect()->route('login')->withErrors(['message'=>'You have to login first']);
            //return redirect('/');
        }

        return $next($request);
    }
}
