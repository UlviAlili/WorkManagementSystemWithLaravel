@extends('layouts.master')
@section('title','Projects')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="indexUserProject" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Status</th>
                        <th>Project Member's Count</th>
                        <th>Task's Count</th>
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
            $('#indexUserProject').DataTable({
                processing: true,
                serverSide: true,
                order: [[4, 'desc']],
                ajax: '{{route('user.project.index.dataTable')}}',
                columns: [
                    {data: "name"},
                    {data: "status"},
                    {data: "member"},
                    {data: "task"},
                    {data: "created_at"},
                    {data: "operations"}
                ]
            });
        });
    </script>

@endsection
