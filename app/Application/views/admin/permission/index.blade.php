@extends('admin.layout.app')

@section('title')
    {{ adminTrans('permission' , 'permission') }}   {{ adminTrans('home' , 'control') }}
@endsection

@section('content')
    @include('admin.layout.table' , ['title' =>  adminTrans('permission' , 'permission') , 'model' => 'permission' , 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection