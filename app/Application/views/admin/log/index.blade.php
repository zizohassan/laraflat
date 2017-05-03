@extends('admin.layout.app')

@section('title')
    log Control
@endsection

@section('content')
    @include('admin.layout.table' , ['title' => 'log' , 'table' => $dataTable->table() , 'button' => false])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection