@extends('admin.layout.app')

@section('title')
    User Control
@endsection

@section('content')
    @include('admin.layout.table' , ['title' => 'user' , 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection