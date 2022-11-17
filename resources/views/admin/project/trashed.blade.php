@extends('layouts.master')
@section('title','Trash')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-right text-primary">
                <a href="{{route('admin.project.index')}}" class="btn btn-primary btn-sm">All Projects</a>
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="indexTrashed" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Status</th>
                        <th>Team Member's Count</th>
                        <th>Task's Count</th>
                        <th>Deleted At</th>
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
            $('#indexTrashed').DataTable({
                processing: true,
                serverSide: true,
                order: [[4, 'desc']],
                ajax: '{{route('admin.project.trashed.show.dataTable')}}',
                columns: [
                    {data: "name"},
                    {data: "status"},
                    {data: "user"},
                    {data: "task"},
                    {data: "deleted_at"},
                    {data: "operations"}
                ]
            });
        });

        $(function () {
            $(document).on('submit', '.FrmDeleteTrashProject', function (e) {
                e.preventDefault();
                let userUrl = $(this).data('url');
                let parentTr = $(this).parent().closest('tr');
                if (confirm("Do you want to delete forever this project?")) {
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

        $(function () {
            $(document).on('submit', '.RestoreProject', function (e) {
                e.preventDefault();
                let userUrl = $(this).data('url');
                let parentTr = $(this).parent().closest('tr');
                if (confirm("Do you want to restore this project?")) {
                    $.ajax({
                        url: userUrl,
                        type: 'get',
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
