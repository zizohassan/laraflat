@extends(layoutExtend())

@section('title')
    {{ trans('categorie.Edit') }} {{ trans('home.Edit') }}
@endsection

@section('content')
    <form action="{{ concatenateLangToUrl('admin/translation/both/save') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="submit" name="submit" value="{{ trans('admin.Save') }}" class="btn btn-default" />
            <span class="btn btn-success" onclick="addNewRow()"><i class="fa fa-plus"></i></span>
            <a class="btn btn-warning" href="{{url('admin/translation')}}"><i class="fa fa-arrow-circle-{{ getDirection() }}"></i></a>
        </div>
        <table class="table table-bordered  table-striped">
            <tr>
                <th>{{ trans('admin.Key') }}</th>
                @foreach($lang as $l)
                    <th>{{ trans('admin.Langauge') }} {{ $l }}</th>
                @endforeach
                <th width="50">#</th>
            </tr>
            @foreach($keys as $files)
                <tr>
                    <td width="10%">
                        <input type="text" name="key[{{ $files }}]" value="{{ $files }}" class="form-control">
                    </td>
                    @foreach($lang as $subValue)
                            <td width="50%">
                                <input type="text" name="value[{{ $subValue }}][{{ $files }}]" value="{{ $filesArray[$subValue][$files] }}" class="form-control" >
                            </td>
                    @endforeach
                    <td>
                        <span class="btn btn-danger" onclick="hide(this)"><i class="fa fa-trash"></i></span>
                    </td>
                </tr>
            @endforeach
            <input type="hidden" name="file" value="{{ $file }}">
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
            $('table').append('<tr><td width="10%"> <input type="text" name="key[]"  class="form-control"></td>' +
                    @foreach($lang as $subValue)
                    '<td> <input type="text" name="value[{{ $subValue }}][]" class="form-control" > </td>' +
                    @endforeach
                    ' <td> <span class="btn btn-danger" onclick="hide(this)"><i class="fa fa-trash"></i></span> </td> </tr>');
        }

        function hide(e){
            $(e).closest('tr').remove()
        }
    </script>
@endsection


