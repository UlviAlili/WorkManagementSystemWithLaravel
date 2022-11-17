@extends('layouts.master')
@section('title',$project->name)
@section('content')

    {{--    Start Project--}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-right text-primary">
                <a href="{{route('user.project.index')}}" class="btn btn-primary btn-sm">All Projects</a>
            </h6>
        </div>
        <div class="card-body show-scroll">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <dl>
                            <dt><h5><b class="border-bottom border-primary">Project Team Leader</b></h5></dt>
                            <dd>{{\App\Models\User::where('id',$project->admin_id)->first()->name}}</dd>
                        </dl>
                        <dl>
                            <dt><h5><b class="border-bottom border-primary">Project Members</b></h5></dt>
                            @foreach($project->users->pluck('id')->toArray() as $user)
                                <dd>
                                    <li>{{\App\Models\User::where('id',$user)->first()->name}}</li>
                                </dd>
                            @endforeach
                        </dl>
                    </div>

                    <div class="col-md-6">
                        <dl>
                            <dt><h5><b class="border-bottom border-primary">Status</b></h5></dt>
                            <dd>{{$project->status}}</dd>

                            <dt><h5><b class="border-bottom border-primary">Description</b></h5></dt>
                            <dd>{!! $project->description !!}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    End Project --}}


    {{--    Start Task--}}

    @include('user.task.show')

    {{--    End Task --}}

@endsection

@section('css')

    @include('user.project.showProjectCSS')

@endsection

@section('js')

    @include('user.project.showProjectJS')

@endsection
