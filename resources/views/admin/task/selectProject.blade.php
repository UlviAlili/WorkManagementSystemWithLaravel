@extends('layouts.master')
@section('title','Select Project')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-left text-primary">@yield('title')</h6>
            <h6 class="m-0 font-weight-bold float-right text-primary">
                <a href="{{route('admin.task.index')}}" class="btn btn-primary btn-sm">All Tasks</a></h6>
        </div>

        <div class="card-body">

            <form method="post" action="{{route('admin.select-project-post')}}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Project Name</label>
                    <select class="form-control" name="project">
                        <option value="" disabled selected>Select Project</option>
                        @foreach($projects as $project)
                            <option value="{{$project->id}}">{{$project->name}}</option>
                        @endforeach
                    </select>

                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            @if(str_contains($error,'Project Name'))
                                <small class="text-danger">{{$error}}</small>
                            @endif
                        @endforeach
                    @endif

                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Create Task</button>
                </div>

            </form>
        </div>
    </div>

@endsection
