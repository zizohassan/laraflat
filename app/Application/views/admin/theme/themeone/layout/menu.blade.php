@if(auth()->user()->group_id == 1)
    @foreach(getMenu('Admin') as $admin)
        <li>
            @if(array_key_exists('item' , $admin))
                <a href="{{ array_key_exists('sub' , $admin) ? 'javascript:void(0);' : url($admin['item']['link']) }}" class="{{ array_key_exists('sub' , $admin) ? 'menu-toggle' : '' }}">
                    @if(array_key_exists('sub' , $admin))
                        <span class="menu-caret">
                          <i class="material-icons">arrow_drop_down</i>
                        </span>
                    @endif
                    {!! $admin['item']['icon'] != null ? $admin['item']['icon']:  '' !!}
                    <span>
                        {{ getDefaultValueKey($admin['item']['name']) }}
                    </span>
                </a>
            @endif
            @if(array_key_exists('sub' , $admin))
                <ul class="sub-menu">
                    @foreach($admin['sub']  as $sub)
                        <li>
                            <a href="{{ url($sub['link']) }}"  class=" waves-effect waves-block">
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
@elseif(auth()->user()->group_id == 3)
    <li>
        <a href="{{ url('admin/car') }}"  class=" waves-effect waves-block">
            <i class="material-icons">local_car_wash</i>
            <span>
                Cars
             </span>
        </a>
    </li>

    <li>
        <a href="{{ url('admin/usecar') }}"  class=" waves-effect waves-block">
            <i class="material-icons">folder_shared</i>
            <span>
                Use Cars
             </span>
        </a>
    </li>


@endif
