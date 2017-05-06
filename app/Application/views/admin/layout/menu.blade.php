
@foreach(getMenu('Admin') as $admin)
    <li>
        @if(array_key_exists('item' , $admin))
            <a href="{{ array_key_exists('sub' , $admin) ? 'javascript:void(0);' : url($admin['item']['link']) }}" class="{{ array_key_exists('sub' , $admin) ? 'menu-toggle' : '' }}">
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
                        <a href="{{ url($sub['link']) }}" target="{{ $sub['type'] }}" class=" waves-effect waves-block">
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
@endforeach
