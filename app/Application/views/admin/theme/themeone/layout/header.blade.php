<div class="card-header no-bg b-a-0">
    <h2 class="pull-left">
        {{ isset($action) ? ucfirst($action) : adminTrans('home' , 'control') }}  {{ ucfirst($title) }}
    </h2>
   @if($button == true)
       <span class="pull-right">
              <a href="{{ url('admin/'.$model.'/item') }}" class="btn bg-cyan waves-effect">
                  <i class="material-icons">add</i> {{ adminTrans('home' , 'add') }} {{ ucfirst($title) }}
              </a>
       </span>
    @endif
    <div class="clearfix"></div>
</div>
<br>