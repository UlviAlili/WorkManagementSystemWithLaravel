<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function loginPost(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            if (Auth::user()->status == 'admin') {
                return redirect()->route('admin.dashboard')->with('message', 'Welcome back ' . Auth::user()->name);
            } else {
                return redirect()->route('user.dashboard')->with('message', 'Welcome back ' . Auth::user()->name);
            }
        }

        return redirect()->route('login')->withErrors('These credentials do not match our records.');
    }

    public function registerPost(RegisterRequest $request)
    {
        $validated = $request->validated();
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'status' => 'admin',
            'password' => bcrypt($validated['password'])
        ]);

        return redirect()->route('login')->with('success', 'Registration Successfully');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
