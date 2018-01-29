@extends(layoutExtend('website'))

@section('title')
    {{ trans('page.page') }} {{ trans('home.control') }}
@endsection

@section('content')
    <div class="pull-{{ getDirection() }} col-lg-9">
        <div><h1>{{ trans('website.page') }}</h1></div>
        @if(auth()->check() && auth()->user()->group_id == 1)
        @endif
        <form method="get" class="form-inline">
            <a href="{{ url('page/item') }}" class="btn btn-default"><i
                        class="fa fa-plus"></i> {{ trans('website.page') }}</a>
            <div class="form-group">
                <input type="text" name="from" class="form-control datepicker2" placeholder="{{ trans("admin.from") }}"value="{{ request()->has("from") ? request()->get("from") : "" }}">
            </div>
            <div class="form-group">
                <input type="text" name="to" class="form-control datepicker2" placeholder="{{ trans("admin.to") }}"value="{{ request()->has("to") ? request()->get("to") : "" }}">
            </div>
            <div class="form-group">
                <input type="text" name="title" class="form-control " placeholder="{{ trans("page.title") }}" value="{{ request()->has("title") ? request()->get("title") : "" }}">
            </div>
            <button class="btn btn-success" type="submit" ><i class="fa fa-search" ></i ></button>
            <a href="{{ url("page") }}" class="btn btn-danger" ><i class="fa fa-close" ></i></a>
        </form>
        <br>
        <table class="table table-responsive table-striped table-bordered">
            <thead>
            <tr>
                <th>{{ trans("page.title") }}</th>
                @if(auth()->check() && auth()->user()->group_id == 1)
                    <th>{{ trans("page.edit") }}</th>
                    <th>{{ trans("page.show") }}</th>
                    <th>{{ trans("page.delete") }}</th>
                @endif
            </thead>
            <tbody>
            @if(count($items) > 0)
                @foreach($items as $d)
                    <tr>
                        <td>{{ str_limit(getDefaultValueKey($d->title) , 20) }}</td>
                        @if(auth()->check() && auth()->user()->group_id == 1)
                            <td>@include("website.page.buttons.edit", ["id" => $d->id ])</td>
                            <td>@include("website.page.buttons.view", ["id" => $d->id ])</td>
                            <td>@include("website.page.buttons.delete", ["id" => $d->id ])</td>
                        @endif
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        @include(layoutPaginate() , ["items" => $items])

    </div>
@endsection
