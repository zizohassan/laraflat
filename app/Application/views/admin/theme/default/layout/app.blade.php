<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>
        @yield('title')
        |
        {{ getSetting('siteTitle') }}
    </title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    {{ Html::style('admin/plugins/bootstrap/css/bootstrap.css') }}
    {{ Html::style('admin/plugins/node-waves/waves.css') }}
    {{ Html::style('admin/plugins/animate-css/animate.css') }}
    {{ Html::style('admin/plugins/morrisjs/morris.css') }}
    {{ Html::style('admin/css/style.css') }}
    @if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
        {{ Html::style('admin/css/rtl/rtl.css') }}
    @endif
    {{ Html::style('admin/css/themes/all-themes.css') }}
    {{ Html::style('admin/plugins/multi-select/css/multi-select.css') }}
    {{ Html::style('admin/plugins/bootstrap-select/css/bootstrap-select.css') }}
    {{ Html::style('admin/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.min.css') }}
    {{ Html::style('css/sweetalert.css') }}
    {{ Html::style('admin/plugins/tinymce/plugins/elfinder/css/elfinder.full.css') }}
    @yield('style')
    <style>
        .card .header .header-dropdown{
            top:10px;
        }
    </style>

</head>

<body class="theme-red">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->
<div class="search-bar">
    <div class="search-icon">
        <i class="material-icons">search</i>
    </div>
    <input type="text" placeholder="START TYPING...">
    <div class="close-search">
        <i class="material-icons">close</i>
    </div>
</div>
<!-- #END# Search Bar -->
<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="{{ url('/admin/home') }}">
                {{ getSetting('siteTitle')  }}
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!-- Call Search -->
                <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                <!-- #END# Call Search -->
                <!-- Notifications -->

                <!-- #END# Notifications -->
            </ul>
        </div>
    </div>
</nav>
<!-- #Top Bar -->
<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <img src="{{ url('/admin') }}/images/user.png" width="48" height="48" alt="User" />
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ auth()->user()->name }}
                </div>
                <div class="email">
                    {{ auth()->user()->email }}
                </div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{ url('/admin/user/item/'.auth()->user()->id) }}"><i class="material-icons">person</i>{{ adminTrans('home' ,'profile') }}</a></li>
                        <li role="seperator" class="divider"></li>
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <li>
                                    <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                                        {{ $properties['native'] }}
                                    </a>
                                </li>
                            @endforeach
                        <li role="seperator" class="divider"></li>
                        <li><a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="material-icons">input</i>{{ adminTrans('home' ,'sign_out') }}</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">{{ adminTrans('home'  , 'MAIN_NAVIGATION') }}</li>
                @include(layoutMenu())
            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2017 <a href="javascript:void(0);">{{ getSetting('siteTitle')  }}</a>.
            </div>
            <div class="version">
                <b>Version: </b> 1.0
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>

<section class="content">
    <div class="container-fluid">
        @yield('content')
    </div>
</section>

{{ Html::script('admin/js/jquery.min.js') }}
{{ Html::script('admin/js/jquery-ui.min.js') }}
{{ Html::script('admin/plugins/bootstrap/js/bootstrap.js') }}
{{ Html::script('admin/plugins/bootstrap-select/js/bootstrap-select.js') }}
{{ Html::script('admin/plugins/jquery-slimscroll/jquery.slimscroll.js') }}
{{ Html::script('admin/plugins/node-waves/waves.js') }}
{{ Html::script('admin/plugins/jquery-countto/jquery.countTo.js') }}
{{ Html::script('admin/plugins/raphael/raphael.min.js') }}
{{ Html::script('admin/plugins/morrisjs/morris.js') }}
{{ Html::script('admin/plugins/chartjs/Chart.bundle.js') }}
{{ Html::script('admin/plugins/flot-charts/jquery.flot.js') }}
{{ Html::script('admin/plugins/flot-charts/jquery.flot.resize.js') }}
{{ Html::script('admin/plugins/flot-charts/jquery.flot.pie.js') }}
{{ Html::script('admin/plugins/flot-charts/jquery.flot.categories.js') }}
{{ Html::script('admin/plugins/flot-charts/jquery.flot.time.js') }}
{{ Html::script('admin/plugins/jquery-sparkline/jquery.sparkline.js') }}
{{ Html::script('admin/js/admin.js') }}
{{ Html::script('admin/js/pages/index.js') }}
{{ Html::script('admin/js/jquery.dataTables.min.js') }}
{{ Html::script('admin/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.min.js') }}
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