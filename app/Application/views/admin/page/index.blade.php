@extends(layoutExtend())

@section('title')
    {{ adminTrans('page' , 'page') }}  {{ adminTrans('home' , 'control') }}
@endsection

@section('style')
    @include('admin.shared.style')
@endsection


@section('content')
    @include(layoutTable(), ['title' =>adminTrans('page' , 'page')  , 'model' => 'page' , 'table' => $dataTable->table([] , true) ])
@endsection


@section('script')
    @include('admin.shared.scripts')
@endsection