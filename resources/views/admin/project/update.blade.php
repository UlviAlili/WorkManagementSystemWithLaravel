@extends('layouts.master')
@section('title','Update Project')
@section('content')

    <div class="card shadow mb-4">

        <div class="card-header">
            <h6 class="m-0 font-weight-bold float-right text-primary">
                <a href="{{route('admin.project.index')}}" class="btn btn-primary btn-sm">All Projects</a></h6>
        </div>
        <div class="card-body">

            <form method="post" id="FrmUpdateProject" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Project Name</label>
                            <input type="text" name="title" class="form-control" value="{{$project->name}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Project Status</label>
                            <select name="status" class="form-control">
                                <option value="1" @if($project->status == 'Not Started') selected @endif>Not
                                    Started
                                </option>
                                <option value="2" @if($project->status == 'In Progress') selected @endif>In
                                    Progress
                                </option>
                                <option value="3" @if($project->status == 'Done') selected @endif>Done</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Project Team Members</label>
                    <select class="form-control selectpicker " multiple data-live-search="true" name="member[]">
                        <option value="0" disabled>Select Team Member</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}"
                                    @foreach($select as $sel)
                                        @if($sel == $user->id ) selected @endif
                                @endforeach>{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Project Description</label>
                    <textarea id="editor" name="contents" class="form-control"
                              rows="4">{{$project->description}}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block" id="mySubmit">Update Project &nbsp;<span
                            class="myLoad"></span></button>
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
                {'height': 180}
            );
        });
    </script>

    <script>
        $(function () {
            $('#FrmUpdateProject').submit(function (e) {
                e.preventDefault();
                $('.myLoad').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                $('#mySubmit').prop('disabled', true);
                let myData = $(this).serialize();
                $.ajax({
                    method: 'put',
                    url: '{{route('admin.project.update',$project->id)}}',
                    data: myData,
                    success: function (response) {
                        $('.myLoad').html('');
                        $('#mySubmit').prop('disabled', false);
                        window.location.href = response.url;
                    },
                    error: function (response) {
                        $('#FrmUpdateProject').find('.text-danger').remove();
                        $('.myLoad').html('');
                        $('#mySubmit').prop('disabled', false);
                        $.each(response.responseJSON.errors, function (key, value) {
                            let input = $('#FrmUpdateProject').find('input[name^=' + key + ']');
                            let input2 = $('#FrmUpdateProject').find('textarea[name^=' + key + ']');
                            input.parents('.form-group').append(`<small class="row text-danger ml-1">${value}</small>`);
                            input2.parents('.form-group').append(`<small class="row text-danger ml-1">${value}</small>`);
                        });
                    }
                });
            });
        });
    </script>
@endsection
