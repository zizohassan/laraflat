@extends('layouts.app')
@push('css')
<style>
    .margin {
        margin-bottom: 20px;
    }
</style>
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ adminTrans('website','Contact Us') }}</div>
                    <div class="panel-body">
                        <form class="row" action="{{ concatenateLangToUrl('contact') }}" name="contactform"
                              method="post">
                            {{ csrf_field() }}
                            <div class="col-md-6 margin">
                                <input type="text" name="name" id="name" class="form-control"
                                       placeholder="{{ adminTrans('website','Name') }}"
                                       value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                            </div>
                            <div class="col-md-6 margin">
                                <input type="text" name="email" id="email" class="form-control"
                                       placeholder="{{ adminTrans('website','Email') }}"
                                       required {{ auth()->check() ? auth()->user()->email : '' }}>
                            </div>
                            <div class="col-md-6 margin">
                                <input type="text" name="phone" id="phone" class="form-control"
                                       placeholder="{{ adminTrans('website','Phone') }}">
                            </div>
                            <div class="col-md-6 margin">
                                <input type="text" name="subject" id="subject" class="form-control"
                                       placeholder="{{ adminTrans('website','Subject') }}" required>
                            </div>
                            <div class="col-md-12 margin">
                    <textarea class="form-control" name="message" id="comments" rows="6"
                              placeholder="{{ adminTrans('website','Message Below') }}" required></textarea>
                            </div>
                            <div class="col-md-12 margin">
                                <button type="submit" value="SEND" id="submit"
                                        class="btn btn-primary">{{ adminTrans('website','Send Form') }} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection