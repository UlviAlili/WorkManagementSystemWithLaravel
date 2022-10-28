<div class="d-flex">
    <a href="{{route('admin.task.show',$id)}}" title="View"
       class="btn btn-sm btn-success"><i
            class="fa fa-eye"></i></a>
    <a href="{{route('admin.task.edit',$id)}}" title="Edit"
       class="btn btn-sm btn-primary ml-1"><i class="fa fa-pen"></i></a>
    <form method="post" class="ml-1 FrmDeleteTask"
          data-url="{{route('admin.task.destroy',$id)}}">
        @method('DELETE')
        <button type="submit" title="Delete"
                class="btn btn-sm btn-danger"
                style="width: 34px"><i class="fa fa-times"></i></button>
    </form>
</div>
