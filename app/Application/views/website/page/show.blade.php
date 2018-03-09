@extends(layoutExtend('website'))
@section('title')
    {{ trans('page.page') }} {{ trans('home.view') }}
@endsection
@section('content')
    <div class="pull-{{ getDirection() }} col-lg-9">
        <a href="{{ url('page') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> {{ trans('website.Back') }}
        </a>
        <table class="table table-bordered table-responsive table-striped">
            <tr>
                <th>{{ trans("page.title") }}</th>
                <td>{{ getDefaultValueKey(nl2br($item->title)) }}</td>
            </tr>
            <tr>
                <th>{{ trans("page.body") }}</th>
                <td>{!! getDefaultValueKey(nl2br($item->body))  !!} </td>
            </tr>
            @if(auth()->check() && auth()->user()->group_id == 1)
                <tr>
                    <th>{{ trans("page.active") }}</th>
                    <td>
                        {{ $item->active == 1 ? trans("page.Yes") : trans("page.No")  }}
                    </td>
                </tr>
            @endif
        </table>
        @include("website.page.comment.show")
        @include("website.page.comment.edit")
        @if(auth()->check() && auth()->user()->group_id == 1)
            @include('website.page.buttons.delete' , ['id' => $item->id])
            @include('website.page.buttons.edit' , ['id' => $item->id])
        @endif
    </div>
@endsection
