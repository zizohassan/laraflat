@extends('admin.layout.app')

@section('title')
    categorie Control
@endsection

@section('content')
    @include('admin.layout.table' , ['title' => 'categorie' , 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection