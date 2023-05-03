<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // if ($role == 'management' && session('role') != 'management') {
        //     abort(403);
        // }

        // if ($role == 'freelance' && session('role') != 'freelance') {
        //     abort(403);
        // }

        // if ($role == 'penjadwalan' && session('role') != 'penjadwalan') {
        //     abort(403);
        // }

        return $next($request);
    }
}
