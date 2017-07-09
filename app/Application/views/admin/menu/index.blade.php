@extends(layoutExtend())

@section('title')
    {{ adminTrans('menu' ,'menu') }} {{ adminTrans('home' , 'control') }}
@endsection


@section('style')
    @include('admin.shared.style')
@endsection


@section('content')
    @include(layoutTable() , ['title' => adminTrans('menu' ,'menu') , 'model' => 'menu' , 'table' => $dataTable->table([] , true) ])
@endsection


@section('script')
    @include('admin.shared.scripts')
@endsection