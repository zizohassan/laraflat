<div class="header">
    <h2>
        {{ isset($action) ? ucfirst($action) : trans('home.control') }}  {{ ucfirst($title) }}
    </h2>
   @if($button == true)
        <ul class="header-dropdown m-r--5">
            <li>
                <a href="{{ url('admin/'.$model.'/item') }}" class="btn bg-cyan waves-effect">
                    <i class="material-icons">add</i> {{ trans('home.add') }} {{ ucfirst($title) }}
                </a>
            </li>
        </ul>
    @endif
</div>
<br>