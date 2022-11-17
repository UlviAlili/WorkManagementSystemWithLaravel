<div class="d-flex">
    <form method="get" class="ml-1 RestoreProject" data-url="{{route('admin.project.restore',$id)}}">
        <button type="submit" title="Restore" class="btn btn-sm btn-primary" style="width: 34px">
            <i class="fa fa-recycle"></i></button>
    </form>
    <form method="post" class="ml-1 FrmDeleteTrashProject"
          data-url="{{route('admin.project.hard.delete',$id)}}">
        @method('DELETE')
        <button type="submit" title="Delete permanently" class="btn btn-sm btn-danger"
                style="width: 34px"><i class="fa fa-trash"></i></button>
    </form>
</div>
