<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $projects = Project::where('admin_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        return view('admin.project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $id = Auth::user()->id;
        $users = User::where('admin_id', $id)->orderBy('created_at')->get();

        return view('admin.project.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProjectRequest $request)
    {
        $validated = $request->validated();
        $project = Project::create([
            'name' => $validated['title'],
            'admin_id' => Auth::user()->id,
            'status' => $validated['status'],
            'team_members' => !isset($validated['member']) ? 0 : count($validated['member']),
            'description' => $validated['contents']
        ]);
        if (isset($validated['member'])) {
            $project->users()->sync($validated['member']);
        }

        return redirect()->route('admin.project.index')->with('message', 'Project Create Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $user = User::all();
        $project = Project::findOrFail($id);

        return view('admin.project.show', compact('project', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $id2 = Auth::user()->id;
        $users = User::where('admin_id', $id2)->orderBy('created_at')->get();
        $project = Project::findOrFail($id);
        $select = $project->users()->get()->pluck('id')->toArray();

        return view('admin.project.update', compact(['project', 'users', 'select']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProjectRequest $request, $id)
    {
        $validated = $request->validated();
        $project = Project::findOrFail($id);
        $project->update([
            'name' => $validated['title'],
            'admin_id' => Auth::user()->id,
            'status' => $validated['status'],
            'team_members' => !isset($validated['member']) ? 0 : count($validated['member']),
            'description' => $validated['contents']
        ]);
        if (isset($validated['member'])) {
            $project->users()->sync($validated['member']);
        } else {
            $project->users()->detach();
        }

        return redirect()->route('admin.project.index')->with('message', 'Project Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $tasks = Task::where('project_id', $project->id)->get();
        foreach ($tasks as $task) {
            $task->delete();
        }
        $project->users()->detach();
        $project->destroy($id);

        return redirect()->back()->with('message', 'Project Deleted Successfully');
    }
}
