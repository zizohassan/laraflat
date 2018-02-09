@extends(layoutExtend())

@section('title')
    {{ trans('post.post') }} {{ trans('home.view') }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => trans('post.post') , 'model' => 'post' , 'action' => trans('home.view')  ])
		 <table class="table table-bordered  table-striped" > 
				<tr>
				<th>{{ trans("post.title") }}</th>
					<td>{{ nl2br($item->title) }}</td>
				</tr>
				<tr>
				<th>{{ trans("post.t") }}</th>
					<td><span class="label label-default">{!! json_decode($item->t) ? implode("</span> <br> <span class='label label-default'>" , json_decode($item->t)) : "" !!}</span></td> 
								</tr>
				<tr>
				<th>{{ trans("post.image") }}</th>
					<td>
					<img src="{{ url(env("SMALL_IMAGE_PATH")."/".$item->image) }}" class="img-responsive" />
					</td>
				</tr>
				<tr>
				<th>{{ trans("post.photo") }}</th>
					<td>
					@isset($item)
						@if(json_decode($item->photo))
							<input type="hidden" name="oldFiles_photo" value="{{ $item->photo }}">
							@php $files = returnFilesImages($item , "photo"); @endphp
							<div class="row text-center">
							@foreach($files["image"] as $jsonimage )
								<div class="col-lg-2 text-center"><img src="{{ url(env("SMALL_IMAGE_PATH")."/".$jsonimage) }}" class="img-responsive" /><br>
								<span class="btn btn-danger" onclick="deleteThisItem(this)" data-link="{{ url("deleteFile/post/".$item->id."?name=".$jsonimage."&filed_name=photo") }}"><i class="fa fa-trash"></i></span></div>
							@endforeach
							</div>
							<div class="row text-center">
							@foreach($files["file"] as $jsonimage )
								<div class="col-lg-2 text-center"><a href="{{ url(env("UPLOAD_PATH")."/".$jsonimage) }}" ><i class="fa fa-file"></i></a>
								<span  onclick="deleteThisItem(this)" data-link="{{ url("deleteFile/post/".$item->id."?name=".$jsonimage."&filed_name=photo") }}"><i class="fa fa-trash"></i> {{ $jsonimage }} </span></div>
							@endforeach
					</div>
						@endif
					@endisset
					</td>
				</tr>
				<tr>
				<th>{{ trans("post.file") }}</th>
					<td>
					<a href="{{ url(env("UPLOAD_PATH")."/".$item->file) }}">{{ $item->file }}</a>
					</td>
				</tr>
				<tr>
				<th>{{ trans("post.files") }}</th>
					<td>
					@isset($item)
						@if(json_decode($item->files))
							<input type="hidden" name="oldFiles_files" value="{{ $item->files }}">
							@php $files = returnFilesImages($item , "files"); @endphp
							<div class="row text-center">
							@foreach($files["image"] as $jsonimage )
								<div class="col-lg-2 text-center"><img src="{{ url(env("SMALL_IMAGE_PATH")."/".$jsonimage) }}" class="img-responsive" /><br>
								<span class="btn btn-danger" onclick="deleteThisItem(this)" data-link="{{ url("deleteFile/post/".$item->id."?name=".$jsonimage."&filed_name=files") }}"><i class="fa fa-trash"></i></span></div>
							@endforeach
							</div>
							<div class="row text-center">
							@foreach($files["file"] as $jsonimage )
								<div class="col-lg-2 text-center"><a href="{{ url(env("UPLOAD_PATH")."/".$jsonimage) }}" ><i class="fa fa-file"></i></a>
								<span  onclick="deleteThisItem(this)" data-link="{{ url("deleteFile/post/".$item->id."?name=".$jsonimage."&filed_name=files") }}"><i class="fa fa-trash"></i> {{ $jsonimage }} </span></div>
							@endforeach
					</div>
						@endif
					@endisset
					</td>
				</tr>
				<tr>
				<th>{{ trans("post.date") }}</th>
					<td>{{ nl2br($item->date) }}</td>
				</tr>
				<tr>
				<th>{{ trans("post.icon") }}</th>
					<td>
				<i class="fa {{ $item->icon}}"></i>
					</td>
				</tr>
				<tr>
				<th>{{ trans("post.url") }}</th>
					<td>
				<a href="{{  $item->url }}"><i class="fa fa-link"></i></a>
					</td>
				</tr>
				<tr>
				<th>{{ trans("post.lng") }}</th>
					<td>{{ nl2br($item->lng) }}</td>
				</tr>
				<tr>
				<th>{{ trans("post.lat") }}</th>
					<td>
				{{nl2br($item->lat) }}
					</td></tr><tr><th>{{ trans("admin.location") }}</th>
					<td>
				<div id="showMap" style="width:100%;height: 500px;" data-lat="{{ $item->lat }}"  data-lng="{{ $item->lng }}"></div>
					</td>
				</tr>
				<tr>
				<th>{{ trans("post.youtube") }}</th>
				@if(isset($item) && $item->youtube != "")
					<td>
				<iframe width="420" height="315" src="https://www.youtube.com/embed/{{ isset($item->youtube) ? getYouTubeId($item->youtube) : old("youtube")  }}"></iframe>
					</td>
				@endif
				</tr>
				<tr>
				<th>{{ trans("post.active") }}</th>
					<td>
				{{ $item->active == 1 ? trans("post.Yes") : trans("post.No")  }}
					</td>
				</tr>
		</table>

        @include('admin.post.buttons.delete' , ['id' => $item->id])
        @include('admin.post.buttons.edit' , ['id' => $item->id])
    @endcomponent
@endsection
