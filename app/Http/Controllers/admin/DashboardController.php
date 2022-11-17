<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = Project::where('admin_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $users = User::where('admin_id', Auth::user()->id)->get();

        return view('admin.dashboard', compact('projects', 'users'));
    }
}
