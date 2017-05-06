@extends('admin.layout.app')

@section('title')
    {{  adminTrans('role' , 'role') }}     {{  adminTrans('home' , 'control') }}
@endsection

@section('content')
    @include('admin.layout.table' , ['title' => adminTrans('role' , 'role')  ,'model' => 'role' , 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection