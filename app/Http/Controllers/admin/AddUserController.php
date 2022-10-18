<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AddUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $id = Auth::user()->id;
        $users = User::where('admin_id', $id)->orderBy('created_at', 'desc')->get();

        return view('admin.team.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.team.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RegisterRequest $request)
    {
        $validated = $request->validated();
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'admin_id' => Auth::user()->id,
            'status' => 'user',
            'password' => bcrypt($validated['password'])
        ]);

        return redirect()->route('admin.addUser.index')->with('message', 'User Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $project = Project::all();

        return view('admin.team.show', compact('user', 'project'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        User::destroy($id);
        $tasks = Task::where('user_id', $id)->get();

        foreach ($tasks as $task) {
            $comments = Comment::where(['task_id' => $task->id, 'user_id' => $id])->get();
            foreach ($comments as $comment) {
                $comment->delete();
            }
            $task->user_id = 0;
            $task->status = 1;
            $task->save();
        }

        return redirect()->back()->with('message', 'User Deleted Successfully');
    }
}
