@extends('layouts.master')
@section('title','Panel')
@section('content')

    <!-- Content Row -->
    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-8">
            <div class="card shadow mb-4">

                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tasks</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Project Name</th>
                                <th>Task Name</th>
                                <th>Status</th>
                                <th>Description</th>
                                <th>Operations</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($tasks as $task)
                                <tr>
                                    <td>{{++$loop->index}}</td>
                                    <td>{{$project->where('id',$task->project_id)->first()->name}}</td>
                                    <td>{{$task->name}}</td>
                                    <td>
                                        <div class="@if($task->status == 'Not Started') badge badge-primary
                                            @elseif($task->status == 'In Progress') badge badge-warning
                                            @elseif($task->status == 'Done') badge badge-success @endif">
                                            {{$task->status}}</div>
                                    </td>
                                    <td>{!! $task->description !!}</td>
                                    <td>
                                        <div class="d-flex ">
                                            <a href="{{route('user.task.status',$task->id)}}" title="View"
                                               class="btn btn-sm btn-success">View</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-4">
            <div class="mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <a href="{{route('user.task.index')}}" class="text-decoration-none">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">

                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Tasks
                                    </div>

                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{$tasks->count()}}
                                    </div>

                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
