@extends(layoutExtend())

@section('title')
    {{ trans('categorie.Edit') }} {{ trans('home.Edit') }}
@endsection

@section('content')
    <form action="{{ concatenateLangToUrl('admin/translation/save') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="submit" name="submit" value="{{ trans('admin.Save') }}" class="btn btn-default" />
            <span class="btn btn-success" onclick="addNewRow()"><i class="fa fa-plus"></i></span>
            <a class="btn btn-warning" href="{{url('admin/translation')}}"><i class="fa fa-arrow-circle-{{ getDirection() }}"></i></a>
        </div>
        <table class="table table-bordered  table-striped">
            <tr>
                <th>{{ trans('admin.Key') }}</th>
                <th>{{ trans('admin.Value') }}</th>
                <th width="50">#</th>
            </tr>
            @foreach($content as $key => $value)
                <tr>
                    <td width="20%">
                        <input type="text" name="key[]" value="{{ $key }}" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="value[]" value="{{ $value }}" class="form-control" >
                    </td>
                    <td>
                        <span class="btn btn-danger" onclick="hide(this)"><i class="fa fa-trash"></i></span>
                    </td>
                </tr>
            @endforeach
            <input type="hidden" name="file" value="{{ $file }}">
            <input type="hidden" name="lang" value="{{ $lang }}">
        </table>
        <div class="form-group">
            <input type="submit" name="submit" value="{{ trans('admin.Save') }}" class="btn btn-default" />
            <span class="btn btn-success" onclick="addNewRow()"><i class="fa fa-plus"></i></span>
            <a class="btn btn-warning" href="{{url('admin/translation')}}"><i class="fa fa-arrow-circle-{{ getDirection() }}"></i></a>
        </div>
    </form>
@endsection

@section('script')
    <script>
        function addNewRow(){
            $('table').append('<tr><td width="20%"> <input type="text" name="key[]"  class="form-control"></td><td> <input type="text" name="value[]" class="form-control" > </td> <td> <span class="btn btn-danger" onclick="hide(this)"><i class="fa fa-trash"></i></span> </td> </tr>');
        }
        function hide(e){
            $(e).closest('tr').remove()
        }
    </script>
@endsection


