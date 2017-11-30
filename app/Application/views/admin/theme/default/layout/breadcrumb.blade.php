<ol class="breadcrumb breadcrumb-col-cyan">
    <li>
        <a href="{{ url('/admin/home') }}"><i class="material-icons">home</i>
            {{ trans('home.home') }}
        </a>
    </li>
    @isset($title)
        <li><a href="{{ url('/admin/'.$model) }}"><i class="material-icons">library_books</i> {{ ucfirst($title) }}</a></li>
    @endisset
    @isset($action)
         <li class="active">
            {{ $action }}  {{ ucfirst($title) }}
         </li>
    @endisset
</ol>