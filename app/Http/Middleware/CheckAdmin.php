<?php

namespace App\Http\Middleware;

use Auth;
use Gate;
use Closure;

class CheckAdmin
{
    /**
     * Restrict access to admin area is the authenticated user is not an admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Auth::check() && Gate::allows('isUser')) {
            return redirect('/profile');
        }

        return $next($request);
    }
}
