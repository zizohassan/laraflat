@extends(layoutExtend())

@section('title')
    {{  trans('home.Admin Panel')}} {{ trans('home.control') }} {{ trans('home.Theme') }}
@endsection

@section('content')
    <h3>{{ trans('admin.File') }} {{ $fileName }}</h3>
    <div class="col-lg-10">
        <form action="{{ concatenateLangToUrl('admin/theme/save-file?file='.$fileName) }}" method="Post">
            {{ csrf_field() }}

            <textarea name="content" id="" cols="30" rows="30" class="form-control">{{ $file }}</textarea>
            <div class="alert alert-waring">
                {{ trans('admin.Do not Do any thing if you not understand what you do ') }} .
            </div>
            <input type="hidden" name="type" value="{{ $theme }}"/>
            <br>
            <input type="submit" value="{{ trans('admin.Save') }}" class="btn btn-info"/>
        </form>
    </div>
    <div class="col-lg-2">
        <h3>{{ trans('admin.Theme File') }}</h3>
        <ol>
            @foreach($files as $file)
                <li><a href="{{ url('admin/theme/open-file?file='.$file.'&type='.$theme) }}">{{ $file }}</a></li>
            @endforeach
        </ol>
    </div>
@endsection


