@extends('admin.layout.app')

@section('title')
    permission Control
@endsection

@section('content')
    @include('admin.layout.table' , ['title' => 'permission' , 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection