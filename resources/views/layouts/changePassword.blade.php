@extends('layouts.master')
@section('title','Change Password')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <small class="text-danger mt-2 float-left">* &nbsp;indicates a required field.</small>
            <h6 class="m-0 font-weight-bold float-right text-primary">
                <a href="{{route('profile')}}" class="btn btn-primary btn-sm">Profile</a>
            </h6>
        </div>

        <div class="card-body">

            <form method="post" id="FrmChangePass" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Old Password<span style="color: red">*</span></label>
                            <input type="password" name="oldPassword" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>New Password<span style="color: red">*</span></label>
                            <input type="password" name="password" class="form-control">
                            <small class="text-muted ml-1">
                                Use 6 or more characters with a mix of letters and numbers.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Repeat Password<span style="color: red">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-warning" id="mySubmit">Change Password &nbsp;<span
                            class="myLoad"></span></button>
                </div>

            </form>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $(function () {
            $('#FrmChangePass').submit(function (e) {
                e.preventDefault();
                $('.myLoad').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                $('#mySubmit').prop('disabled', true);
                let myData = $(this).serialize();
                $.ajax({
                    method: 'post',
                    url: '{{route('postChangePass',\Illuminate\Support\Facades\Auth::user()->id)}}',
                    data: myData,
                    success: function (response) {
                        $('.myLoad').html('');
                        $('#mySubmit').prop('disabled', false);
                        toastr.options =
                            {
                                "closeButton": true,
                                "progressBar": true
                            }
                        if (response.hasOwnProperty('error')) {
                            toastr.error(response.error);
                        } else {
                            toastr.success(response.message);
                            $('input[type="password"]').val('');
                        }
                        $('#FrmChangePass').find('.text-danger').remove();
                    },
                    error: function (response) {
                        $('#FrmChangePass').find('.text-danger').remove();
                        $('.myLoad').html('');
                        $('#mySubmit').prop('disabled', false);
                        $.each(response.responseJSON.errors, function (key, value) {
                            let input = $('#FrmChangePass').find('input[name^=' + key + ']')
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
