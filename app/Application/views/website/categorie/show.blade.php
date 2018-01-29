@extends(layoutExtend('website'))

@section('title')
    {{ trans('categorie.categorie') }} {{ trans('home.view') }}
@endsection

@section('content')
    <div class="pull-{{ getDirection() }} col-lg-9">
        <a href="{{ url('categorie') }}" class="btn btn-danger"><i
                    class="fa fa-arrow-left"></i> {{ trans('website.Back') }}  </a>
        <br>
        <table class="table table-bordered table-responsive table-striped">
            <tr>
                <th width="150">{{ trans("categorie.title") }}</th>
                <td>{{ nl2br(getDefaultValueKey($item->title)) }}</td>
            </tr>
        </table>
        @if(auth()->check() && auth()->user()->group_id == 1)
            @include('website.categorie.buttons.delete' , ['id' => $item->id])
            @include('website.categorie.buttons.edit' , ['id' => $item->id])
        @endif
    </div>
@endsection
