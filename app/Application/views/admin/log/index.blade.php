@extends(layoutExtend())

@section('title')
    {{ trans('log.log') }} {{ trans('curd.control') }}
@endsection


@section('style')
    @include('admin.shared.style')
@endsection

@section('content')
    @include(layoutTable() , ['title' => trans('log.log') , 'model' => 'log' , 'table' => $dataTable->table([] , true) , 'button' => false])
@endsection

@section('script')
    @include('admin.shared.scripts')
@endsection