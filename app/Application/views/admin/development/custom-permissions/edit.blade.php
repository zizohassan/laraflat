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
                <th>{{ trans('admin.Name') }}</th>
                <th>{{ trans('admin.Namespace') }}</th>
                <th width="50">#</th>
            </tr>

            @foreach($content as $key => $value)
                <tr class="count">
                    <td width="20%">
                        {{ class_basename($value) }}
                    </td>
                    <td>
                        <input type="text" name="namespace[]"  class="form-control" value="{{ $value }}" required>
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
            $('table').append('<tr><td width="20%"> {{ trans('admin.Name') }}</td>' +
                    '<td>' +
                    ' <input type="text" name="namespace[]" class="form-control"  placeholder="{{ trans('admin.Namespace') }}" required>' +
                    '  </td>' +
                    ' <span class="btn btn-danger" onclick="hide(this)"   >' +
                    '<i class="fa fa-trash"></i></span> </td> </tr>'
            )
            ;
        }
        function hide(e) {
            $(e).closest('tr').remove()
        }
    </script>
@endsection


