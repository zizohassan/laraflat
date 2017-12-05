@if (Route::has('login'))
    <li><a href="{{ url('/') }}">{{ trans('website.home') }}</a></li>
        @if (Auth::check())
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    @if(auth()->user()->group_id == 1)
                        <li><a href="{{ url(getCurrentLang().'/admin/home') }}">{{ trans('website.Admin') }}</a></li>
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
        @php $page = page(); @endphp
        <li><a href="{{ url('/page/'.$page->slug) }}">{{ getDefaultValueKey($page->title) }}</a></li>
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