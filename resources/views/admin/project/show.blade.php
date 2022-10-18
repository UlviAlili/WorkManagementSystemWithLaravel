@extends('layouts.master')
@section('title','Project')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="col-md-12">
                <h6 class="m-0 font-weight-bold float-right text-primary">
                    <p><a href="{{route('admin.project.index')}}" class="btn btn-primary btn-sm">All Projects</a></p>
                    <p><a href="{{route('admin.project.edit',$project->id)}}" class="btn btn-primary btn-sm">Update
                            Project</a></p>
                </h6>

                <div class="row">
                    <div class="col-md-6">
                        <dl>
                            <dt><b class="border-bottom border-primary">Project Name</b></dt>
                            <dd>{{$project->name}}</dd>
                            <dt><b class="border-bottom border-primary">Description</b></dt>
                            <dd>{!! $project->description !!}</dd>
                        </dl>
                    </div>

                    <div class="col-md-6">
                        <dl>
                            <dt><b class="border-bottom border-primary">Status</b></dt>
                            <dd>{{$project->status}}</dd>
                        </dl>

                        <dl>
                            <dt><b class="border-bottom border-primary">Project Team Members</b></dt>
                            <dd>
                                @foreach($project->users()->get()->pluck('name')->toArray() as $name)
                                    <li>{{$name}}</li>
                                @endforeach
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="col-md-12">
                <div class="row">

                    <div class="col-md-2">
                        <div class="card-header">
                            Task List
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Task Name</th>
                                        <th>Task Description</th>
                                        <th>Task Status</th>
                                        <th>Task Member</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($project->tasks()->get() as $task)
                                        <tr>
                                            <td>{{++$loop->index}}</td>
                                            <td>{{$task->name}}</td>
                                            <td>{!! $task->description !!}</td>
                                            <td>
                                                <div class="@if($task->status == 'Not Started') badge badge-primary
                                            @elseif($task->status == 'In Progress') badge badge-warning
                                            @elseif($task->status == 'Done') badge badge-success @endif">
                                                    {{$task->status}}</div>
                                            </td>
                                            <td>@if(isset($user->where('id',$task->user_id)->first()->name))
                                                    {{$user->where('id',$task->user_id)->first()->name}}
                                                @else
                                                    --
                                                @endif </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
