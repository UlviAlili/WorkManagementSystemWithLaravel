@extends('layouts.master')
@section('title','Create New Project')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-left text-primary">@yield('title')</h6>
            <h6 class="m-0 font-weight-bold float-right text-primary">
                <a href="{{route('admin.project.index')}}" class="btn btn-primary btn-sm">All Projects</a></h6>
        </div>

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </div>
            @endif

            <form method="post" action="{{route('admin.project.store')}}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Project Name</label>
                            <input type="text" name="title" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Project Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Not Started</option>
                                <option value="2">In Progress</option>
                                <option value="3">Done</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Project Team Members</label>
                    <select class="form-control selectpicker" multiple data-live-search="true" name="member[]">
                        <option value="0" disabled>Select Team Member</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Project Description</label>
                    <textarea id="editor" name="contents" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Create Project</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"
          rel="stylesheet">
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#editor').summernote(
                {'height': 300}
            );
        });
    </script>
@endsection
