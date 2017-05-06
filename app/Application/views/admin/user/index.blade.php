@extends('admin.layout.app')

@section('title')
    {{ adminTrans('user' , 'user') }} {{ adminTrans('home' , 'control') }}
@endsection

@section('content')
    @include('admin.layout.table' , ['title' => adminTrans('user' , 'user') , 'model' => 'user' , 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection