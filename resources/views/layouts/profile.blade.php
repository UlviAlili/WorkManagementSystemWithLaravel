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

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </div>
            @endif

            <form method="post" action="{{route('profilePost',\Illuminate\Support\Facades\Auth::user()->id)}}"
                  enctype="multipart/form-data">
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
                            <input type="email" name="email" class="form-control"
                                   value="{{\Illuminate\Support\Facades\Auth::user()->email}}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>

            </form>
        </div>
    </div>

@endsection
