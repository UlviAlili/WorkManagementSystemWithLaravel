@extends('layouts.master')
@section('title','Create New Task')

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

            <form method="post" id="FrmAddTask" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Task Name</label>
                            <input type="text" name="title" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Project Name</label>
                    <select class="form-control" name="project">
                        <option value="{{$projects->id}}">{{$projects->name}}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Task Member</label>
                    <select class="form-control" name="member">
                        <option value="0" selected>Select Task Member</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Task Description</label>
                    <textarea id="editor" name="contents" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block" id="mySubmit">Create Task &nbsp;<span
                            class="myLoad"></span></button>
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

    <script>
        $(function () {
            $('#FrmAddTask').submit(function (e) {
                e.preventDefault();
                $('.myLoad').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                $('#mySubmit').prop('disabled', true);
                let myData = $(this).serialize();
                $.ajax({
                    method: 'post',
                    url: '{{route('admin.task.store')}}',
                    data: myData,
                    success: function (response) {
                        $('.myLoad').html('');
                        $('#mySubmit').prop('Disabled', false);
                        window.location.href = response.url;
                    },
                    error: function (response) {
                        $('#FrmAddTask').find('.text-danger').remove();
                        $('.myLoad').html('');
                        $('#mySubmit').prop('disabled', false);
                        $.each(response.responseJSON.errors, function (key, value) {
                            let input = $('#FrmAddTask').find('input[name^=' + key + ']');
                            let input2 = $('#FrmAddTask').find('textarea[name^=' + key + ']');
                            input.parents('.form-group').append(`<small class="row text-danger ml-1">${value}</small>`);
                            input2.parents('.form-group').append(`<small class="row text-danger ml-1">${value}</small>`);
                        });
                    }
                });
            });
        });

    </script>
@endsection
