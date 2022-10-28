@extends('layouts.master')
@section('title','Create New User')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-left text-primary">@yield('title')</h6>
            <h6 class="m-0 font-weight-bold float-right text-primary">
                <a href="{{route('admin.addUser.index')}}" class="btn btn-primary btn-sm">All Team Members</a></h6>
        </div>

        <div class="card-body">
            <form method="post" id="FrmAddUser" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{old('name')}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{old('email')}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">

                            <small class="text-muted ml-1">
                                Use 6 or more characters with a mix of letters and numbers.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Repeat Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block" id="mySubmit">Create User &nbsp; <span
                            class="myLoad"></span></button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(function () {
            $('#FrmAddUser').submit(function (e) {
                e.preventDefault();
                $('.myLoad').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                $('#mySubmit').prop('disabled', true);
                let myData = $(this).serialize();
                $.ajax({
                    method: 'post',
                    url: '{{route('admin.addUser.store')}}',
                    data: myData,
                    success: function (response) {
                        $('.myLoad').append('');
                        $('#mySubmit').prop('disabled', false);
                        window.location.href = response.url;
                    },
                    error: function (response) {
                        $('#FrmAddUser').find('.text-danger').remove();
                        $('.myLoad').html('');
                        $('#mySubmit').prop('disabled', false);
                        $.each(response.responseJSON.errors, function (key, value) {
                            let input = $('#FrmAddUser').find('input[name^=' + key + ']')
                            if (value.length > 1) {
                                $.each(value, function (index, message) {
                                    input.parents('.form-group').append(`<small class="row text-danger ml-1">${message}</small>`)
                                })
                            } else {
                                input.parents('.form-group').append(`<small class="row text-danger ml-1">${value}</small>`)
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
