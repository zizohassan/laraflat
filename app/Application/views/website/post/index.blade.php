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
			<input type="text" name="home" class="form-control " placeholder="{{ trans("post.home") }}" value="{{ request()->has("home") ? request()->get("home") : "" }}"> 
		</div> 
		 <button class="btn btn-success" type="submit" ><i class="fa fa-search" ></i ></button>
		<a href="{{ url("post") }}" class="btn btn-danger" ><i class="fa fa-close" ></i></a>
	 </form > 
<br ><table class="table table-responsive table-striped table-bordered"> 
		<thead > 
			<tr> 
				<th>{{ trans("post.title") }}</th> 
				<th>{{ trans("post.image") }}</th> 
				<th>{{ trans("post.file") }}</th> 
				<th>{{ trans("post.home") }}</th> 
				<th>{{ trans("post.des") }}</th> 
				<th>{{ trans("post.edit") }}</th> 
				<th>{{ trans("post.show") }}</th> 
				<th>{{
            trans("post.delete") }}</th> 
				</thead > 
		<tbody > 
		@if (count($items) > 0) 
			@foreach ($items as $d) 
				 <tr>
					<td>{{str_limit($d->title_lang , 20) }}</td> 
									 <td>
					 <img src="{{ url(env("SMALL_IMAGE_PATH")."/".getImageFromJson($d ,"image"))}}"  width = "80" />
					 </td> 
					 <td>
					 <a href="{{ url(env("UPLOAD_PATH")."/".getImageFromJson($d , "file"))}}"><i class="fa fa-file"></i></a>
					 </td> 
<td>{{ str_limit($d->home , 20) }}</td> 
				<td>{{str_limit($d->des_lang , 20) }}</td> 
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
