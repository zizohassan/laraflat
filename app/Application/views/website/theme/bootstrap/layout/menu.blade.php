<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ getSetting('siteTitle') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>
            <ul class="nav navbar-nav navbar-{{ getReverseDirection() }}">
                @if (Route::has('login'))
                    <li><a href="{{ url('/') }}">{{ trans('website.home') }}</a></li>
                    @if (Auth::check())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                @if(auth()->user()->group_id == 1)
                                    <li><a href="{{ url(getCurrentLang().'/admin/home') }}">{{ trans('website.Dashboard') }}</a></li>
                                @endif
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ url('/login') }}">{{ trans('website.login') }}</a></li>
                        <li><a href="{{ url('/register') }}">{{ trans('website.register') }}</a></li>
                    @endif
                    @php $pages = page(); @endphp
                    @foreach($pages as $page)
                        <li><a href="{{ url('page/'.$page->id.'/view') }}">{{ getDefaultValueKey($page->title) }}</a></li>
                    @endforeach
                    <li><a href="{{ url('contact') }}">{{ trans('website.Contact Us') }}</a></li>
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li>
                            <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                                {{ $properties['native'] }}
                            </a>
                        </li>
                    @endforeach
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ trans('website.Models') }}
                            <span class="caret"></span>
                        </a>
                        {!! menu('website' , 'ul' , 'dropdown-menu') !!}
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

