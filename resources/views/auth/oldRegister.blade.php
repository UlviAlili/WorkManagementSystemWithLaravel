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
    <link href="{{asset('/back')}}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('/back')}}/css/sb-admin-2.min.css" rel="stylesheet">

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

                            <form class="user" method="post" action="{{route('registerPost')}}">
                                @csrf

                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="text" name="name" class="form-control form-control-user"
                                               id="exampleFullName"
                                               placeholder="Full Name" value="{{old('name')}}">
                                    </div>
                                    @if($errors->any())
                                        @foreach($errors->all() as $error)
                                            @if(str_contains($error,'Full Name'))
                                                <small class="text-danger ml-4">{{$error}}</small>
                                                @break
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="text" name="email" class="form-control form-control-user"
                                               id="exampleInputEmail"
                                               placeholder="Email Address" value="{{old('email')}}">
                                    </div>
                                    @if($errors->any())
                                        @foreach($errors->all() as $error)
                                            @if(str_contains($error,'Email Address'))
                                                <small class="text-danger ml-4">{{$error}}</small>
                                                @break
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="password" name="password"
                                               class="form-control form-control-user"
                                               id="exampleInputPassword" placeholder="Password">
                                    </div>
                                    @if($errors->any())
                                        @foreach($errors->all() as $error)
                                            @if(str_contains($error,'Password'))
                                                <small class="text-danger ml-4">{{$error}}</small>
                                                @break
                                            @endif
                                        @endforeach
                                    @endif
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
                                    @if($errors->any())
                                        @foreach($errors->all() as $error)
                                            @if(str_contains($error,'Password'))
                                                <small class="text-danger ml-4">{{$error}}</small>
                                                @break
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
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
<script src="{{asset('/back')}}/vendor/jquery/jquery.min.js"></script>
<script src="{{asset('/back')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('/back')}}/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('/back')}}/js/sb-admin-2.min.js"></script>

</body>
</html>
