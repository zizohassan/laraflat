@extends(layoutExtend())

@section('title')
     {{ trans('contact.contact') }} {{ trans('home.control') }}
@endsection

@section('style')
    @include('admin.shared.style')
@endsection

@section('content')
    @include(layoutTable() , ['title' => trans('contact.contact') , 'model' => 'contact' , 'table' => $dataTable->table([] , true) , 'button' => false ])
@endsection

@section('script')
    @include('admin.shared.scripts')
@endsection