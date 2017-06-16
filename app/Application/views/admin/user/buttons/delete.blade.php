@if($id != 1)
    <span onclick="deleteThisItem(this)" data-link="{{ url('admin/user/'.$id.'/delete') }}" class="btn bg-deep-purple btn-circle waves-effect waves-circle waves-float" >
         <i class="material-icons">delete</i>
    </span>
@endif
