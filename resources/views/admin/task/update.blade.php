@extends('layouts.master')
@section('title','Update Task')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-left text-primary">@yield('title')</h6>
            <h6 class="m-0 font-weight-bold float-right text-primary">
                <a href="{{route('admin.task.index')}}" class="btn btn-primary btn-sm">All Tasks</a></h6>
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </div>
            @endif

            <form method="post" action="{{route('admin.task.update',$task->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Task Name</label>
                            <input type="text" name="title" class="form-control" value="{{$task->name}}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Project Name</label>
                    <select class="form-control" name="project">
                        <option value="{{$project->id}}">{{$project->name}}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Task Team Member</label>
                    <select class="form-control" name="member">
                        <option value="0" @if($task->user_id == 0) selected @endif>Select Team Member</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}"
                                    @if($task->user_id == $user->id) selected @endif>{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Task Description</label>
                    <textarea id="editor" name="contents" class="form-control"
                              rows="4">{{$task->description}}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Update Task</button>
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