<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        $userTask = Task::where('user_id', Auth::user()->id)->get();

        $projects = Project::all();
        $userProject = null;
        foreach ($projects as $project) {
            foreach ($project->users->pluck('id')->toArray() as $id) {
                if ($id == Auth::user()->id) {
                    $userProject[] = $project;
                }
            }
        }

        return view('user.dashboard', compact('userProject', 'userTask'));
    }

    public function indexDataTable()
    {
        $projects = Project::all();
        $userProject = null;
        foreach ($projects as $project) {
            foreach ($project->users->pluck('id')->toArray() as $id) {
                if ($id == Auth::user()->id) {
                    $userProject[] = $project;
                }
            }
        }

        return DataTables::of($userProject)
            ->editColumn('created_at', function (Project $project) {
                return date('d/m/Y H:i:s', strtotime($project->created_at));;
            })
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
            ->addColumn('member', function (Project $project) {
                return $project->users()->count();
            })
            ->addColumn('task', function (Project $project) {
                return $project->tasks()->count();
            })
            ->editColumn('name', function (Project $project) {
                return '<a href="' . route('user.project.show', $project->id) . '">' . $project->name . "</a>";
            })
            ->editColumn('operations', 'user/project/operations')
            ->rawColumns(['status', 'description', 'operations', 'name'])
            ->make(true);
    }

    public function project_index()
    {
        $tasks = Task::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->get();

        return view('user.project.index', compact('tasks'));
    }

    public function store(TaskRequest $request)
    {
        $validated = $request->validated();
        $task = Task::create([
            'name' => $validated['title'],
            'admin_id' => Auth::user()->id,
            'project_id' => $validated['project'],
            'user_id' => Auth::user()->id,
            'description' => '',
            'status' => 1
        ]);

        session()->flash('message', 'Task Create Successfully');
        return response()->json(['url' => route('user.project.show', $validated['project'])]);

//        return response()->json(['view' => view('admin.project.task', compact('task'))->render(), 'message' => 'Task Create Successfully']);
    }

    public function projectShow($id)
    {
        $project = Project::findOrFail($id);

        return view('user.project.show', compact('project'));
    }

    public function update(TaskRequest $request, $id)
    {
        $validated = $request->validated();
        $task = Task::findOrFail($id);
        $task->update([
            'name' => $validated['title'],
            'project_id' => $validated['project'],
            'status' => $validated['status'],
            'user_id' => Auth::user()->id,
            'description' => !isset($validated['contents']) ? '' : $validated['contents']
        ]);


        session()->flash('message', 'Task Update Successfully');
        return response()->json(['url' => route('user.project.show', Project::where('id', $task->project_id)->first()->id)]);
    }


    public function taskSortable(Request $request, $project_id)
    {
        //Start Get Id
        $dataToDo = $request->get('order1');
        $toDo = array_map('intval', preg_split('/(=|&)/', $dataToDo));
        foreach ($toDo as $i) {
            if ($i != 0) {
                $idToDo[] = $i; // all id in To Do
            } else {
                $idToDo[] = '';
            }
        }
        $dataInProgress = $request->get('order2');
        $inProgress = array_map('intval', preg_split('/(=|&)/', $dataInProgress));
        foreach ($inProgress as $i) {
            if ($i != 0) {
                $idInProgress[] = $i; // All id in In Progress
            } else {
                $idInProgress[] = '';
            }
        }
        $dataDone = $request->get('order3');
        $done = array_map('intval', preg_split('/(=|&)/', $dataDone));
        foreach ($done as $i) {
            if ($i != 0) {
                $idDone[] = $i; // All id in Done
            } else {
                $idDone[] = '';
            }
        }
        //End Get Id

        //Start Change Status
        $tasks = Task::where('user_id', Auth::user()->id)->where('project_id', $project_id)->get();
        if ($idToDo != '') {
            foreach ($idToDo as $id) {
                $task = $tasks->where('id', $id)->first();
                if ($task != null) {
                    $task->update([
                        'status' => 1
                    ]);
                }
            }
        }
        if ($idInProgress != '') {
            foreach ($idInProgress as $id) {
                $task = $tasks->where('id', $id)->first();
                if ($task != null) {
                    $task->update([
                        'status' => 2
                    ]);
                }
            }
        }
        if ($idDone != '') {
            foreach ($idDone as $id) {
                $task = $tasks->where('id', $id)->first();
                if ($task != null) {
                    $task->update([
                        'status' => 3
                    ]);
                }
            }
        }
        //End Change Status
    }

    public function destroy($id)
    {
        Task::destroy($id);

        return response()->json(["message" => 'Task Deleted Successfully']);
    }
}
