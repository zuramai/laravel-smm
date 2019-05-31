<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class ExceptMember
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
        if(Auth::user()->level == 'Member') {
            return redirect('/');
        }
        return $next($request);
    }
}
