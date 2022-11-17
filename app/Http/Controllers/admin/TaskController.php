<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param TaskRequest $request
     * @return JsonResponse
     */
    public function store(TaskRequest $request)
    {
        $validated = $request->validated();
        $task = Task::create([
            'name' => $validated['title'],
            'admin_id' => Auth::user()->id,
            'project_id' => $validated['project'],
            'user_id' => 0,
            'description' => '',
            'status' => 1
        ]);
        session()->flash('message', 'Task Create Successfully');
        return response()->json(['url' => route('admin.project.show', $validated['project'])]);
//        return response()->json(['view' => view('admin.project.task', compact('task'))->render(), 'message' => 'Task Create Successfully']);
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
        $tasks = Task::where('project_id', $project_id)->get();
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
        $task->update([
            'name' => $validated['title'],
            'project_id' => $validated['project'],
            'status' => $validated['status'],
            'user_id' => !isset($validated['member']) ? 0 : $validated['member'],
            'description' => !isset($validated['contents']) ? '' : $validated['contents']
        ]);

        session()->flash('message', 'Task Update Successfully');
        return response()->json(['url' => route('admin.project.show', Project::where('id', $task->project_id)->first()->id)]);
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
    }
}
