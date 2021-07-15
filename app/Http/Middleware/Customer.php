<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Customer
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
        if (Auth::check() && Auth::user()->isCustomer() || Auth::user()->isAdmin()) {
            return $next($request);
        } else {
            abort(403, 'ไม่มีสิทธิ์เข้าถึง');
            //return redirect('/');
            return response()->json(
                [
                    "error" => "ไม่มีสิทธิ์เข้าถึง",
                    "status" => 9999
                ],
                403
            );
            // abort(403, 'Unauthorized action.');
        }
    }
}
