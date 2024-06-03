<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request)
    {
        // اروح فين اذا انا مش مسجل دخول وضغطت على رابط صفحة
        // return $request->expectsJson() ? null : route('show_login_view');
        if (! $request->expectsJson()) {
            if ($request->is('admin') || $request->is('admin/*')) {
                //redirect to Admin login
                return route('show_login_view');

            } else {
                //redirect to front login
                //redirect to frontend if there is but now not found so redirect backend
                //return redirect(RouteServiceProvider::HOME); this is for frontend
                //return route('login');/* if ther is frontend*/

                return route('show_login_view');

            }
        }

    }
}
