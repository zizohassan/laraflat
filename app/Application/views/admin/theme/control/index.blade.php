@extends(layoutExtend())

@section('title')
    {{  trans('home.Admin Panel')}} {{ trans('home.control') }} {{ trans('home.Theme') }}
@endsection



@section('content')
    <div class="col-lg-10">

        <div class="col-lg-3">
            <a href="{{ url('admin/theme/open-file?file=menu') }}" class="btn btn-warning col-lg-12">
            <div class="well text-center" style="min-height: 500px">
                {{ trans('admin.sidebar') }}
            </div>
            </a>
        </div>
        <div class="col-lg-9">
            <a href="{{ url('admin/theme/open-file?file=breadcrumb') }}" class="btn btn-danger col-lg-12">
            <div class="well text-center" style="min-height: 50px">
                {{ trans('admin.BreadCeamb') }}
            </div>
            </a>
            <a href="{{ url('admin/theme/open-file?file=header') }}" class="btn btn-primary col-lg-12">
                <div class="well text-center" style="min-height: 100px">
                    {{ trans('admin.Header') }}
                </div>
            </a>
            <a href="{{ url('admin/theme/open-file?file=form') }}" class="btn btn-info col-lg-12">
            <div class="well text-center" style="min-height: 300px">
                {{ trans('admin.Content') }}
            </div>
            </a>
        </div>
    </div>
    <div class="col-lg-2">
        <h3>{{ trans('admin.Theme Files') }}</h3>
        <ol>
            @foreach($files as $file)
                <li><a href="{{ url('admin/theme/open-file?file='.$file) }}">{{ $file }}</a></li>
            @endforeach
        </ol>
    </div>
@endsection


