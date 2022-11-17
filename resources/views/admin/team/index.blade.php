@extends('layouts.master')
@section('title','All Users')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-right text-primary">
                <a href="{{route('admin.addUser.create')}}" class="btn btn-primary">Add New User</a>
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
                        <th>Task Count</th>
                        <th>Created At</th>
                        <th>Operations</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('#indexUser').DataTable({
                processing: true,
                serverSide: true,
                order: [[0, 'desc']],
                ajax: '{{route('admin.addUser.index.dataTable')}}',
                columns: [
                    {data: "id"},
                    {data: "name"},
                    {data: "email"},
                    {data: "task"},
                    {data: "created_at"},
                    {data: "operations"}
                ]
            });
        });

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
