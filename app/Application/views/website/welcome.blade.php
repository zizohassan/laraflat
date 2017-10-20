@extends('layouts.app')
@push('css')
<style>
    .margin{
        margin-top:100px;
        margin-bottom:100px;
    }
</style>
@endpush
@section('content')
            <div class="content text-center">
                <div class="title m-b-md margin">
                    <img src="{{ url('/admin/images/logo.png') }}" alt="{{ getSetting('siteTitle')  }}">
                </div>
                    @include('layouts.messages')
                    <div class="col-lg-4 col-md-offset-4 ">
                        {!!  menu('Main' ,'ul' ,'list-group' , 'list-group-item') !!}
                    </div>
            </div>
        </div>
@endsection
