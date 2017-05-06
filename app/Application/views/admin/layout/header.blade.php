<div class="header">
    <h2>
        {{ ucfirst($title) }}  {{ isset($action) ? ucfirst($action) : adminTrans('home' , 'control') }}
    </h2>
   @if($button == true)
        <ul class="header-dropdown m-r--5">
            <li>
                <a href="{{ url('admin/'.$model.'/item') }}" class="btn bg-cyan waves-effect">
                    <i class="material-icons">add</i> {{ adminTrans('home' , 'add') }} {{ ucfirst($title) }}
                </a>
            </li>
        </ul>
    @endif
</div>
<br>