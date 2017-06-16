<div class="card-header no-bg b-a-0">
  @if(getDir() == 'rtl')
    <h2 class="pull-right">
  @else
    <h2 class="pull-left">
  @endif
        {{ isset($action) ? ucfirst($action) : adminTrans('home' , 'control') }}  {{ ucfirst($title) }}
    </h2>
   @if($button == true)
           @if(getDir() == 'rtl')
             <h2 class="pull-left">
           @else
             <h2 class="pull-right">
           @endif
              <a href="{{ url('admin/'.$model.'/item') }}" class="btn bg-cyan btn-icon m-r-xs m-b-xs waves-effect">
                  <i class="material-icons">add</i> {{ adminTrans('home' , 'add') }} {{ ucfirst($title) }}
              </a>
       </span>
    @endif
    <div class="clearfix"></div>
</div>
