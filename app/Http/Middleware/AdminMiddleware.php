<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->type == 1){
            return $next($request);
        }else{
            Session::flash('alert', [
                'msg' => "Invalid Request",
                'body' => "You are not authorized to access this page",
                'type' => 'warning'
            ]);
            return redirect()->route('dashboard');
        }
    }
}
