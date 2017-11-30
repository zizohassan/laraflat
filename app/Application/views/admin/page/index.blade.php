@extends(layoutExtend())

@section('title')
    {{ trans('page.page') }}  {{ trans('home.control') }}
@endsection

@section('style')
    @include('admin.shared.style')
@endsection


@section('content')
    @include(layoutTable(), ['title' =>trans('page.page')  , 'model' => 'page' , 'table' => $dataTable->table([] , true) ])
@endsection


@section('script')
    @include('admin.shared.scripts')
@endsection