@extends('layouts.master')
@section('title','Task Status')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="col-md-12">

                <h6 class="m-0 font-weight-bold float-right text-primary">
                    <p><a href="{{route('user.task.index')}}" class="btn btn-primary btn-sm">All Tasks</a></p>
                    <p><a href="{{route('user.task.edit',$task->id)}}" class="btn btn-primary btn-sm">Update Task</a>
                    </p>
                </h6>

                <div class="row">
                    <div class="col-md-6">
                        <dl>
                            <dt><b class="border-bottom border-primary">Task Name</b></dt>
                            <dd>{{$task->name}}</dd>

                            <dt><b class="border-bottom border-primary">Description</b></dt>
                            <dd>{!! $task->description !!}</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl>
                            <dt><b class="border-bottom border-primary">Status</b></dt>
                            <dd>{{$task->status}}</dd>
                        </dl>
                        <dl>
                            <dt><b class="border-bottom border-primary">Task Team Leader</b></dt>
                            <dd>{{\App\Models\User::where('id',$task->admin_id)->first()->name}}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            Members Progress/Activity<br>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">

                                        <div class="card-header">
                                            Add Comment
                                        </div>

                                        <div class="card-body">

                                            <form method="post" action="{{route('user.task.update',$task->id)}}"
                                                  enctype="multipart/form-data">
                                                @csrf

                                                <div class="form-group">
                                                    <textarea id="editor" name="contents" class="form-control"
                                                              rows="4"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Add Comment</button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if(isset($task->comments))
                                @foreach($task->comments as $comment)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">

                                                    <h5>{{\App\Models\User::where('id',$comment->user_id)->first()->name}}</h5>

                                                    <small>{{$comment->created_at}}
                                                        -- {{$comment->created_at->diffForHumans()}}</small>

                                                    @if($comment->user_id == Auth::user()->id)
                                                        <a href="{{route('user.comment.delete',$comment->id)}}"
                                                           title="Delete"
                                                           class="btn btn-sm btn-danger ml-1 float-right">Delete
                                                            Comment</a>
                                                    @endif

                                                </div>

                                                <div class="card-body">
                                                    {!! $comment->comment !!}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
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
