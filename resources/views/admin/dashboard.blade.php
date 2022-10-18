@extends('layouts.master')
@section('title','Panel')
@section('content')

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-8">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                    <h6 class="m-0 font-weight-bold float-right text-primary">
                        <a href="{{route('admin.project.create')}}" class="btn btn-primary btn-sm">Create New
                            Project</a>
                    </h6>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Project Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Team Member's Count</th>
                                <th>Task's Count</th>
                                <th>Operations</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($projects as $project)
                                <tr>
                                    <td>{{++$loop->index}}</td>
                                    <td>{{$project->name}}</td>
                                    <td>{!! $project->description !!}</td>
                                    <td>
                                        <div class="@if($project->status == 'Not Started') badge badge-primary
                                            @elseif($project->status == 'In Progress') badge badge-warning
                                            @elseif($project->status == 'Done') badge badge-success @endif">
                                            {{$project->status}}</div>
                                    </td>
                                    <td>{{$project->team_members}}</td>
                                    <td>{{$project->tasks()->count()}}</td>
                                    <td>
                                        <a href="{{route('admin.project.show',$project->id)}}" title="View"
                                           class="btn btn-sm btn-success">View</a>
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
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">

                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Projects
                                </div>

                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{$projects->count()}}
                                </div>

                            </div>
                            <div class="col-auto">
                                <i class="fas fa-layer-group fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
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
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">

                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Team Members
                                </div>

                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{$users->count()}}
                                </div>

                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
