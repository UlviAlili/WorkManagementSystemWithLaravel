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
        $validated = $request->validated();
        if ($validated['name'] == Auth::user()->name && $validated['email'] == Auth::user()->email) {
            return response()->json(["warning" => "Profile doesn't Change"]);
        }

        $user = User::findOrFail($id);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);

        return response()->json(["message" => "Profile Update Successfully"]);
    }

    public function changePass()
    {
        return view('layouts.changePassword');
    }

    public function postChangePass(ChangePassRequest $request, $id)
    {
        if (Hash::check($request->oldPassword, Auth::user()->password)) {
            $validated = $request->validate(['password' => 'required|min:3|confirmed']);
            $user = User::findOrFail($id);
            $user->update([
                'password' => bcrypt($validated['password'])
            ]);

            return response()->json(["message" => "Password Change Successfully"]);
        } else {

            return response()->json(["error" => "Old Password is inCorrect"]);
        }
    }
}
