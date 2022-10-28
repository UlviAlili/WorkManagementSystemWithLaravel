@extends('layouts.master')
@section('title','All Tasks')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-left text-primary">@yield('title')</h6>
            <h6 class="m-0 font-weight-bold float-right text-primary">{{$tasks->count()}} tasks found.
                <a href="{{route('admin.project.index')}}" class="btn btn-primary btn-sm">Create New Task</a>
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="indexTask" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Project Name</th>
                        <th>Task Name</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Team Member's Name</th>
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
                    {{--                                @if($task->user_id != 0 )--}}
                    {{--                                    {{\App\Models\User::where('id',$task->user_id)->first()->name}}--}}
                    {{--                                @else--}}
                    {{--                                    ----}}
                    {{--                                @endif--}}
                    {{--                            </td>--}}

                    {{--                            <td>--}}
                    {{--                                <div class="d-flex">--}}
                    {{--                                    <a href="{{route('admin.task.show',$task->id)}}" title="View"--}}
                    {{--                                       class="btn btn-sm btn-success"><i--}}
                    {{--                                            class="fa fa-eye"></i></a>--}}
                    {{--                                    <a href="{{route('admin.task.edit',$task->id)}}" title="Edit"--}}
                    {{--                                       class="btn btn-sm btn-primary ml-1"><i class="fa fa-pen"></i></a>--}}
                    {{--                                    --}}{{--                                    <form method="post" action="{{route('admin.task.destroy',$task->id)}}"--}}
                    {{--                                    --}}{{--                                          class="ml-1">--}}
                    {{--                                    --}}{{--                                        @csrf--}}
                    {{--                                    --}}{{--                                        @method('DELETE')--}}
                    {{--                                    --}}{{--                                        <button title="Delete"--}}
                    {{--                                    --}}{{--                                                class="btn btn-sm btn-danger"--}}
                    {{--                                    --}}{{--                                                style="width: 34px"><i class="fa fa-times"></i></button>--}}
                    {{--                                    --}}{{--                                    </form>--}}
                    {{--                                    <form method="post" class="ml-1 FrmDeleteTask"--}}
                    {{--                                          data-url="{{route('admin.task.destroy',$task->id)}}">--}}
                    {{--                                        @method('DELETE')--}}
                    {{--                                        <button type="submit" title="Delete"--}}
                    {{--                                                class="btn btn-sm btn-danger"--}}
                    {{--                                                style="width: 34px"><i class="fa fa-times"></i></button>--}}
                    {{--                                    </form>--}}
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
            $('#indexTask').DataTable({
                processing: true,
                serverSide: true,
                order: [[0, 'desc']],
                ajax: '{{route('admin.create-dataTable-task')}}',
                columns: [
                    {data: "id"},
                    {data: "project"},
                    {data: "name"},
                    {data: "status"},
                    {data: "description"},
                    {data: "user"},
                    {data: "created_at"},
                    {data: "operations"}
                ]
            });
        });
    </script>

    <script>
        $(function () {
            $(document).on('submit', '.FrmDeleteTask', function (e) {
                e.preventDefault();
                let userUrl = $(this).data('url');
                let parentTr = $(this).parent().closest('tr');
                if (confirm("Do you want to remove this task?")) {
                    $.ajax({
                        url: userUrl,
                        type: 'DELETE',
                        data: {_token: '{{csrf_token()}}'},
                        success: function (response) {
                            console.log(response);
                            // window.location.reload();
                            toastr.options =
                                {
                                    "closeButton": true,
                                    "progressBar": true
                                }
                            toastr.success(response.message);
                            parentTr.remove();
                        },
                    });
                }
            });
        });
    </script>
@endsection
