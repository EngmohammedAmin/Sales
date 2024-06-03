<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function show_login_view()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {

        if (auth()->guard('admin')->attempt(['user_name' => $request->input('user_name'), 'email' => $request->input('email'), 'password' => $request->input('password')])) {

            return redirect()->route('admin.dashboard');
        } else {
            return back()->with(['error' => 'من فضلك أدخل اسم مستخدم أو كلمة مرور صحيحة']);
        }

    }

    public function logout()
    {

        auth()->logout();

        return redirect()->route('show_login_view');
    }
}