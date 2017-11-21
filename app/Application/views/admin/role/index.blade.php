@extends(layoutExtend())

@section('title')
    {{  trans('role.role') }}     {{  trans('home.control') }}
@endsection

@section('style')
    @include('admin.shared.style')
@endsection


@section('content')
    @include(layoutTable() , ['title' => trans('role.role')  ,'model' => 'role' , 'table' => $dataTable->table([] , true) ])
@endsection


@section('script')
    @include('admin.shared.scripts')
@endsection