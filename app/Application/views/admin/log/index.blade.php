@extends('admin.layout.app')

@section('title')
    {{ adminTrans('log' , 'log') }} {{ adminTrans('curd' , 'control') }}
@endsection

@section('content')
    @include('admin.layout.table' , ['title' => adminTrans('log' , 'log') , 'model' => 'log' , 'table' => $dataTable->table() , 'button' => false])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection