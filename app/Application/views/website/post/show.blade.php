@extends(layoutExtend('website'))

@section('title')
    {{ trans('post.post') }} {{ trans('home.view') }}
@endsection

@section('content')
<div class="pull-{{ getDirection() }} col-lg-9">
        <a href="{{ url('post') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> {{ trans('website.Back') }}  </a>
		 <table class="table table-bordered  table-striped" > 
				 <tr>
				 <th>{{ trans("post.title") }}</th> 
				@php $type = getFileType("title", $item->title) @endphp
				@if ($type == "File") 
					 <td> <a href="{{ url(env("UPLOAD_PATH")."/".$item->title) }}" >{{ $item->title }}</a></td> 
				@elseif($type == "Image")
					 <td> <img src="{{ url(env("SMALL_IMAGE_PATH")."/".$item->title) }}" /></td> 
				@else
					<td>{{ nl2br($item->title_lang) }}</td> 
				@endif</tr> 
				 <tr>
				 <th>{{ trans("post.image") }}</th> 
				@php $type = getFileType("image", $item->image) @endphp
				@if ($type == "File") 
					 <td> <a href="{{ url(env("UPLOAD_PATH")."/".$item->image) }}" >{{ $item->image }}</a></td> 
				@elseif($type == "Image")
					 <td> <img src="{{ url(env("SMALL_IMAGE_PATH")."/".$item->image) }}" /></td> 
				@else
					<td>
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
					</td>
				@endif</tr> 
				 <tr>
				 <th>{{ trans("post.file") }}</th> 
				@php $type = getFileType("file", $item->file) @endphp
				@if ($type == "File") 
					 <td> <a href="{{ url(env("UPLOAD_PATH")."/".$item->file) }}" >{{ $item->file }}</a></td> 
				@elseif($type == "Image")
					 <td> <img src="{{ url(env("SMALL_IMAGE_PATH")."/".$item->file) }}" /></td> 
				@else
					<td>
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
					</td>
				@endif</tr> 
				 <tr>
				 <th>{{ trans("post.home") }}</th> 
				@php $type = getFileType("home", $item->home) @endphp
				@if ($type == "File") 
					 <td> <a href="{{ url(env("UPLOAD_PATH")."/".$item->home) }}" >{{ $item->home }}</a></td> 
				@elseif($type == "Image")
					 <td> <img src="{{ url(env("SMALL_IMAGE_PATH")."/".$item->home) }}" /></td> 
				@else
					<td>{{nl2br($item->home) }}</td> 
				@endif</tr> 
				 <tr>
				 <th>{{ trans("post.des") }}</th> 
				@php $type = getFileType("des", $item->des) @endphp
				@if ($type == "File") 
					 <td> <a href="{{ url(env("UPLOAD_PATH")."/".$item->des) }}" >{{ $item->des }}</a></td> 
				@elseif($type == "Image")
					 <td> <img src="{{ url(env("SMALL_IMAGE_PATH")."/".$item->des) }}" /></td> 
				@else
					<td>{{ nl2br($item->des_lang) }}</td> 
				@endif</tr> 
		</table > 

        @include('website.post.buttons.delete' , ['id' => $item->id])
        @include('website.post.buttons.edit' , ['id' => $item->id])
</div>
@endsection
