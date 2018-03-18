@extends(layoutExtend())

@section('title')
    {{  trans('home.Admin Panel')}} {{ trans('home.control') }} {{ trans('home.Theme') }}
@endsection

@section('content')
    <div class="col-lg-10">
        @if($theme == 'admin')
            @include('admin.theme.control.adminTheme')
        @elseif($theme == 'website')
            @include('admin.theme.control.websiteTheme')
        @else
            @include('admin.theme.control.widgetTheme')
        @endif
    </div>
    <div class="col-lg-2">
        <h3>{{ trans('admin.Theme Files') }}</h3>
        <ol>
            @foreach($files as $file)
                <li><a href="{{ url('admin/theme/open-file?file='.$file.'&type='.$theme) }}">{{ $file }}</a></li>
            @endforeach
        </ol>
    </div>
@endsection


