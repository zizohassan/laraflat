@include(layoutBreadcrumb())
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            @php $button = isset($button) ? $button : true @endphp
            @include(layoutHeader()  , ['button' => $button])
            <div class="body">
                {!! $table !!}
            </div>
        </div>
    </div>
</div>