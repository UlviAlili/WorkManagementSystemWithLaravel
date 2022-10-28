@extends('layouts.master')
@section('title','Task')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-right text-primary">{{$tasks->count()}} tasks found.</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="indexUserTask" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Project Name</th>
                        <th>Task Name</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Operations</th>
                    </tr>
                    </thead>
{{--                    <tbody>--}}

{{--                    @foreach($tasks as $task)--}}
{{--                        <tr>--}}
{{--                            <td>{{++$loop->index}}</td>--}}
{{--                            <td>{{\App\Models\Project::where('id',$task->project_id)->first()->name}}</td>--}}
{{--                            <td>{{$task->name}}</td>--}}
{{--                            <td>--}}
{{--                                <div class="@if($task->status == 'Not Started') badge badge-primary--}}
{{--                                            @elseif($task->status == 'In Progress') badge badge-warning--}}
{{--                                            @elseif($task->status == 'Done') badge badge-success @endif">--}}
{{--                                    {{$task->status}}</div>--}}
{{--                            </td>--}}
{{--                            <td>{!! $task->description !!}</td>--}}
{{--                            <td>--}}
{{--                                <div class="d-flex">--}}
{{--                                    <a href="{{route('user.task.status',$task->id)}}" title="View"--}}
{{--                                       class="btn btn-sm btn-success"><i--}}
{{--                                            class="fa fa-eye"></i></a>--}}
{{--                                    <a href="{{route('user.task.edit',$task->id)}}" title="Edit"--}}
{{--                                       class="btn btn-sm btn-primary ml-1"><i class="fa fa-pen"></i></a>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}

{{--                    </tbody>--}}
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('#indexUserTask').DataTable({
                processing: true,
                serverSide: true,
                order: [[0, 'desc']],
                ajax: '{{route('user.create-user-dataTable-task')}}',
                columns: [
                    {data: "id"},
                    {data: "project"},
                    {data: "name"},
                    {data: "status"},
                    {data: "description"},
                    {data: "created_at"},
                    {data: "operations"}
                ]
            });
        });
    </script>
@endsection
