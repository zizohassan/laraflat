@if(env('APP_ENV') == 'local')
    <span onclick="deleteThisItem(this)" data-link="{{ url('admin/setting/'.$id.'/delete') }}"
          class="btn bg-deep-purple btn-circle waves-effect waves-circle waves-float">
    <i class="material-icons">delete</i>
</span>
@endif
