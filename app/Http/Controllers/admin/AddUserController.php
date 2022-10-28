<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use function Sodium\increment;

class AddUserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $id = Auth::user()->id;
        $users = User::where('admin_id', $id)->get();

        return view('admin.team.index', compact('users'));
    }

    public function indexDataTable()
    {
        $id = Auth::user()->id;
        $data = User::where('admin_id', $id)->get();
        return DataTables::of($data)
            ->addColumn('task', function ($user) {
                return $user->tasks->count();
            })
            ->editColumn('operations', 'admin/team/operations')
            ->rawColumns(['operations'])
            ->editColumn('created_at', function (User $user) {
                return $user->created_at->diffForHumans();
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
        return view('admin.team.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
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

        session()->flash('message', 'User Added Successfully');
        return response()->json(["url" => route("admin.addUser.index")]);
//        return redirect()->route('admin.addUser.index')->with('message', 'User Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.team.show', compact('user'));
    }

    public function showDataTable($id)
    {
        $user = User::findOrFail($id);
        $task = Task::where('user_id', $user->id)->get();
        return DataTables::of($task)
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
            ->rawColumns(['status', 'description'])
            ->addColumn('project', function (Task $task) {
                return Project::where('id', $task->project_id)->first()->name;
            })
            ->make(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
//        $project = Project::all();
//        dd($project->users()->where('user_id', $id)); die();
        User::destroy($id);
        $tasks = Task::where('user_id', $id)->get();
//        $projects = $project->users()->where('user_id', $id)->get();
//        dd($projects); die();
//        $projects->users()->detach();
        foreach ($tasks as $task) {
            $comments = Comment::where(['task_id' => $task->id, 'user_id' => $id])->get();
            foreach ($comments as $comment) {
                $comment->delete();
            }
            $task->user_id = 0;
            $task->status = 1;
            $task->save();
        }

        return response()->json(["message" => 'User Deleted Successfully']);
    }
}
