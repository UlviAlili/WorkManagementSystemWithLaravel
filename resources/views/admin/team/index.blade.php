@extends('layouts.master')
@section('title','All Users')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-left text-primary">@yield('title')</h6>
            <h6 class="m-0 font-weight-bold float-right text-primary">
                {{$users->count()}} users found.
                <a href="{{route('admin.addUser.create')}}" class="btn btn-primary btn-sm">Add New User</a>
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="indexUser" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Task Count</th>
                        <th>Created At</th>
                        <th>Operations</th>
                    </tr>
                    </thead>


                    {{--                    <tbody>--}}

                    {{--                    @foreach($users as $user)--}}
                    {{--                        <tr>--}}
                    {{--                            <td>{{++$loop->index}}</td>--}}
                    {{--                            <td>{{$user->name}}</td>--}}
                    {{--                            <td>{{$user->email}}</td>--}}
                    {{--                            <td>{{$user->status}}</td>--}}
                    {{--                            <td>{{$user->tasks()->count()}}</td>--}}
                    {{--                            <td>--}}
                    {{--                                <div class="d-flex">--}}
                    {{--                                    <a href="{{route('admin.addUser.show',$user->id)}}" title="View"--}}
                    {{--                                       class="btn btn-sm btn-success"><i--}}
                    {{--                                            class="fa fa-eye"></i></a>--}}
                    {{--                                    <form method="post" class="ml-1 FrmDeleteUser"--}}
                    {{--                                          data-url="{{route('admin.addUser.destroy',$user->id)}}">--}}
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
            // let count = 0;
            $('#indexUser').DataTable({
                processing: true,
                serverSide: true,
                order: [[0, 'desc']],
                ajax: '{{route('admin.create-dataTable-user')}}',
                columns: [
                    {
                        data: "id"
                        // ,render: function () {
                        //     return ++count;  }
                    },
                    {data: "name"},
                    {data: "email"},
                    {data: "status"},
                    {data: "task"},
                    {data: "created_at"},
                    {data: "operations"}
                ]
            });
        });
    </script>

    <script>
        $(function () {
            $(document).on('submit', '.FrmDeleteUser', function (e) {
                e.preventDefault();
                let userUrl = $(this).data('url');
                let parentTr = $(this).parent().closest('tr');
                if (confirm("Do you want to remove this user?")) {
                    $.ajax({
                        url: userUrl,
                        type: 'DELETE',
                        data: {_token: '{{csrf_token()}}'},
                        success: function (response) {
                            // console.log(response);
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
