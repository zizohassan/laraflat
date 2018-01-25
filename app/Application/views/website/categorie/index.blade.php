@extends(layoutExtend('website'))

@section('title')
    {{ trans('categorie.categorie') }} {{ trans('home.control') }}
@endsection

@section('content')
    <div class="pull-{{ getDirection() }} col-lg-9">
        <div><h1>{{ trans('website.categorie') }}</h1></div>
        @if(auth()->check() && auth()->user()->group_id == 1)
            <div><a href="{{ url('categorie/item') }}" class="btn btn-default"><i
                            class="fa fa-plus"></i> {{ trans('website.categorie') }}</a><br></div>
        @endif
        <table class="table table-responsive table-striped table-bordered">
            <thead>
            <tr>
                <th>{{ trans("categorie.title") }}</th>
                @if(auth()->check() && auth()->user()->group_id == 1)
                    <th>{{ trans("categorie.edit") }}</th>
                    <th>{{ trans("categorie.show") }}</th>
                    <th>{{ trans("categorie.delete") }}</th>
            @endif
            </thead>
            <tbody>
            @if(count($items) > 0)
                @foreach($items as $d)
                    <tr>
                        <td>{{ str_limit($d->title , 20) }}</td>
                        @if(auth()->check() && auth()->user()->group_id == 1)
                            <td>@include("website.categorie.buttons.edit", ["id" => $d->id ])</td>
                            <td>@include("website.categorie.buttons.view", ["id" => $d->id ])</td>
                            <td>@include("website.categorie.buttons.delete", ["id" => $d->id ])</td>
                        @endif
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        @include(layoutPaginate() , ["items" => $items])

    </div>
@endsection
