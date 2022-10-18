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
            <form method="post" action="{{route('admin.addUser.store')}}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{old('name')}}">

                            @if($errors->any())
                                @foreach($errors->all() as $error)
                                    @if(str_contains($error,'Full Name'))
                                        <small class="text-danger">{{$error}}</small>
                                    @endif
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{old('email')}}">

                            @if($errors->any())
                                @foreach($errors->all() as $error)
                                    @if(str_contains($error,'Email'))
                                        <small class="text-danger">{{$error}}</small>
                                    @endif
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">

                            @if($errors->any())
                                @foreach($errors->all() as $error)
                                    @if(str_contains($error,'Password'))
                                        <small class="text-danger">{{$error}} <br></small>
                                    @endif
                                @endforeach
                            @endif

                            <small class="text-muted">
                                Use 6 or more characters with a mix of letters and numbers.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Repeat Password</label>
                            <input type="password" name="password_confirmation" class="form-control">

                            @if($errors->any())
                                @foreach($errors->all() as $error)
                                    @if(str_contains($error,'Password'))
                                        <small class="text-danger">{{$error}} <br></small>
                                    @endif
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Create User</button>
                </div>
            </form>
        </div>
    </div>

@endsection
