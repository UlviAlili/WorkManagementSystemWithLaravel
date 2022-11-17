<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.project.index');
    }

    public function indexDataTable()
    {
        $projects = Project::where('admin_id', Auth::user()->id)->get();

        return DataTables::of($projects)
            ->editColumn('status', function (Project $project) {
                if ($project->status == "Not Started") {
                    $status = 'badge bg-primary';
                } elseif ($project->status == "In Progress") {
                    $status = 'badge bg-warning';
                } elseif ($project->status == "Done") {
                    $status = 'badge bg-success';
                }
                return "<div class ='" . $status . " text-light'>" . $project->status . "</div>";
            })
            ->editColumn('name', function (Project $project) {
                return '<a href="' . route('admin.project.show', $project->id) . '">' . $project->name . "</a>";
            })
            ->editColumn('operations', 'admin/project/operations')
            ->rawColumns(['status', 'operations', 'name'])
            ->addColumn('user', function (Project $project) {
                return $project->users()->count();
            })
            ->addColumn('task', function (Project $project) {
                return $project->tasks()->count();
            })
            ->editColumn('created_at', function (Project $project) {
                return date('d/m/Y H:i:s', strtotime($project->created_at));
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $users = User::where('admin_id', Auth::user()->id)->orderBy('created_at')->get();

        return view('admin.project.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectRequest $request
     * @return JsonResponse
     */
    public function store(ProjectRequest $request)
    {
        $validated = $request->validated();
        $project = Project::create([
            'name' => $validated['title'],
            'admin_id' => Auth::user()->id,
            'status' => $validated['status'],
            'team_members' => !isset($validated['member']) ? 0 : count($validated['member']),
            'description' => !isset($validated['contents']) ? '' : $validated['contents']
        ]);
        if (isset($validated['member'])) {
            $project->users()->sync($validated['member']);
        }

        session()->flash('message', 'Project Create Successfully');
        return response()->json(['url' => route('admin.project.index')]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $user = User::where('admin_id', Auth::user()->id)->get();
        $project = Project::findOrFail($id);
        $select = $project->users->pluck('id')->toArray();

//        return response()->json(['view' => view('admin.project.show', compact('project'))->render()]);

        return view('admin.project.show', compact('project', 'user', 'select'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $users = User::where('admin_id', Auth::user()->id)->orderBy('created_at')->get();
        $project = Project::findOrFail($id);
        $select = $project->users()->get()->pluck('id')->toArray();

        return view('admin.project.update', compact(['project', 'users', 'select']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectRequest $request
     * @param int $id
     * @return JsonResponse
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
            'description' => !isset($validated['contents']) ? '' : $validated['contents']
        ]);
        if (isset($validated['member'])) {
            $project->users()->sync($validated['member']);
        } else {
            $project->users()->detach();
        }

        session()->flash('message', 'Project Update Successfully');
        return response()->json(['url' => route('admin.project.show', $id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->destroy($id);

        return response()->json(["message" => 'Project Move to Trash']);
    }


    // Start Trash
    public function trashed()
    {
        return view('admin.project.trashed');
    }

    public function trashedDataTable()
    {
        $projects = Project::onlyTrashed()->where('admin_id', Auth::user()->id)->get();
        return DataTables::of($projects)
            ->editColumn('status', function (Project $project) {
                if ($project->status == "Not Started") {
                    $status = 'badge bg-primary';
                } elseif ($project->status == "In Progress") {
                    $status = 'badge bg-warning';
                } elseif ($project->status == "Done") {
                    $status = 'badge bg-success';
                }
                return "<div class ='" . $status . " text-light'>" . $project->status . "</div>";
            })
            ->addColumn('user', function (Project $project) {
                return $project->team_members;
            })
            ->addColumn('task', function (Project $project) {
                return $project->tasks()->count();
            })
            ->editColumn('operations', 'admin/project/trashedOperations')
            ->rawColumns(['status', 'operations'])
            ->editColumn('deleted_at', function (Project $project) {
                return date('d/m/Y H:i:s', strtotime($project->deleted_at));
            })
            ->make(true);
    }

    public function restoreProject($id)
    {
        Project::onlyTrashed()->findOrFail($id)->restore();

        return response()->json(["message" => 'Project Restore']);
    }

    public function hardDelete($id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        $tasks = Task::where('project_id', $project->id)->get();
        foreach ($tasks as $task) {
            $task->delete();
        }
        $project->users()->detach();
        $project->forceDelete();

        return response()->json(["message" => 'Project Delete Permanently']);
    }
    // End Trash

}
