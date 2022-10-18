@extends('layouts.master')
@section('title','All Projects')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-left text-primary">@yield('title')</h6>
            <h6 class="m-0 font-weight-bold float-right text-primary">{{$projects->count()}} projects found.
                <a href="{{route('admin.project.create')}}" class="btn btn-primary btn-sm">Create New Project</a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                            <td>{{ ++$loop->index }}</td>
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
                                <div class="d-flex">
                                    <a href="{{route('admin.create-task',$project->id)}}" title="Add Task"
                                       class="btn btn-sm btn-facebook"><i
                                            class="fa fa-tasks"></i></a>
                                    <a href="{{route('admin.project.show',$project->id)}}" title="View"
                                       class="btn btn-sm btn-success ml-1"><i
                                            class="fa fa-eye"></i></a>
                                    <a href="{{route('admin.project.edit',$project->id)}}" title="Edit"
                                       class="btn btn-sm btn-primary ml-1"><i class="fa fa-pen"></i></a>
                                    <form method="post" action="{{route('admin.project.destroy',$project->id)}}"
                                          class="ml-1">
                                        @csrf
                                        @method('DELETE')
                                        <button title="Delete"
                                                class="btn btn-sm btn-danger"
                                                style="width: 34px"><i class="fa fa-times"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
