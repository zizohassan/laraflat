<ol class="breadcrumb breadcrumb-col-cyan">
    <li><a href="{{ url('/admin') }}"><i class="material-icons">home</i> Home</a></li>
    @isset($title)
        <li><a href="{{ url('/admin/'.$title) }}"><i class="material-icons">library_books</i> {{ ucfirst($title) }}</a></li>
    @endisset
    @isset($action)
         <li class="active">
            {{ $action }}  {{ ucfirst($title) }}
         </li>
    @endisset
</ol>