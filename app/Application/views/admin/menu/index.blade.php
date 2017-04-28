@extends('admin.layout.app')

@section('title')
    menu Control
@endsection

@section('content')
    @include('admin.layout.table' , ['title' => 'menu' , 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection