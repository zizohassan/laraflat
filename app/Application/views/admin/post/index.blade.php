@extends(layoutExtend())

@section('title')
     {{ trans('post.post') }} {{ trans('home.control') }}
@endsection

@section('style')
    @include('admin.shared.style')
@endsection

@push('header')
    <button class="btn btn-danger" onclick="deleteThemAll(this)" data-link="{{ url('admin/post/pluck') }}" ><i class="fa fa-trash"></i></button>
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
			<input type="text" name="title" class="form-control " placeholder="{{ trans("post.title") }}" value="{{ request()->has("title") ? request()->get("title") : "" }}">
		</div>
		<div class="form-group">
			<input type="text" name="t" class="form-control " placeholder="{{ trans("post.t") }}" value="{{ request()->has("t") ? request()->get("t") : "" }}">
		</div>
		<div class="form-group">
			<input type="text" name="date" class="form-control datepicker2" placeholder="{{ trans("post.date") }}" value="{{ request()->has("date") ? request()->get("date") : "" }}">
		</div>
		<div class="form-group">
			<select style="width:80px" name="active" class="form-control select2" placeholder="{{ trans("post.active") }}">
				<option value="1"{{ request()->has("active") &&  request()->get("active") === 1 ? "selected" : "" }}>{{ trans("post.Yes") }}</option>
				<option value="0"{{ request()->has("active") &&  request()->get("active") === 0 ? "selected" : "" }}>{{ trans("post.No") }}</option>
		</select>
		</div>

        <button class="btn btn-success" type="submit" ><i class="fa fa-search"></i></button>
        <a href="{{ url('admin/post') }}" class="btn btn-danger" ><i class="fa fa-close"></i></a>
    </form>
@endpush

@section('content')
    @include(layoutTable() , ['title' => trans('post.post') , 'model' => 'post' , 'table' => $dataTable->table([] , true) ])
@endsection

@section('script')
    @include('admin.shared.scripts')
@endsection