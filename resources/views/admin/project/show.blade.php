@extends('layouts.master')
@section('title',$project->name)
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold float-right text-primary">
                <a href="{{route('admin.project.index')}}" class="btn btn-primary btn-sm">All Projects</a>
            </h6>
        </div>
        <div class="card-body py-3">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <p><b>Project Members</b></p>
                        @foreach($project->users()->get()->pluck('name')->toArray() as $name)
                            <div class="badge bg-primary text-light" style="font-size: 15px">{{$name}}</div>
                        @endforeach
                        <button type="button" class="btn btn-light btn-sm" data-toggle="modal"
                                data-target="#exampleModal" style="background-color: #E1E1E1; border-radius: 50px;"
                                title="Add People">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <g fill="currentColor" fill-rule="evenodd">
                                    <rect x="18" y="5" width="2" height="6" rx="1"></rect>
                                    <rect x="16" y="7" width="6" height="2" rx="1"></rect>
                                    <path
                                        d="M5 14c0-1.105.902-2 2.009-2h7.982c1.11 0 2.009.894 2.009 2.006v4.44c0 3.405-12 3.405-12 0V14z"></path>
                                    <circle cx="11" cy="7" r="4"></circle>
                                </g>
                            </svg>
                        </button>

                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add People</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" id="FrmUpdateMember">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <input type="hidden" name="title" value="{{$project->name}}">
                                            <input type="hidden" name="status"
                                                   value="@if($project->status=='Not Started')1 @elseif($project->status=='Done') 3 @else 2 @endif">
                                            <textarea hidden name="contents">{{$project->description}}</textarea>
                                            <select class="form-control selectpicker" multiple data-live-search="true"
                                                    name="member[]">
                                                <option value="0" disabled>Select Team Member</option>
                                                @foreach($user as $users)
                                                    <option value="{{$users->id}}"
                                                            @foreach($select as $sel) @if($sel == $users->id ) selected @endif
                                                        @endforeach>{{$users->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" id="mySubmit1">Add People
                                                &nbsp;<span class="myLoad1"></span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <dl>
                            <p><b>Status</b></p>
                            <form class="form-inline" id="FrmUpdateStatus" method="post">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="title" value="{{$project->name}}">
                                <textarea hidden name="contents">{{$project->description}}</textarea>
                                <select hidden multiple name="member[]">
                                    <option hidden value="0" disabled>Select Team Member</option>
                                    @foreach($user as $users)
                                        <option hidden value="{{$users->id}}"
                                                @foreach($select as $sel) @if($sel == $users->id ) selected @endif
                                            @endforeach>{{$users->name}}</option>
                                    @endforeach
                                </select>
                                <select class="form-control mb-2" name="status">
                                    <option value="1" @if($project->status == 'Not Started') selected @endif>Not
                                        Started
                                    </option>
                                    <option value="2" @if($project->status == 'In Progress') selected @endif>In
                                        Progress
                                    </option>
                                    <option value="3" @if($project->status == 'Done') selected @endif>Done</option>
                                </select>
                                <button type="submit" class="btn btn-success mb-2 ml-4" id="mySubmit2">Save
                                    &nbsp;<span class="myLoad2"></span></button>
                            </form>
                            <hr>
                        </dl>
                        <dl>
                            <p><b>Description</b></p>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="card">
                                        <div class="card-body">
                                            {!! $project->description !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                            data-target="#exampleModal1">Edit
                                    </button>
                                </div>
                                <div class="modal fade" id="exampleModal1" tabindex="-1"
                                     aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel1">Project Description</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="post" id="FrmUpdateDesc">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="hidden" name="title" value="{{$project->name}}">
                                                        <select hidden multiple name="member[]">
                                                            <option hidden value="0" disabled>Select Team Member
                                                            </option>
                                                            @foreach($user as $users)
                                                                <option hidden value="{{$users->id}}"
                                                                        @foreach($select as $sel) @if($sel == $users->id ) selected @endif
                                                                    @endforeach>{{$users->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="status"
                                                               value="@if($project->status=='Not Started')1 @elseif($project->status=='Done') 3 @else 2 @endif">
                                                        <textarea name="contents" class="form-control editor"
                                                                  rows="2" placeholder="Add a description">
                                                            {!! $project->description !!}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" id="mySubmit3">Save
                                                        changes
                                                        &nbsp;<span class="myLoad3"></span></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    End Project --}}


    {{--    Start Task  --}}

    @include('admin.task.index')

    {{--    End Task   --}}

@endsection

@section('css')

    @include('admin.project.showProjectCSS')

@endsection

@section('js')

    @include('admin.project.showProjectJS')

@endsection
