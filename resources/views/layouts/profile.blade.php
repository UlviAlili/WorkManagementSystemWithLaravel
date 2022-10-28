@extends('layouts.master')
@section('title','Profile')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-left text-primary">@yield('title')</h6>
            <h6 class="m-0 font-weight-bold float-right text-primary">
                <a href="{{route('changePass')}}" class="btn btn-warning btn-sm">Change Password</a>
            </h6>
        </div>

        <div class="card-body">

            <form method="post" id="FrmUpdateProfile" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{\Illuminate\Support\Facades\Auth::user()->name}}">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control"
                                   value="{{\Illuminate\Support\Facades\Auth::user()->email}}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="mySubmit">Update Profile &nbsp;<span
                            class="myLoad"></span></button>
                </div>

            </form>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $(function () {
            $('#FrmUpdateProfile').submit(function (e) {
                e.preventDefault();
                $('.myLoad').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                $('#mySubmit').prop('disabled', true);
                let myData = $(this).serialize();
                $.ajax({
                    method: 'post',
                    url: '{{route('profilePost',\Illuminate\Support\Facades\Auth::user()->id)}}',
                    data: myData,
                    success: function (response) {
                        $('.myLoad').html('');
                        $('#mySubmit').prop('disabled', false);
                        window.location.href = response.url;
                    },
                    error: function (response) {
                        $('#FrmUpdateProfile').find('.text-danger').remove();
                        $('.myLoad').html('');
                        $('#mySubmit').prop('disabled', false);
                        $.each(response.responseJSON.errors, function (key, value) {
                            let input = $('#FrmUpdateProfile').find('input[name^=' + key + ']');
                            input.parents('.form-group').append(`<small class="row text-danger ml-1">${value}</small>`);
                        });
                    }
                });
            });
        });
    </script>
@endsection
