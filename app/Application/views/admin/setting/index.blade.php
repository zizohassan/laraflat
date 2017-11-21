@extends(layoutExtend())

@section('title')
    {{ trans('setting.setting') }}    {{ trans('home.control') }}
@endsection

@section('style')
    @include('admin.shared.style')
@endsection


@section('content')
    @include(layoutTable() , ['title' => trans('setting.setting')  ,'model' => 'setting' , 'table' => $dataTable->table([] , true) ])
@endsection


@section('script')
    @include('admin.shared.scripts')
@endsection