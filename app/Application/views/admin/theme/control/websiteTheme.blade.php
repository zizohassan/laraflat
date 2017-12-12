
<div class="col-lg-12">
    <a href="{{ url('admin/theme/open-file?file=menu&type=website') }}" class="btn btn-warning col-lg-12">
        <div class="well text-center" style="min-height: 60px">
            {{ trans('admin.Menu') }}
        </div>
    </a>
        <div class="well text-center btn btn-info col-lg-12" style="min-height: 40px">
            {{ trans('admin.Header Stack') }}
        </div>
    <div class="row">
        <div class="col-lg-3">
            <a href="{{ url('admin/theme/open-file?file=side-bar&type=website') }}" class="btn btn-warning col-lg-12">
                <div class="well text-center" style="min-height: 500px">
                    {{ trans('admin.Sidebar') }}
                </div>
            </a>
        </div>
        <div class="col-lg-9">
            <a href="{{ url('admin/theme/open-file?file=content&type=website') }}" class="btn btn-danger col-lg-12">
                <div class="well text-center" style="min-height: 500px">
                    {{ trans('admin.Content') }}
                </div>
            </a>
        </div>

    </div>

    <a href="{{ url('admin/theme/open-file?file=footer&type=website') }}" class="btn btn-info col-lg-12">
        <div class="well text-center" style="min-height: 60px">
            {{ trans('admin.Footer') }}
        </div>
    </a>
</div>