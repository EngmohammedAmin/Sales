<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // return redirect(RouteServiceProvider::HOME);
                // write code for redirect both Admin & front in case login already done
                //اروح فين اذا انا مسجل دخول وبنفس الوقت ضغطت تسجيل دخول
                // سافحص اذا كان الركوست ادمن ولا مش ادمن ..اذا كان ادمن اروح للباكندواذا غيره اروح للفرونتند الويب
                if ($request->is('admin') || $request->is('admin/*')) {
                    //redirect to backend
                    return redirect(RouteServiceProvider::Admin);
                } else {
                    //redirect to frontend if there is but now not found so redirect backend
                    //return redirect(RouteServiceProvider::HOME); this is for frontend
                    return redirect(RouteServiceProvider::Admin);

                }
            }

        }

        return $next($request);
    }
}