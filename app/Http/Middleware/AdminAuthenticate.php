<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuthenticate
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
        /**
         * @var \App\Models\User
         */
        $user = $request->user();

        if( !$user || !$user->isAdmin() ) {
            return redirect('/');
        }

        return $next($request);
    }
}
