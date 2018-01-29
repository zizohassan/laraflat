@extends(layoutExtend())

@section('title')
    {{ trans('log.log') }} {{ trans('curd.control') }}
@endsection

@section('style')
    @include('admin.shared.style')
@endsection

@push('header')
    <button class="btn btn-danger" onclick="deleteThemAll(this)" data-link="{{ url('admin/log/pluck') }}" ><i class="fa fa-trash"></i></button>
    <button class="btn btn-success" onclick="checkAll(this)"  ><i class="fa fa-check-circle-o"></i> </button>
    <button class="btn btn-warning" onclick="unCheckAll(this)"  ><i class="fa fa-check-circle"></i> </button>
@endpush

@push('search')
    <form method="get" class="form-inline">
        <div class="form-group">
            <input type="text" name="from" class="form-control datepicker2" placeholder="{{ trans('admin.from') }}" value="{{ request()->has('from') ? request()->get('from') : '' }}">
        </div>
        <div class="form-group">
            <input type="text" name="to" class="form-control datepicker2" placeholder="{{ trans('admin.to') }}" value="{{ request()->has('to') ? request()->get('to') : '' }}">
        </div>
        <div class="form-group">
            <input type="text" name="action" class="form-control" placeholder="{{ trans('log.action') }}" value="{{ request()->has('action') ? request()->get('action') : '' }}">
        </div>
        <div class="form-group">
            <input type="text" name="model" class="form-control" placeholder="{{ trans('log.model') }}" value="{{ request()->has('model') ? request()->get('model') : '' }}">
        </div>
        <button class="btn btn-success" type="submit" ><i class="fa fa-search"></i></button>
        <a href="{{ url('admin/log') }}" class="btn btn-danger" ><i class="fa fa-close"></i></a>
    </form>
@endpush

@section('content')
    @include(layoutTable() , ['title' => trans('log.log') , 'model' => 'log' , 'table' => $dataTable->table([] , true) , 'button' => false])
@endsection

@section('script')
    @include('admin.shared.scripts')
@endsection