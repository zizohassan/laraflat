<div class="col-lg-12">
    @foreach($files as $file)
        <a href="{{ url('admin/theme/open-file?file='.$file.'&type='.$theme) }}" class="btn btn-warning col-lg-12">
            <div class="well text-center" style="min-height: 60px">
                {{ $file }}
            </div>
        </a>
    @endforeach
</div>