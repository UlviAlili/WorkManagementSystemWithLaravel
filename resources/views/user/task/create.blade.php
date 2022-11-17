<button type="button" class="btn btn-light btn-block" data-toggle="modal"
        data-target="#exampleModal2">
    <div class="card-footer">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <path
                d="M13 11V3.993A.997.997 0 0012 3c-.556 0-1 .445-1 .993V11H3.993A.997.997 0 003 12c0 .557.445 1 .993 1H11v7.007c0 .548.448.993 1 .993.556 0 1-.445 1-.993V13h7.007A.997.997 0 0021 12c0-.556-.445-1-.993-1H13z"
                fill="currentColor" fill-rule="evenodd"></path>
        </svg>
        Create Task
    </div>
</button>
<div class="modal fade" id="exampleModal2" tabindex="-1"
     aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Create Task</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="FrmCreateTask">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="title" class="form-control"
                               placeholder="Enter Task Name">
                    </div>
                    <input type="hidden" name="project" value="{{$project->id}}">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="mySubmit">Create Task
                        &nbsp;<span class="myLoad"></span></button>
                </div>
            </form>
        </div>
    </div>
</div>
