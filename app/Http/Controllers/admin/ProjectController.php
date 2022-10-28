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
        $projects = Project::where('admin_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        return view('admin.project.index', compact('projects'));
    }

    public function indexDataTable()
    {
        $projects = Project::where('admin_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

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
            ->editColumn('operations', 'admin/project/operations')
            ->rawColumns(['status', 'description', 'operations'])
            ->addColumn('user', function (Project $project) {
                return $project->team_members;
            })
            ->addColumn('task', function (Project $project) {
                return $project->tasks()->count();
            })
            ->editColumn('created_at', function (Project $project) {
                return $project->created_at->diffForHumans();
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
        $id = Auth::user()->id;
        $users = User::where('admin_id', $id)->orderBy('created_at')->get();

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
            'description' => $validated['contents']
        ]);
        if (isset($validated['member'])) {
            $project->users()->sync($validated['member']);
        }

        session()->flash('message', 'Project Create Successfully');
        return response()->json(['url' => route('admin.project.index')]);
//        return redirect()->route('admin.project.index')->with('message', 'Project Create Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $user = User::all();
        $project = Project::findOrFail($id);

        return view('admin.project.show', compact('project', 'user'));
    }

    public function showDataTable($id)
    {
        $user = User::all();
        $project = Project::findOrFail($id);
        $tasks = $project->tasks()->get();
        return DataTables::of($tasks)
            ->editColumn('created_at', function (Task $task) {
                return $task->created_at->diffForHumans();
            })
            ->editColumn('status', function (Task $task) {
                if ($task->status == "Not Started") {
                    $status = 'badge bg-primary';
                } elseif ($task->status == "In Progress") {
                    $status = 'badge bg-warning';
                } elseif ($task->status == "Done") {
                    $status = 'badge bg-success';
                }
                return "<div class ='" . $status . " text-light'>" . $task->status . "</div>";
            })
            ->editColumn('user', function (Task $task) {
                if (User::where('id', $task->user_id)->first() == null) {
                    $name = '--';
                } else {
                    $name = User::where('id', $task->user_id)->first()->name;
                }
                return $name;
            })
            ->rawColumns(['status', 'description'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
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
            'description' => $validated['contents']
        ]);
        if (isset($validated['member'])) {
            $project->users()->sync($validated['member']);
        } else {
            $project->users()->detach();
        }

        session()->flash('message', 'Project Update Successfully');
        return response()->json(['url' => route('admin.project.index')]);
//        return redirect()->route('admin.project.index')->with('message', 'Project Update Successfully');
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
        $tasks = Task::where('project_id', $project->id)->get();
        foreach ($tasks as $task) {
            $task->delete();
        }
        $project->users()->detach();
        $project->destroy($id);

        return response()->json(["message" => 'Project Deleted Successfully']);
//        return redirect()->back()->with('message', 'Project Deleted Successfully');
    }
}
