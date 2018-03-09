<div class="col-lg-3">
    <a href="{{ url('admin/theme/open-file?file=menu&type=admin') }}" class="btn btn-warning col-lg-12">
        <div class="well text-center" style="min-height: 500px">
            {{ trans('admin.sidebar') }}
        </div>
    </a>
</div>
<div class="col-lg-9">
    <a href="{{ url('admin/theme/open-file?file=breadcrumb&type=admin') }}" class="btn btn-danger col-lg-12">
        <div class="well text-center" style="min-height: 50px">
            {{ trans('admin.BreadCeamb') }}
        </div>
    </a>
    <a href="{{ url('admin/theme/open-file?file=header&type=admin') }}" class="btn btn-primary col-lg-12">
        <div class="well text-center" style="min-height: 100px">
            {{ trans('admin.Header') }}
        </div>
    </a>
    <a href="{{ url('admin/theme/open-file?file=form&type=admin') }}" class="btn btn-info col-lg-12">
        <div class="well text-center" style="min-height: 300px">
            {{ trans('admin.Content') }}
        </div>
    </a>
</div>