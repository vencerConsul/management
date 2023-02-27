<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsApprove
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
        if(Auth::check()){
            if(Auth::user()->status == 'approved'){
                return $next($request);
            }else{
                return redirect(route('dashboard'))->with('warning', 'Your account is currently pending approval. Please contact the administrator for further information.');
            }
        }else{
            return redirect(route('landing'))->with('warning', 'Login first.');
        }
    }
}
