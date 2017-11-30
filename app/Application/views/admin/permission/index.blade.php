@extends(layoutExtend())

@section('title')
    {{ trans('permission.permission') }}   {{ trans('home.control') }}
@endsection

@section('style')
    @include('admin.shared.style')
@endsection


@section('content')
    @include(layoutTable() , ['title' =>  trans('permission.permission') , 'model' => 'permission' , 'table' => $dataTable->table([] , true) ])

@endsection


@section('script')
    @include('admin.shared.scripts')
@endsection