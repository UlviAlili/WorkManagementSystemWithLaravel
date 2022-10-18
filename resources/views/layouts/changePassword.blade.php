@extends('layouts.master')
@section('title','Change Password')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-left text-primary">@yield('title')</h6>
            <h6 class="m-0 font-weight-bold float-right text-primary">
                <a href="{{route('profile')}}" class="btn btn-primary btn-sm">Profile</a>
            </h6>
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </div>
            @endif

            <form method="post" action="{{route('postChangePass',\Illuminate\Support\Facades\Auth::user()->id)}}"
                  enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Old Password</label>
                            <input type="password" name="oldPassword" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control">
                            <small class="text-muted">
                                Use 6 or more characters with a mix of letters and numbers.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Repeat Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-warning">Change Password</button>
                </div>

            </form>
        </div>
    </div>

@endsection
