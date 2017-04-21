@extends('admin.layout.app')

@section('title')
    group Control
@endsection

@section('content')
    @include('admin.layout.table' , ['title' => 'group' , 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection