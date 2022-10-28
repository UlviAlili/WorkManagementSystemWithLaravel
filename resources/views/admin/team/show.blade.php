@extends('layouts.master')
@section('title','Team Member')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="col-md-12">
                <h6 class="m-0 font-weight-bold float-right text-primary">
                    <p><a href="{{route('admin.addUser.index')}}" class="btn btn-primary btn-sm">All Team </a></p>
                </h6>

                <div class="row">
                    <div class="col-md-6">
                        <dl>
                            <dt><b class="border-bottom border-primary">Full Name</b></dt>
                            <dd>{{$user->name}}</dd>

                            <dt><b class="border-bottom border-primary">Status</b></dt>
                            <dd>{{$user->status}}</dd>

                            <dt><b class="border-bottom border-primary">Email</b></dt>
                            <dd>{{$user->email}}</dd>

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
                                <table class="table table-bordered" id="showUser" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Project Name</th>
                                        <th>Task Name</th>
                                        <th>Task Description</th>
                                        <th>Task Status</th>
                                        <th>Created At</th>
                                    </tr>
                                    </thead>
                                    {{--                                    <tbody>--}}

                                    {{--                                    @foreach($user->tasks()->get() as $task)--}}
                                    {{--                                        <tr>--}}
                                    {{--                                            <td>{{++$loop->index}}</td>--}}
                                    {{--                                            <td>{{$task->name}}</td>--}}
                                    {{--                                            <td>{!! $task->description !!}</td>--}}
                                    {{--                                            <td>--}}
                                    {{--                                                <div class="@if($task->status == 'Not Started') badge badge-primary--}}
                                    {{--                                            @elseif($task->status == 'In Progress') badge badge-warning--}}
                                    {{--                                            @elseif($task->status == 'Done') badge badge-success @endif">--}}
                                    {{--                                                    {{$task->status}}</div>--}}
                                    {{--                                            </td>--}}
                                    {{--                                            <td>{{$user->where('id',$task->user_id)->first()->name}}</td>--}}
                                    {{--                                        </tr>--}}
                                    {{--                                    @endforeach--}}

                                    {{--                                    </tbody>--}}
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('#showUser').DataTable({
                processing: true,
                serverSide: true,
                order: [[0, 'desc']],
                {{--                @dd($user->id)--}}
                ajax: '{{route('admin.show-dataTable-user',$user->id)}}',
                columns: [
                    {data: "id"},
                    {data: "project"},
                    {data: "name"},
                    {data: "description"},
                    {data: "status"},
                    {data: "created_at"}
                ]
            });
        });
    </script>
@endsection
