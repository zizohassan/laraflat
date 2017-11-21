<form action="{{ concatenateLangToUrl('admin/contact/replay/'.$id) }}" method="post">
    {{ csrf_field() }}
    <textarea name="replay" id="replay" cols="30" rows="10" class="form-control"></textarea>
    <br>
    <input type="submit" class="btn btn-danger btn-circle waves-effect waves-circle waves-float" value="{{ trans('contact.Replay') }}">
</form>