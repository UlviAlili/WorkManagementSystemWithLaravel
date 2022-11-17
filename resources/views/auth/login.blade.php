<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Work Management System - Login</title>

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

    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">

                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>

                                @if(session('wrong'))
                                    <div class="alert alert-danger">{{session('wrong')}}</div>
                                @endif

                                <form class="user" method="post" id="FrmLogin">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <input type="text" name="email" class="form-control form-control-user"
                                                   id="exampleInputEmail" aria-describedby="emailHelp"
                                                   placeholder="Enter Email Address...">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <input type="password" name="password"
                                                   class="form-control form-control-user"
                                                   id="exampleInputPassword" placeholder="Password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" name="remember" class="custom-control-input"
                                                   id="remember">
                                            <label class="custom-control-label" for="remember">Remember
                                                Me</label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block" id="mySubmit">
                                        Login &nbsp; <span class="myLoad"></span>
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{route('register')}}">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Core plugin JavaScript-->
<script src="{{asset('/back/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('/back/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Bootstrap core JavaScript-->
<script src="{{asset('/back/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Custom scripts for all pages-->
<script src="{{asset('/back/js/sb-admin-2.min.js')}}"></script>

<script>
    $(function () {
        $("#FrmLogin").submit(function (e) {
            e.preventDefault();
            $(".myLoad").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $("#mySubmit").prop("disabled", true);

            let myData = $(this).serialize();
            $.ajax({
                method: "post",
                url: "{{route('loginPost')}}",
                data: myData,
                success: function (response) {
                    $(".myLoad").html("");
                    $("#mySubmit").prop("disabled", false);
                    window.location.href = response.url;
                },
                error: function (response) {
                    $('#FrmLogin').find('.text-danger').remove();
                    $(".myLoad").html("");
                    $("#mySubmit").prop("disabled", false);
                    $.each(response.responseJSON.errors, function (key, value) {
                        let input = $('#FrmLogin').find('input[name^=' + key + ']');
                        input.parents('.form-group').append(`<small class="text-danger ml-4">${value}</small>`)
                    });
                }
            });
        });
    });
</script>

</body>
</html>
