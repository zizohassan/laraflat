@extends('admin.layout.app')

@section('title')
    page Control
@endsection

@section('content')
    @include('admin.layout.table' , ['title' => 'page' , 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection