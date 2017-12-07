@extends(layoutExtend('website'))
@push('css')
<style>
    .navbar{
        margin-bottom:0px;
    }
    .mainImage{
        min-height: 600px !important;
    }
    .imgMargintTop{
        margin-top: 170px !important;
    }
</style>
@endpush
@section('content')
    <div class="text-center">
        <div class="title m-b-md margin mainImage" style="background-image: url('website/images/bg4.jpg');">
            <img src="{{ url('/admin/images/logo.png') }}" class="imgMargintTop" alt="{{ getSetting('siteTitle')  }}">
        </div>
    </div>
    </div>
@endsection
