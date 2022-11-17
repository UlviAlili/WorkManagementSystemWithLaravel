<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $id)
    {
        $validated = $request->validated();
        $task = Task::findOrFail($id);
        if (isset($validated['comments']))
            Comment::create([
                'comment' => $validated['comments'],
                'task_id' => $id,
                'user_id' => \Auth::user()->id
            ]);

//      return response()->json(["message" => 'Comment Added Successfully']);
        session()->flash('message', 'Comment Added Successfully');
        if (\Auth::user()->status == 'user') {
            return response()->json(['url' => route('user.project.show', Project::where('id', $task->project_id)->first()->id)]);
        } else {
            return response()->json(['url' => route('admin.project.show', Project::where('id', $task->project_id)->first()->id)]);
        }
    }

    public function delete($id)
    {
        Comment::destroy($id);

//      return response()->json(['message'=>'Comment Delete Successfully']);
        return redirect()->back()->with('message', 'Comment Delete Successfully');
    }
}
