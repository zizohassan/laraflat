@extends(layoutExtend('website'))

@section('title')
    {{ trans('post.post') }} {{  isset($item) ? trans('home.edit')  : trans('home.add')  }}
@endsection

@section('content')
<div class="pull-{{ getDirection() }} col-lg-9">
         @include(layoutMessage('website'))
         <a href="{{ url('post') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> {{ trans('website.Back') }}  </a>
        <form action="{{ concatenateLangToUrl('post/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
             		 <div class="form-group  {{  $errors->has("title.en")  &&  $errors->has("title.ar")  ? "has-error" : "" }}" >
			<label for="title">{{ trans("post.title")}}</label>
				{!! extractFiled(isset($item) ? $item : null , "title", isset($item->title) ? $item->title : old("title") , "text" , "post") !!}
		</div>
			@if ($errors->has("title.en"))
				<span class='help-block'>
					<strong>{{ $errors->first("title.en") }}</strong>
				</span>
			@endif
			@if ($errors->has("title.ar"))
				<span class='help-block'>
					<strong>{{ $errors->first("title.ar") }}</strong>
				</span>
			@endif
		 <div class="form-group  {{  $errors->has("body.en")  &&  $errors->has("body.ar")  ? "has-error" : "" }}" >
			<label for="body">{{ trans("post.body")}}</label>
				{!! extractFiled(isset($item) ? $item : null , "body", isset($item->body) ? $item->body : old("body") , "text" , "post") !!}
		</div>
			@if ($errors->has("body.en"))
				<span class='help-block'>
					<strong>{{ $errors->first("body.en") }}</strong>
				</span>
			@endif
			@if ($errors->has("body.ar"))
				<span class='help-block'>
					<strong>{{ $errors->first("body.ar") }}</strong>
				</span>
			@endif
		 <div class="form-group {{ $errors->has("active") ? "has-error" : "" }}" > 
			<label for="active">{{ trans("post.active")}}</label>
				 <div class="form-check">
					<label class="form-check-label">
					<input class="form-check-input" name="active" {{ isset($item->active) && $item->active == 0 ? "checked" : "" }} type="radio" value="0" > 
					{{ trans("post.No")}}
				 </label > 
				<label class="form-check-label">
				<input class="form-check-input" name="active" {{ isset($item->active) && $item->active == 1 ? "checked" : "" }} type="radio" value="1" > 
									{{ trans("post.Yes")}}
				 </label> 
				</div> 		</div>
			@if ($errors->has("active"))
				<span class='help-block'>
					<strong>{{ $errors->first("active") }}</strong>
				</span>
			@endif

            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="fa fa-save"></i>
                    {{ trans('website.Update') }}  {{ trans('website.post') }}
                </button>
            </div>
        </form>
</div>
@endsection
