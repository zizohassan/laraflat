@extends('admin.layout.app')

@section('title')
    role Control
@endsection

@section('content')
    @include('admin.layout.table' , ['title' => 'role' , 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection