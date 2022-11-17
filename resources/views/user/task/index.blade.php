<div class="card mb-1" id="toDo_{{$task->id}}">
    <div class="col-md-12">
        <div class="col-md-10 float-left">
            <a href="" class="text-decoration-none text-center"
               data-toggle="modal" data-target="#taskModal_{{$task->id}}">
                <div class="card-body">
                    <div @if($task->user_id == 0) class='text-danger' @endif>{{$task->name}}</div>
                </div>
            </a>
            <div class="modal fade" id="taskModal_{{$task->id}}"
                 tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 1270px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel3"><b>{{$task->name}}</b></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" class="FrmUpdateTask" enctype="multipart/form-data"
                              data-url="{{route('user.task.update',$task->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="modal-body modal1">
                                <div class="col-md-12">
                                    <div class="task-sol col-md-8 float-left">
                                        <h6><b>Task Name</b></h6>
                                        <div class="form-group">
                                            <input type="text" name="title" class="form-control"
                                                   value="{{$task->name}}">
                                        </div>
                                        <input type="hidden" name="project" value="{{$task->project_id}}">
                                        <h6><b>Description</b></h6>
                                        <div class="form-group">
                                                <textarea name="contents" class="form-control text1"
                                                          rows="1"
                                                          placeholder="Add a description">{!! $task->description !!}</textarea>
                                        </div>
                                        <br>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6><b>Activity</b> - Show Comments</h6>
                                            </div>
                                            <div class="card-body">
                                                @if(isset($task->comments))
                                                    @foreach($task->comments as $comment)
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <p>
                                                                            <b>{{\App\Models\User::where('id',$comment->user_id)->first()->name}}</b>&nbsp;&nbsp;
                                                                            <small>{{$comment->created_at->diffForHumans()}}</small>
                                                                            @if($comment->user_id == Auth::user()->id)
                                                                                <a href="{{route('user.comment.delete',$comment->id)}}"
                                                                                   title="Delete"
                                                                                   class="btn btn-sm btn-danger ml-1 float-right">Delete</a>
                                                                            @endif
                                                                        </p>
                                                                        <p>{!! $comment->comment !!}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="task-sag col-md-4 float-right">
                                        <p class="ml-3"><b>Status</b></p>
                                        <div class="col-md-6 float-left">
                                            <select class="form-control mb-2" name="status">
                                                <option value="1"
                                                        @if($task->status == 'Not Started') selected @endif>Not
                                                    Started
                                                </option>
                                                <option value="2"
                                                        @if($task->status == 'In Progress') selected @endif>In
                                                    Progress
                                                </option>
                                                <option value="3" @if($task->status == 'Done') selected @endif>
                                                    Done
                                                </option>
                                            </select>
                                        </div>
                                        <br><br>
                                        <hr>
                                        <div class="card">
                                            <div class="card-header">
                                                <b>Details</b>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-4 float-left mt-2">
                                                    Assignee:
                                                </div>
                                                <div class="col-md-8 float-right mt-2">
                                                    {{Auth::user()->name}}
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="float-left">
                                            <small class="ml-3">
                                                Created {{$task->created_at->diffForHumans()}}
                                            </small><br>
                                            <small class="ml-3">
                                                Updated {{$task->updated_at->diffForHumans()}}
                                            </small>
                                        </div>
                                        <div class="float-right">
                                            <button type="submit" class="btn btn-success mySubmit">
                                                Save changes &nbsp;<span class="myLoad"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <div class="col-md-12">
                                <form method="post" class="FrmComment"
                                      data-url="{{route('user.comment',$task->id)}}">
                                    @csrf

                                    <div class="col-md-9 float-left">
                                        <div class="form-group">
                                                        <textarea name="comments" class="form-control text1 text"
                                                                  rows="2" placeholder="Add a comment"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3 float-right">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary mySubmit1">
                                                Add a Comment &nbsp;<span class="myLoad1"></span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($task->admin_id == Auth::user()->id)
            <div class="col-md-2 float-right mt-3">
                <form method="post" class="FrmDeleteTask" data-url="{{route('user.task.destroy',$task->id)}}">
                    @method('DELETE')
                    <button type="submit" class="btn btn-light" title="Delete">
                        <i class="fa fa-times text-danger"></i>
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>


