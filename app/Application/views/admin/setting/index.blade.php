@extends(layoutExtend())

@section('title')
    {{ adminTrans('setting' , 'setting') }}    {{ adminTrans('home' , 'control') }}
@endsection

@section('style')
    @include('admin.shared.style')
@endsection


@section('content')
    @include(layoutTable() , ['title' => adminTrans('setting' , 'setting')  ,'model' => 'setting' , 'table' => $dataTable->table([] , true) ])
@endsection


@section('script')
    @include('admin.shared.scripts')
@endsection