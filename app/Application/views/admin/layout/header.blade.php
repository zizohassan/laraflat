<div class="header">
    <h2>
        {{ ucfirst($title) }}  {{ isset($action) ? ucfirst($action) : ucfirst('control') }}
    </h2>
   @if($button == true)
        <ul class="header-dropdown m-r--5">
            <li>
                <a href="{{ url('admin/'.$title.'/item') }}" class="btn bg-cyan waves-effect">
                    <i class="material-icons">add</i> Add {{ ucfirst($title) }}
                </a>
            </li>
        </ul>
    @endif
</div>
<br>