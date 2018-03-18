@extends(layoutExtend())

@section('title')
    {{ trans('categorie.Translation') }} {{ trans('home.control') }}
@endsection

@section('content')
    <table class="table table-bordered  table-striped">
        <tr>
            <th>{{ trans('admin.Files') }}</th>
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <th>{{ $properties['native'] }}</th>
            @endforeach
            <th>{{ trans('admin.Both') }}</th>
        </tr>
        @foreach($files as $h)
            <tr>
                @php $path = explode(DIRECTORY_SEPARATOR , (string)$h) @endphp
                <td>{{ end($path) }}</td>
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <td>
	                    <a href="{{ url('admin/translation/readFile/') }}/{{$localeCode.'_'.end($path) }}">{{ trans('admin.Edit') }} </a>
                    </td>
                @endforeach
                <td><a href="{{ url('admin/translation/getAllContent/'.end($path)) }}">{{ trans('admin.Edit All Language') }}</a></td>
            </tr>
        @endforeach
    </table>
@endsection

