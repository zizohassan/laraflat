@extends(layoutExtend())

@section('title')
    {{ trans('post.post') }} {{  isset($item) ? trans('home.edit')  : trans('home.add')  }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => trans('post.post') , 'model' => 'post' , 'action' => isset($item) ? trans('home.edit')  : trans('home.add')  ])
         @include(layoutMessage())
        <form action="{{ concatenateLangToUrl('admin/post/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

 		<div class="form-group">
			<label for="title">{{ trans("post.title")}}</label>
				{!! extractFiled(isset($item) ? $item : null , "title" , isset($item->title) ? $item->title : old("title") , "text" , "post") !!}
		</div>
		<div class="form-group">
			<label for="image">{{ trans("post.image")}}</label>
				<div id="laraflat-image">
					@isset($item)
						@if(json_decode($item->image))
							<input type="hidden" name="oldFiles_image" value="{{ $item->image }}">
							@php $files = returnFilesImages($item , "image"); @endphp
							<div class="row text-center">
							@foreach($files["image"] as $jsonimage )
								<div class="col-lg-2 text-center"><img src="{{ url(env("SMALL_IMAGE_PATH")."/".$jsonimage) }}" class="img-responsive" /><br>
								<a class="btn btn-danger" href="{{ url("deleteFile/post/".$item->id."?name=".$jsonimage."&filed_name=image") }}"><i class="fa fa-trash"></i></a></div>
							@endforeach
							</div>
							<div class="row text-center">
							@foreach($files["file"] as $jsonimage )
								<div class="col-lg-2 text-center"><a href="{{ url(env("UPLOAD_PATH")."/".$jsonimage) }}" ><i class="fa fa-file"></i></a>
								<a  href="{{ url("deleteFile/post/".$item->id."?name=".$jsonimage."&filed_name=image") }}"><i class="fa fa-trash"></i> {{ $jsonimage }} </a></div>
							@endforeach
					</div>
						@endif
					@endisset
						<input name="image[]"  type="file" multiple >
					</div>
		</div>
		<div class="form-group">
			<label for="file">{{ trans("post.file")}}</label>
				<div id="laraflat-file">
					@isset($item)
						@if(json_decode($item->file))
							<input type="hidden" name="oldFiles_file" value="{{ $item->file }}">
							@php $files = returnFilesImages($item , "file"); @endphp
							<div class="row text-center">
							@foreach($files["image"] as $jsonimage )
								<div class="col-lg-2 text-center"><img src="{{ url(env("SMALL_IMAGE_PATH")."/".$jsonimage) }}" class="img-responsive" /><br>
								<a class="btn btn-danger" href="{{ url("deleteFile/post/".$item->id."?name=".$jsonimage."&filed_name=file") }}"><i class="fa fa-trash"></i></a></div>
							@endforeach
							</div>
							<div class="row text-center">
							@foreach($files["file"] as $jsonimage )
								<div class="col-lg-2 text-center"><a href="{{ url(env("UPLOAD_PATH")."/".$jsonimage) }}" ><i class="fa fa-file"></i></a>
								<a  href="{{ url("deleteFile/post/".$item->id."?name=".$jsonimage."&filed_name=file") }}"><i class="fa fa-trash"></i> {{ $jsonimage }} </a></div>
							@endforeach
					</div>
						@endif
					@endisset
						<input name="file[]"  type="file" multiple >
					</div>
		</div>
		<div class="form-group">
			<label for="home">{{ trans("post.home")}}</label>
				<input type="text" name="home" class="form-control" id="home" value="{{ isset($item->home) ? $item->home : old("home")  }}"  placeholder="{{ trans("post.home")}}">
		</div>
		<div class="form-group">
			<label for="des">{{ trans("post.des")}}</label>
				{!! extractFiled(isset($item) ? $item : null , "des" , isset($item->des) ? $item->des : old("des") , "textarea" , "post") !!}
		</div>


            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    {{ trans('home.save') }}  {{ trans('post.post') }}
                </button>
            </div>
        </form>
    @endcomponent
@endsection
