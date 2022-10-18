@extends('layouts.master')
@section('title','Task Update')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-right text-primary">
                <a href="{{route('user.task.status',$task->id)}}" class="btn btn-primary btn-sm">View Task</a>
            </h6>
            <h6 class="m-0 font-weight-bold float-left text-primary"><a href="{{route('user.task.index')}}"
                                                                        class="btn btn-primary btn-sm">All Tasks</a>
            </h6>
        </div>

        <div class="col-md-12 mt-3 ml-3">
            <div class="row">
                <div class="col-md-6">
                    <dl>
                        <dt><b class="border-bottom border-primary">Project Name</b></dt>
                        <dd>{{\App\Models\Project::where('id',$task->project_id)->first()->name}}</dd>

                        <dt><b class="border-bottom border-primary">Project Team Leader</b></dt>
                        <dd>{{\App\Models\User::where('id',$task->admin_id)->first()->name}}</dd>
                    </dl>
                </div>

                <div class="col-md-6">

                    <dl>
                        <dt><b class="border-bottom border-primary">Task Name</b></dt>
                        <dd>{{$task->name}}</dd>
                    </dl>

                    <dl>
                        <dt><b class="border-bottom border-primary">Task Description</b></dt>
                        <dd>{!! $task->description !!}</dd>
                    </dl>

                </div>
            </div>
        </div>
        <hr>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </div>
            @endif

            <form method="post" action="{{route('user.task.update',$task->id)}}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Task Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1" @if($task->status == 'Not Started') selected @endif>Not Started
                                </option>
                                <option value="2" @if($task->status == 'In Progress') selected @endif>In Progress
                                </option>
                                <option value="3" @if($task->status == 'Done') selected @endif>Done</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Task Comment</label>
                    <textarea id="editor" name="contents" class="form-control"
                              rows="4"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Task</button>
                </div>

            </form>
        </div>
    </div>

@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#editor').summernote(
                {'height': 300}
            );
        });
    </script>
@endsection
