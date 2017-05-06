@extends('admin.layout.app')

@section('title')
    {{  adminTrans('group' , 'group')}} {{ adminTrans('home' , 'control') }}
@endsection

@section('content')
    @include('admin.layout.table' , ['title' =>  adminTrans('group' , 'group'), 'model'=>'group', 'table' => $dataTable->table() ])
@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection