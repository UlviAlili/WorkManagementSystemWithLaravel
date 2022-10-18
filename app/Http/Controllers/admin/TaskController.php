<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SelectRequest;
use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $tasks = Task::where('admin_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        return view('admin.task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function createTask($id)
    {
        $projects = Project::findOrFail($id);
        $users = $projects->users;

        return view('admin.task.create', compact('projects', 'users'));
    }

    public function selectProject()
    {
        $projects = Project::all();

        return view('admin.task.selectProject', compact('projects'));
    }

    public function selectProjectPost(SelectRequest $request)
    {
        $id = $request->project;

        return $this->createTask($id);
    }

    public function create()
    {
        $id = Auth::user()->id;
        $projects = Project::where('admin_id', $id)->get();
        $users = User::where('admin_id', $id)->orderBy('created_at')->get();

        return view('admin.task.create', compact('users', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TaskRequest $request)
    {
        $validated = $request->validated();
        Task::create([
            'name' => $validated['title'],
            'project_id' => $validated['project'],
            'user_id' => $validated['member'],
            'admin_id' => Auth::user()->id,
            'status' => 1,
            'description' => $validated['contents']
        ]);

        return redirect()->route('admin.task.index')->with('message', 'Task Create Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $user = User::where('id', $id)->get();
        $task = Task::findOrFail($id);

        return view('admin.task.show', compact('task', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $project = Project::findOrFail($task->project_id);
        $users = $project->users;

        return view('admin.task.update', compact(['project', 'users', 'task']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TaskRequest $request, $id)
    {
        $validated = $request->validated();
        $task = Task::findOrFail($id);
        if ($task->user_id != 0) {
            $task->update([
                'name' => $validated['title'],
                'project_id' => $validated['project'],
                'status' => 1,
                'user_id' => $validated['member'],
                'description' => $validated['contents']
            ]);
        } else {
            $task->update([
                'name' => $validated['title'],
                'project_id' => $validated['project'],
                'user_id' => $validated['member'],
                'description' => $validated['contents']
            ]);
        }

        return redirect()->route('admin.task.index')->with('message', 'Task Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Task::destroy($id);

        return redirect()->back()->with('message', 'Task Deleted Successfully');
    }
}
