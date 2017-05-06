@extends('admin.layout.app')

@section('title')
    {{ adminTrans('page' , 'page') }}  {{ adminTrans('home' , 'control') }}
@endsection

@section('content')
    @include('admin.layout.table' , ['title' =>adminTrans('page' , 'page')  , 'model' => 'page' , 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection