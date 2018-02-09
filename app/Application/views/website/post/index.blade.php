@extends(layoutExtend('website'))

@section('title')
     {{ trans('post.post') }} {{ trans('home.control') }}
@endsection

@section('content')
 <div class="pull-{{ getDirection() }} col-lg-9">
    <div><h1>{{ trans('website.post') }}</h1></div>
     <div><a href="{{ url('post/item') }}" class="btn btn-default"><i class="fa fa-plus"></i> {{ trans('website.post') }}</a><br></div>
 	<form method="get" class="form-inline">
		<div class="form-group">
			<input type="text" name="from" class="form-control datepicker2" placeholder="{{ trans("admin.from") }}"value="{{ request()->has("from") ? request()->get("from") : "" }}">
		 </div>
		<div class="form-group">
			<input type="text" name="to" class="form-control datepicker2" placeholder="{{ trans("admin.to") }}"value="{{ request()->has("to") ? request()->get("to") : "" }}">
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
		<div class="form-group" > 
			<select style="width:80px;" name="active" class="form-control select2" placeholder="{{ trans("post.active") }}" > 
				<option value="1" {{ request()->has("active") && request()->get("active") === 1 ? "selected" : "" }}>{{trans("post.Yes") }} </option> 
				<option value="0" {{request()->has("active") && request()->get("active") === 0 ? "selected" : "" }}>{{trans("post.No") }} </option> 
			</select> 
		</div> 
		 <button class="btn btn-success" type="submit" ><i class="fa fa-search" ></i ></button>
		<a href="{{ url("post") }}" class="btn btn-danger" ><i class="fa fa-close" ></i></a>
	 </form > 
<br ><table class="table table-responsive table-striped table-bordered"> 
		<thead > 
			<tr> 
				<th>{{ trans("post.title") }}</th> 
				<th>{{ trans("post.edit") }}</th> 
				<th>{{ trans("post.show") }}</th> 
				<th>{{
            trans("post.delete") }}</th> 
				</thead > 
		<tbody > 
		@if (count($items) > 0) 
			@foreach ($items as $d) 
				 <tr>
					<td>{{ str_limit($d->title , 20) }}</td> 
				<td> @include("website.post.buttons.edit", ["id" => $d->id])</td> 
					<td> @include("website.post.buttons.view", ["id" => $d->id])</td> 
					<td> @include("website.post.buttons.delete", ["id" => $d->id])</td> 
					</tr> 
					@endforeach
				@endif
			 </tbody > 
		</table > 
	@include(layoutPaginate() , ["items" => $items])
		
</div>
@endsection
