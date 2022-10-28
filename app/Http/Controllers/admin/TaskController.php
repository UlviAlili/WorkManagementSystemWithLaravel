<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SelectRequest;
use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $tasks = Task::where('admin_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        return view('admin.task.index', compact('tasks'));
    }

    public function indexDataTable()
    {
        $tasks = Task::where('admin_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        return DataTables::of($tasks)
            ->addColumn('project', function (Task $task) {
                return Project::where('id', $task->project_id)->first()->name;
            })
            ->addColumn('user', function (Task $task) {
                if (User::where('id', $task->user_id)->first() == null) {
                    $name = '--';
                } else {
                    $name = User::where('id', $task->user_id)->first()->name;
                }
                return $name;
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
            ->editColumn('operations', 'admin/task/operations')
            ->rawColumns(['operations', 'description', 'status'])
            ->editColumn('created_at', function (Task $task) {
                return $task->created_at->diffForHumans();
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
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
     * @param TaskRequest $request
     * @return JsonResponse
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

        session()->flash('message', 'Task Create Successfully');
        return response()->json(['url' => route('admin.task.index')]);
//        return redirect()->route('admin.task.index')->with('message', 'Task Create Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
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
     * @return Application|Factory|View
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
     * @param TaskRequest $request
     * @param int $id
     * @return JsonResponse
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

        session()->flash('message', 'Task Update Successfully');
        return response()->json(['url' => route('admin.task.index')]);
//        return redirect()->route('admin.task.index')->with('message', 'Task Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        Task::destroy($id);

        return response()->json(["message" => 'Task Deleted Successfully']);
//        return redirect()->back()->with('message', 'Task Deleted Successfully');
    }
}
