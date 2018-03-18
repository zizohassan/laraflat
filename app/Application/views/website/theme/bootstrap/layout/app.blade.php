<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laraflat') }} | @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @if(getDir() == 'rtl')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css">
    @endif
    {{ Html::style('css/sweetalert.css') }}
    {{ Html::Style('website/css/custom.css') }}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    {{ Html::style('css/rate.css') }}
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    @stack('css')
    <link href="{{ url('/css/mainselec2.css') }}" rel="stylesheet"/>
    <link href="{{ url('/css/select2.css') }}" rel="stylesheet"/>
    <link href="{{ url('/css/bootstrap-datetimepicker.css') }}" rel="stylesheet"/>
    <!-- if you not use map remove this -->
        {{ Html::style('css/map.css') }}
    <!-- if you not use map remove this -->
</head>
<body>
<div id="app">
    @include(layoutMenu('website'))
    @include(layoutPushHeader('website'))
    @stack('before')
    @include(layoutContent('website'))
    @stack('after')
    @include(layoutPushFooter('website'))
    @include(layoutFooter('website'))
</div>
<script src="{{ asset('js/app.js') }}"></script>
{!! Links::track(true) !!}
{{ Html::script('js/sweetalert.min.js') }}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/jquery.barrating.min.js"></script>
<script src="{{ url('js/select2.min.js') }}"></script>
<script src="{{ url('js/moment.js') }}"></script>
<script src="{{ url('js/bootstrap-datetimepicker.js') }}"></script>
<script type="application/javascript">
    $('.select2').select2({
        theme: "bootstrap",
        dir: "rtl"
    });
    $('.datepicker').datetimepicker({
        defaultDate: "{{ date('Y/m/d') }}",
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        format: 'Y/MM/DD'
    });
    $('.datepicker2').datetimepicker({
        defaultDate: "",
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        format: 'Y/MM/DD'
    });

    $('.time').datetimepicker({
        format: 'LT',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        }
    });
    function deleteThisItem(e) {
        var link = $(e).data('link');
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this Item Again!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function () {
                window.location = link;
            });
    }
    $('#rate').barrating({
        theme: 'fontawesome-stars',
        onSelect: function (value, text, event) {
            $('#rate').closest('form').submit();
        }
    });
</script>
<!-- if you not use map remove this -->
    <script src="{{ url('js/map.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ getSetting('GOOGLE_API_MAP') }}&libraries=places&callback=initMap" async defer></script>
    <script src="{{ url('js/showMap.js') }}" async defer></script>
<!-- if you not use map remove this -->
<script src="{{ url('js/fontawesome-iconpicker.min.js') }}"></script>
<script>
    $('.icon-field').iconpicker();
</script>
@include('sweet::alert')
@stack('js')

</body>
</html>
