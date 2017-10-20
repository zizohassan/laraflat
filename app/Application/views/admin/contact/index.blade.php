@extends(layoutExtend())

@section('title')
     {{ adminTrans('contact' , 'contact') }} {{ adminTrans('home' , 'control') }}
@endsection

@section('style')
    @include('admin.shared.style')
@endsection

@section('content')
    @include(layoutTable() , ['title' => adminTrans('contact' , 'contact') , 'model' => 'contact' , 'table' => $dataTable->table([] , true) , 'button' => false ])
@endsection

@section('script')
    @include('admin.shared.scripts')
@endsection