@extends(layoutExtend())

@section('title')
    {{  adminTrans('role' , 'role') }}     {{  adminTrans('home' , 'control') }}
@endsection

@section('style')
    @include('admin.shared.style')
@endsection


@section('content')
    @include(layoutTable() , ['title' => adminTrans('role' , 'role')  ,'model' => 'role' , 'table' => $dataTable->table([] , true) ])
@endsection


@section('script')
    @include('admin.shared.scripts')
@endsection