<div class="d-flex">
    <a href="{{route('admin.addUser.show',$id)}}" title="View"
       class="btn btn-sm btn-success"><i
            class="fa fa-eye"></i></a>
    <form method="post" class="ml-1 FrmDeleteUser"
          data-url="{{route('admin.addUser.destroy',$id)}}">
        @method('DELETE')
        <button type="submit" title="Delete"
                class="btn btn-sm btn-danger"
                style="width: 34px"><i class="fa fa-times"></i></button>
    </form>
</div>
