@extends('admin.layout.app')

@section('title')
    {{ adminTrans('menu' ,'menu') }} {{ adminTrans('home' , 'control') }}
@endsection

@section('content')
    @include('admin.layout.table' , ['title' => adminTrans('menu' ,'menu') , 'model' => 'menu' , 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection