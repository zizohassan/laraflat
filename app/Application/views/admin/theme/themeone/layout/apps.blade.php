<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1"/>
    <meta name="msapplication-tap-highlight" content="no">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="Milestone">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Milestone">

    <meta name="theme-color" content="#4C7FF0">

    <title>
        @yield('title')
        |
        {{ getSetting('siteTitle') }}
    </title>

    <!-- page stylesheets -->
    <link rel="stylesheet" href="{{ url('style') }}/vendor/bower-jvectormap/jquery-jvectormap-1.2.2.css"/>
    <!-- end page stylesheets -->

    <!-- build:css({.tmp,app}) styles/app.min.css -->
    <link rel="stylesheet" href="{{ url('style') }}/vendor/bootstrap/dist/css/bootstrap.css"/>
    <link rel="stylesheet" href="{{ url('style') }}/vendor/PACE/themes/blue/pace-theme-minimal.css"/>
    <link rel="stylesheet" href="{{ url('style') }}/vendor/font-awesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="{{ url('style') }}/vendor/animate.css/animate.css"/>
    <link rel="stylesheet" href="{{ url('style') }}/styles/app.css" id="load_styles_before"/>
    <link rel="stylesheet" href="{{ url('style') }}/styles/app.skins.css"/>
    <!-- endbuild -->

    {{ Html::style('admin/plugins/multi-select/css/multi-select.css') }}
    {{ Html::style('admin/plugins/bootstrap-select/css/bootstrap-select.css') }}
    {{--{{ Html::style('admin/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.min.css') }}--}}
    <link rel="stylesheet" href="{{ url('style') }}/vendor/datatables/media/css/dataTables.bootstrap4.css"/>

    {{ Html::style('css/sweetalert.css') }}
    {{ Html::style('admin/plugins/tinymce/plugins/elfinder/css/elfinder.full.css') }}
    @yield('style')
    {!! ConsoleTVs\Charts\Charts::assets() !!}
    @if(getDir() == 'rtl')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css">
    @endif
</head>
<body>

<div class="app">
    <!--sidebar panel-->
    <div class="off-canvas-overlay" data-toggle="sidebar"></div>
    <div class="sidebar-panel">
        <div class="brand">
            <!-- toggle offscreen menu -->
            <a href="javascript:;" data-toggle="sidebar" class="toggle-offscreen hidden-lg-up">
                <i class="material-icons">menu</i>
            </a>
            <!-- /toggle offscreen menu -->
            <!-- logo -->
            <a class="brand-logo">
                <img class="expanding-hidden" src="{{ url('/style') }}/images/logo.png" alt=""/>
            </a>
            <!-- /logo -->
        </div>
        <div class="nav-profile dropdown">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                <div class="user-image">
                    <img src="{{ url('/style') }}/images/avatar.jpg" class="avatar img-circle" alt="user" title="user"/>
                </div>
                <div class="user-info expanding-hidden">
                    {{ auth()->user()->name }}
                    <small class="bold">{{ auth()->user()->email }}</small>
                </div>
            </a>
            <div class="dropdown-menu">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a class="dropdown-item" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                        {{ $properties['native'] }}
                    </a>
                @endforeach
                <div class="dropdown-divider"></div>
                <a href="{{ url('/admin/user/item/'.auth()->user()->id) }}"><i class="material-icons">person</i>{{ trans('home.profile') }}</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="material-icons">input</i>{{ trans('home.sign_out') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
        <!-- main navigation -->
        <nav>
            <p class="nav-title">NAVIGATION</p>
            <ul class="nav">
                @include(layoutMenu())
            </ul>
        </nav>
        <!-- /main navigation -->
    </div>
    <!-- /sidebar panel -->
    <!-- content panel -->
    <div class="main-panel">
        <!-- top header -->
        <nav class="header navbar">
            <div class="header-inner">
                <div class="navbar-item navbar-spacer-right brand hidden-lg-up">
                    <!-- toggle offscreen menu -->
                    <a href="javascript:;" data-toggle="sidebar" class="toggle-offscreen">
                        <i class="material-icons">menu</i>
                    </a>
                    <!-- /toggle offscreen menu -->
                    <!-- logo -->
                    <a class="brand-logo hidden-xs-down">
                        <img src="{{ url('/style') }}/images/logo_white.png" alt="logo"/>
                    </a>
                    <!-- /logo -->
                </div>
                <a class="navbar-item navbar-spacer-right navbar-heading hidden-md-down" href="#">
                    <span>
                        @yield('title')
                    </span>
                </a>

            </div>
        </nav>
        <!-- /top header -->

        <!-- main area -->
        <div class="main-content">
            <div class="content-view">
                @yield('content')
            </div>
            <!-- bottom footer -->
            <div class="content-footer">
                <nav class="footer-left">
                    <ul class="nav">
                        <li>
                            <a href="javascript:;">
                                <span>Copyright</span>
                                &copy; 2016 BlueCrunch
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- /bottom footer -->
        </div>
        <!-- /main area -->
    </div>
    <!-- /content panel -->

</div>

{{--<script type="text/javascript">--}}
{{--window.paceOptions = {--}}
{{--document: true,--}}
{{--eventLag: true,--}}
{{--restartOnPushState: true,--}}
{{--restartOnRequestAfter: true,--}}
{{--ajax: {--}}
{{--trackMethods: [ 'POST','GET']--}}
{{--}--}}
{{--};--}}
{{--</script>--}}

        <!-- build:js({.tmp,app}) scripts/app.min.js -->
<script src="{{ url('style') }}/vendor/jquery/dist/jquery.js"></script>
<script src="{{ url('style') }}/vendor/PACE/pace.js"></script>
<script src="{{ url('style') }}/vendor/tether/dist/js/tether.js"></script>
<script src="{{ url('style') }}/vendor/bootstrap/dist/js/bootstrap.js"></script>
<script src="{{ url('style') }}/vendor/fastclick/lib/fastclick.js"></script>
<script src="{{ url('style') }}/scripts/constants.js"></script>
<script src="{{ url('style') }}/scripts/main.js"></script>
<!-- endbuild -->

<!-- page scripts -->
<script src="{{ url('style') }}/vendor/flot/jquery.flot.js"></script>
<script src="{{ url('style') }}/vendor/flot/jquery.flot.resize.js"></script>
<script src="{{ url('style') }}/vendor/flot/jquery.flot.stack.js"></script>
<script src="{{ url('style') }}/vendor/flot-spline/js/jquery.flot.spline.js"></script>
<script src="{{ url('style') }}/vendor/bower-jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{ url('style') }}/data/maps/jquery-jvectormap-us-aea.js"></script>
<script src="{{ url('style') }}/vendor/jquery.easy-pie-chart/dist/jquery.easypiechart.js"></script>
<script src="{{ url('style') }}/vendor/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script src="{{ url('style') }}/scripts/helpers/noty-defaults.js"></script>
<!-- end page scripts -->

<!-- initialize page scripts -->
<script src="{{ url('style') }}/scripts/dashboard/dashboard.js"></script>
<!-- end initialize page scripts -->
{{ Html::script('admin/js/jquery.dataTables.min.js') }}
{{--{{ Html::script('admin/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.min.js') }}--}}
<script src="{{ url('style') }}/vendor/datatables/media/js/dataTables.bootstrap4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>

{{ Html::script('js/sweetalert.min.js') }}
<script type="application/javascript">
    function deleteThisItem(e){
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
                function(){
                    window.location = link;
                });
    }
</script>
@include('sweet::alert')
@yield('script')
</body>
</html>
