@extends(layoutExtend())

@section('title')
    {{ adminTrans('categorie' , 'Category') }} {{ adminTrans('home' , 'control') }}
@endsection

@section('style')
    @include('admin.shared.style')
@endsection

@section('content')
    @include(layoutTable() , ['title' => adminTrans('categorie' , 'Category') , 'model' => 'categorie' , 'table' => $dataTable->table([] , true) ])
@endsection

@section('script')
    @include('admin.shared.scripts')
@endsection