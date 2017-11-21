@extends(layoutExtend())

@section('title')
    {{ trans('categorie.Edit') }} {{ trans('home.Edit') }}
@endsection

@section('content')
    <form action="{{ concatenateLangToUrl('admin/custom-permissions/save') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="submit" name="submit" value="{{ trans('admin.Save') }}" class="btn btn-default"/>
            <span class="btn btn-success" onclick="addNewRow()"><i class="fa fa-plus"></i></span>
            <a class="btn btn-warning" href="/admin/custom-permissions"><i class="fa fa-arrow-circle-{{ getDirection() }}"></i></a>
        </div>
        <table class="table table-bordered  table-striped">
            <tr>
                <th>{{ trans('admin.Key') }}</th>
                <th>{{ trans('admin.Value') }}</th>
                <th width="50">#</th>
            </tr>
            @php $action = ['add' , 'edit' , 'view' , 'delete'] @endphp
            @foreach($content as $key => $value)
                <tr class="count">
                    <td width="20%">
                        <input type="text" name="key[]" value="{{ $key }}" class="form-control">
                    </td>
                    <td>
                        <select name="value[{{ $key }}][]" class="form-control" multiple>
                            @foreach($action as $v)
                                <option value="{{ $v }}" {{ in_array($v , $value)  ? "selected" : ""}} >{{ $v }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <span class="btn btn-danger" onclick="hide(this)"><i class="fa fa-trash"></i></span>
                    </td>
                </tr>
            @endforeach
            <input type="hidden" name="file" value="{{ $file }}">
        </table>
        <div class="form-group">
            <input type="submit" name="submit" value="{{ trans('admin.Save') }}" class="btn btn-default"/>
            <span class="btn btn-success" onclick="addNewRow()"><i class="fa fa-plus"></i></span>
            <a class="btn btn-warning" href="/admin/custom-permissions"><i
                        class="fa fa-arrow-circle-{{ getDirection() }}"></i></a>
        </div>
    </form>
@endsection

@section('script')
    <script>
        function addNewRow() {
            var length = $('.count').length;
            $('table').append('<tr><td width="20%"> <input type="text" name="key[]"  class="form-control"></td>' +
                    '<td>' +
                    ' <select name="value['+length+'][]" class="form-control" multiple>' +
                    @foreach($action as $v)
                        '  <option value="{{ $v }}" >{{ $v }}</option>' +
                    @endforeach
                    ' </select>' +
                    '  </td>' +
                    ' <span class="btn btn-danger" onclick="hide(this)">' +
                    '<i class="fa fa-trash"></i></span> </td> </tr>'
            )
            ;
        }
        function hide(e) {
            $(e).closest('tr').remove()
        }
    </script>
@endsection


