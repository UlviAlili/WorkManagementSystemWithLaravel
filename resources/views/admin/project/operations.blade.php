<div class="d-flex">
    <a href="{{route('admin.project.show',$id)}}" title="View"
       class="btn btn-sm btn-success ml-1"><i
            class="fa fa-eye"></i></a>
    <a href="{{route('admin.project.edit',$id)}}" title="Edit"
       class="btn btn-sm btn-primary ml-1"><i class="fa fa-pen"></i></a>
    <form method="post" class="ml-1 FrmDeleteProject"
          data-url="{{route('admin.project.destroy',$id)}}">
        @method('DELETE')
        <button type="submit" title="Move to Trash"
                class="btn btn-sm btn-danger"
                style="width: 34px"><i class="fa fa-trash-restore"></i></button>
    </form>
</div>
