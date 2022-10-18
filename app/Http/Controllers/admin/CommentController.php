<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function update(CommentRequest $request, $id)
    {
        $validated = $request->validated();
        if (isset($validated['contents']))
            Comment::create([
                'comment' => $validated['contents'],
                'task_id' => $id,
                'user_id' => \Auth::user()->id
            ]);

        return redirect()->route('admin.task.show', $id)->with('message', 'Comment Added Successfully');
    }

    public function delete($id)
    {
        Comment::destroy($id);

        return redirect()->back()->with('message', 'Comment Delete Successfully');
    }
}
