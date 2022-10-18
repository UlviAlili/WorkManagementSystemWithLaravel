<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('layouts.profile');
    }

    public function postProfile(ProfileRequest $request, $id)
    {
        if ($request->name == Auth::user()->name && $request->email == Auth::user()->email) {

            return redirect()->route('profile')->with('warning', "Profile doesn't Change");
        }
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('profile')->with('message', 'Profile update Successfully');
    }

    public function changePass()
    {
        return view('layouts.changePassword');
    }

    public function postChangePass(ChangePassRequest $request, $id)
    {
        if (Hash::check($request->oldPassword, Auth::user()->password)) {
            $request->validate([
                'password' => 'required|min:3|confirmed'
            ]);
            $user = User::findOrFail($id);
            $user->password = bcrypt($request->password);
            $user->save();

            return redirect()->route('profile')->with('message', 'Password Change Successfully');
        } else {

            return redirect()->route('changePass')->with('error', 'Old Password is inCorrect');
        }
    }
}
