@extends(layoutExtend('website'))
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
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('website.Contact Us') }}</div>
                    <div class="panel-body">
                        <form class="row" action="{{ concatenateLangToUrl('contact') }}" name="contactform"
                              method="post">
                            {{ csrf_field() }}
                            <div class="col-md-6 margin {{  $errors->has("name")   ? "has-error" : "" }}">
                                <input type="text" name="name" id="name" class="form-control"
                                       placeholder="{{ trans('website.Name') }}"
                                       value="{{ auth()->check() ? auth()->user()->name : old('name') ?? '' }}" required>
                                @if ($errors->has("name"))
                                    <div class="alert alert-danger">
                                        <span class='help-block'>
                                            <strong>{{ $errors->first("name") }}</strong>
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6 margin {{  $errors->has("email")   ? "has-error" : "" }}">
                                <input type="text" name="email" id="email" class="form-control"
                                       placeholder="{{ trans('website.Email') }}"
                                       required {{ auth()->check() ? auth()->user()->email : old('email') ?? '' }}>
                                @if ($errors->has("email"))
                                    <div class="alert alert-danger">
                                        <span class='help-block'>
                                            <strong>{{ $errors->first("email") }}</strong>
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6 margin {{  $errors->has("phone")   ? "has-error" : "" }}">
                                <input type="text" name="phone" id="phone" class="form-control"
                                       placeholder="{{ trans('website.Phone') }}" value="{{ old('phone') ?? '' }}">
                                @if ($errors->has("phone"))
                                    <div class="alert alert-danger">
                                        <span class='help-block'>
                                            <strong>{{ $errors->first("phone") }}</strong>
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6 margin {{  $errors->has("subject")   ? "has-error" : "" }}">
                                <input type="text" name="subject" id="subject" class="form-control"
                                       placeholder="{{ trans('website.Subject') }}" required value="{{ old('subject') ?? '' }}">
                                @if ($errors->has("subject"))
                                    <div class="alert alert-danger">
                                        <span class='help-block'>
                                            <strong>{{ $errors->first("subject") }}</strong>
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12 margin {{  $errors->has("phone")   ? "has-error" : "" }}">
                    <textarea class="form-control" name="message" id="comments" rows="6"
                              placeholder="{{ trans('website.Message Below') }}" required>{{ old('message') ?? '' }}</textarea>
                                @if ($errors->has("message"))
                                    <div class="alert alert-danger">
                                        <span class='help-block'>
                                            <strong>{{ $errors->first("message") }}</strong>
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12 margin">
                                <button type="submit" value="SEND" id="submit"
                                        class="btn btn-primary">{{ trans('website.Send Form') }} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection