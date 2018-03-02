@extends(layoutExtend('website'))
@push('css')
<style>
    .navbar {
        margin-bottom: 0px;
    }

    .mainImage {
        min-height: 600px !important;
    }

    .imgMargintTop {
        margin-top: 170px !important;
    }
</style>
@endpush
@push('before')
<div class="text-center">
    <div class="title m-b-md margin mainImage" style="background-image: url('website/images/bg4.jpg');">
        <img src="{{ url('/admin/images/logo.png') }}" class="imgMargintTop" alt="{{ getSetting('siteTitle')  }}">
    </div>
</div>
@endpush
@section('content')
    <div class="pull-{{ getDirection() }} col-lg-9">
        @if(loadHomePageWidget())
            @foreach(loadHomePageWidget() as $file)
                @include($file)
            @endforeach
        @endif
    </div>
@endsection
