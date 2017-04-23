@extends('admin.layout.app')

@section('title')
    setting Control
@endsection

@section('content')
    @include('admin.layout.table' , ['title' => 'setting' , 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection