@include('admin.layout.breadcrumb')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            @include('admin.layout.header')
            <div class="body">
                {!! $table !!}
            </div>
        </div>
    </div>
</div>