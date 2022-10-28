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
    <link href="{{asset('/back')}}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('/back')}}/css/sb-admin-2.min.css" rel="stylesheet">


    <script src="{{asset('/back')}}/vendor/jquery/jquery.min.js"></script>

{{--    <script>--}}
{{--        $(function () {--}}
{{--            $("p").on("click",function () {--}}
{{--                $(this).animate({fontSize:"+=10px"});--}}
{{--                // alert('P setri');--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
</head>

<body class="bg-gradient-primary">
{{--<body class="bg-gradient">--}}

{{--<h1 class="test">Hello World</h1>--}}
{{--<p id="test">First Task</p>--}}
{{--<p class="test">Second Project</p>--}}
{{--<p>Third Work</p>--}}
{{--<button type="button">Submit</button>--}}

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

                                @if(session('success'))
                                    <div class="alert alert-success">{{session('success')}}</div>
                                @endif

                                <form class="user" method="post" action="{{route('loginPost')}}">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <input type="text" name="email" class="form-control form-control-user"
                                                   id="exampleInputEmail" aria-describedby="emailHelp"
                                                   placeholder="Enter Email Address...">
                                        </div>
                                        @if($errors->any())
                                            @foreach($errors->all() as $error)
                                                @if(str_contains($error,'Email Address'))
                                                    <small class="text-danger ml-4">{{$error}}</small>
                                                @elseif(str_contains($error,'credentials'))
                                                    <small class="text-danger ml-4">{{$error}}</small>
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
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" name="remember" class="custom-control-input"
                                                   id="remember">
                                            <label class="custom-control-label" for="remember">Remember
                                                Me</label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
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

<!-- Bootstrap core JavaScript-->
<script src="{{asset('/back')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('/back')}}/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('/back')}}/js/sb-admin-2.min.js"></script>


</body>
</html>
