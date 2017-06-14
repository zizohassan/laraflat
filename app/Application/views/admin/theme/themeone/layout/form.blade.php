@include(layoutBreadcrumb())
<div class="card">
            <div class="card-block">
            @php $button = isset($button) ? $button : true @endphp
            @include(layoutHeader() , ['button' => $button , 'model' => $model])
            <div class="body">
                {{ $slot }}
            </div>
       </div>
</div>
