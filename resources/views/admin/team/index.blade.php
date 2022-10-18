@extends('layouts.master')
@section('title','All Users')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-left text-primary">@yield('title')</h6>
            <h6 class="m-0 font-weight-bold float-right text-primary">{{$users->count()}} users found.
                <a href="{{route('admin.addUser.create')}}" class="btn btn-primary btn-sm">Add New User</a>
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Task Count</th>
                        <th>Operations</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($users as $user)
                        <tr>
                            <td>{{++$loop->index}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->status}}</td>
                            <td>{{$user->tasks()->count()}}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{route('admin.addUser.show',$user->id)}}" title="View"
                                       class="btn btn-sm btn-success"><i
                                            class="fa fa-eye"></i></a>
                                    <form method="post" action="{{route('admin.addUser.destroy',$user->id)}}"
                                          class="ml-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete"
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
