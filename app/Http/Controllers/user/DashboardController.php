<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::user()->id)->get();
        $project = Project::all();

        return view('user.dashboard', compact('tasks', 'project'));
    }

    public function task()
    {
        $tasks = Task::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->get();

        return view('user.task', compact('tasks'));
    }

    public function taskStatus($id)
    {
        if (Task::where('user_id', Auth::user()->id)->first() !== null) {
            $task = Task::findOrFail($id);

            return view('user.taskStatus', compact('task'));
        } else {
            return view('user.dashboard');
        }
    }

    public function taskEdit($id)
    {
        if (Task::where('user_id', Auth::user()->id)->first() !== null) {
            $task = Task::findOrFail($id);

            return view('user.update', compact('task'));
        } else {
            return view('user.dashboard');
        }
    }

    public function taskUpdate(CommentRequest $request, $id)
    {
        if (Task::where('user_id', Auth::user()->id)->first() !== null) {
            $validated = $request->validated();
            $task = Task::findOrFail($id);

            if (isset($validated['status'])) {
                $comment = 'Task Update Successfully';
                $task->update([
                    'status' => $validated['status']
                ]);
            } else {
                $comment = 'Comment Added Successfully';
            }

            if (isset($validated['contents'])) {
                Comment::create([
                    'comment' => $validated['contents'],
                    'task_id' => $id,
                    'user_id' => \Auth::user()->id
                ]);
            }

            return redirect()->route('user.task.status', $id)->with('message', $comment);
        } else {
            return redirect()->route('user.dashboard');
        }
    }

    public function delete($id)
    {
        if (Task::where('user_id', Auth::user()->id)->first() !== null) {
            Comment::destroy($id);

            return redirect()->back()->with('message', 'Comment Delete Successfully');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
}
