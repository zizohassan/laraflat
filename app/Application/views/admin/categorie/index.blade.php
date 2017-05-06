@extends('admin.layout.app')

@section('title')
    {{ adminTrans('categorie' , 'Category') }} {{ adminTrans('home' , 'control') }}
@endsection

@section('content')
    @include('admin.layout.table' , ['title' => adminTrans('categorie' , 'Category') , 'model' => 'categorie' , 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection