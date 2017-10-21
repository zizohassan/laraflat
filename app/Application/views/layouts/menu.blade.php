@if (Route::has('login'))
        <li><a href="{{ url('/') }}">{{ adminTrans('website' , 'home') }}</a></li>
        @if (Auth::check())
            <li><a href="{{ url('/home') }}">{{ adminTrans('website' , 'home') }}</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
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
            <li><a href="{{ url('/login') }}">{{ adminTrans('website' , 'login') }}</a></li>
            <li><a href="{{ url('/register') }}">{{ adminTrans('website' , 'register') }}</a></li>
        @endif
        @php $page = page(); @endphp
        <li><a href="{{ url('/page/'.$page->slug) }}">{{ getDefaultValueKey($page->title) }}</a></li>
        <li><a href="{{ url('contact') }}">{{ adminTrans('website' , 'Contact Us') }}</a></li>
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <li>
                <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                    {{ $properties['native'] }}
                </a>
            </li>
        @endforeach
@endif