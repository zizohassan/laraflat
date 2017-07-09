@extends(layoutExtend())

@section('title')
    {{ adminTrans('log' , 'log') }} {{ adminTrans('curd' , 'control') }}
@endsection


@section('style')
    @include('admin.shared.style')
@endsection

@section('content')
    @include(layoutTable() , ['title' => adminTrans('log' , 'log') , 'model' => 'log' , 'table' => $dataTable->table([] , true) , 'button' => false])
@endsection

@section('script')
    @include('admin.shared.scripts')
@endsection