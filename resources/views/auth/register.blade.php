<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Work Management System - Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('/back/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('/back/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<div class="container">
    <div class="row justify-content-center">
        <div class="card col-xl-7 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">

                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>

                            <form class="user" method="post" id="FrmRegister">
                                @csrf

                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="text" name="name" class="form-control form-control-user"
                                               id="exampleFullName"
                                               placeholder="Full Name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="text" name="email" class="form-control form-control-user"
                                               id="exampleInputEmail"
                                               placeholder="Email Address">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="password" name="password"
                                               class="form-control form-control-user"
                                               id="exampleInputPassword" placeholder="Password">
                                    </div>

                                    <small class="text-muted ml-4">
                                        Use 6 or more characters with a mix of letters and numbers.
                                    </small>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="password" name="password_confirmation"
                                               class="form-control form-control-user"
                                               id="exampleRepeatPassword" placeholder="Repeat Password">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block" id="mySubmit">
                                    Register Account &nbsp; <span class="myLoad"></span>
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{route('login')}}">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{asset('/back/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('/back/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('/back/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('/back/js/sb-admin-2.min.js')}}"></script>

<script>
    $(function () {
        $('#FrmRegister').submit(function (e) {
            e.preventDefault()
            $(".myLoad").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $("#mySubmit").prop("disabled", true);

            let myData = $(this).serialize();
            $.ajax({
                method: "post",
                url: "{{route('registerPost')}}",
                data: myData,
                success: function (response) {
                    $(".myLoad").html("");
                    $("#mySubmit").prop("disabled", false);
                    window.location.href = response.url;
                },
                error: function (response) {
                    $('#FrmRegister').find('.text-danger').remove()
                    $(".myLoad").html("");
                    $("#mySubmit").prop("disabled", false);
                    $.each(response.responseJSON.errors, function (key, value) {
                        let input = $('#FrmRegister').find('input[name^=' + key + ']')
                        if (value.length > 1) {
                            $.each(value, function (index, message) {
                                input.parents('.form-group').append(`<small class="row text-danger ml-4">${message}</small>`)
                            })
                        } else {
                            input.parents('.form-group').append(`<small class="text-danger ml-4">${value}</small>`)
                        }
                    });
                }
            });
        });
    });
</script>

</body>
</html>
