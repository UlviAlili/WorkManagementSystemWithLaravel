@extends('layouts.master')
@section('title','Team Member')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="col-md-12">
                <h6 class="m-0 font-weight-bold float-right text-primary">
                    <p><a href="{{route('admin.addUser.index')}}" class="btn btn-primary btn-sm">All Team</a></p>
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
                <div class="card-header">
                    <b>Tasks List</b>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="showUser" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Project Name</th>
                                <th>Task Name</th>
                                <th>Task Description</th>
                                <th>Task Status</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                        </table>
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
                order: [[4, 'desc']],
                ajax: '{{route('admin.addUser.show.dataTable',$user->id)}}',
                columns: [
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
