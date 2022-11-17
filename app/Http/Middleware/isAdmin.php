<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->status == 'admin') {
            return $next($request);
        } else {
            return response()->view('layouts.loginErrorPage');
        }
    }
}
