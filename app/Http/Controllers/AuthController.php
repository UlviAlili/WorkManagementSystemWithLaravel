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
            session()->flash('message', 'Welcome back ' . Auth::user()->name);
            if (Auth::user()->status == 'admin') {
                return response()->json(['url' => route('admin.dashboard')]);
            } else {
                return response()->json(['url' => route('user.dashboard')]);
            }
        }
        session()->flash('wrong','These credentials do not match our records.');
        return response()->json(['url' => route('login')]);
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
        Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        session()->flash('message', 'Welcome ' . Auth::user()->name);
        return response()->json(['url' => route('admin.dashboard')]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
