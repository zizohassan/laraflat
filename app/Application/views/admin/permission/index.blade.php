@extends(layoutExtend())

@section('title')
    {{ adminTrans('permission' , 'permission') }}   {{ adminTrans('home' , 'control') }}
@endsection

@section('style')
    @include('admin.shared.style')
@endsection


@section('content')
    @include(layoutTable() , ['title' =>  adminTrans('permission' , 'permission') , 'model' => 'permission' , 'table' => $dataTable->table([] , true) ])
@endsection


@section('script')
    @include('admin.shared.scripts')
@endsection