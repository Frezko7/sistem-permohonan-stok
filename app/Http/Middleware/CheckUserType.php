<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $usertype
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $usertype)
    {
        if (Auth::check() && Auth::user()->usertype === $usertype) {
            return $next($request);
        }

        // Redirect or abort if usertype does not match
        return redirect('/'); // Change to desired redirect route
    }
}
