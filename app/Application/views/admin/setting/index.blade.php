@extends('admin.layout.app')

@section('title')
    {{ adminTrans('setting' , 'setting') }}    {{ adminTrans('home' , 'control') }}
@endsection

@section('content')
    @include('admin.layout.table' , ['title' => adminTrans('setting' , 'setting')  ,'model' => 'setting' , 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection