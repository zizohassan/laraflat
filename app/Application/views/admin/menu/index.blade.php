@extends(layoutExtend())

@section('title')
    {{ trans('menu.menu') }} {{ trans('home.control') }}
@endsection


@section('style')
    @include('admin.shared.style')
@endsection


@section('content')
    @include(layoutTable() , ['title' => trans('menu.menu') , 'model' => 'menu' , 'table' => $dataTable->table([] , true) ])
@endsection


@section('script')
    @include('admin.shared.scripts')
@endsection