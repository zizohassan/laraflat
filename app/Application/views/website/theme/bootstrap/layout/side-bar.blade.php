<div class="pull-{{ getReverseDirection() }} col-lg-3">
    @if(loadSidebarWidget())
        @foreach(loadSidebarWidget() as $file)
            @include($file)
        @endforeach
    @endif
</div>