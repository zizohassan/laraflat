@foreach(getMenu('Admin') as $admin)
    @if($admin['item']['id'] == 21 || $admin['item']['id'] == 28)
        @if(env('APP_ENV') == 'local' )
            <li>
                @if(array_key_exists('item' , $admin))
                    <a href="{{ array_key_exists('sub' , $admin) ? 'javascript:void(0);' : url($admin['item']['link']) }}"
                       class="{{ array_key_exists('sub' , $admin) ? 'menu-toggle' : '' }}">
                        {!! $admin['item']['icon'] != null ? $admin['item']['icon']:  '' !!}
                        <span>
                    {{ getDefaultValueKey($admin['item']['name']) }}
                </span>
                    </a>
                @endif
                @if(array_key_exists('sub' , $admin))
                    <ul class="ml-menu">
                        @foreach($admin['sub']  as $sub)
                            <li>
                                <a href="{{ url($sub['link']) }}" target="{{ $sub['type'] }}"
                                   class=" waves-effect waves-block">
                                    {!! $sub['icon'] != null ? $sub['icon']:  '' !!}
                                    <span>
                                 {{ getDefaultValueKey($sub['name']) }}
                            </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endif
    @else
        <li>
            @if(array_key_exists('item' , $admin))
                <a href="{{ array_key_exists('sub' , $admin) ? 'javascript:void(0);' : url($admin['item']['link']) }}"
                   class="{{ array_key_exists('sub' , $admin) ? 'menu-toggle' : '' }}">
                    {!! $admin['item']['icon'] != null ? $admin['item']['icon']:  '' !!}
                    <span>
                    {{ getDefaultValueKey($admin['item']['name']) }}
                </span>
                </a>
            @endif
            @if(array_key_exists('sub' , $admin))
                <ul class="ml-menu">
                    @foreach($admin['sub']  as $sub)
                        @if($sub['id'] == 13 ||$sub['id'] == 12 ||$sub['id'] == 11||$sub['id'] == 14||$sub['id'] == 15 )
                            <li>
                                <a href="{{ url($sub['link']) }}" target="{{ $sub['type'] }}"
                                   class=" waves-effect waves-block">
                                    {!! $sub['icon'] != null ? $sub['icon']:  '' !!}
                                    <span>
                                 {{ getDefaultValueKey($sub['name']) }}
                            </span>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ url($sub['link']) }}" class=" waves-effect waves-block">
                                    {!! $sub['icon'] != null ? $sub['icon']:  '' !!}
                                    <span>
                                                 {{ getDefaultValueKey($sub['name']) }}
                                            </span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </li>
    @endif
@endforeach
