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
				<input type="text" name="title" class="form-control" id="title" value="{{ isset($item->title) ? $item->title : old("title")  }}"  placeholder="{{ trans("post.title")}}">
		</div>
		<div class="form-group">
			<label for="t">{{ trans("post.t")}}</label>
				<div id="laraflat-t">
					@if(isset($item) || old("t"))
						@if((isset($item->title) && json_decode($item->t) ) || old("t"))
						@php $items = isset($item->title) && json_decode($item->t) ? json_decode($item->t)  : old("t") @endphp
							@foreach($items as $jsont)
								<div class="title form-inline" style="margin-top:5px;margin-bottom:5px"><input class="form-control" name="t[]"  value="{{ $jsont}}" type="text" placeholder="{{ trans("post.t")}}" ><span class="btn btn-warning" onclick="removetitle(this)"> <i class="fa fa-minus"></i></span></div>
							@endforeach
						@endif
					@endif
				<span class="btn btn-success" onclick="AddNewt()"><i class="fa fa-plus"></i></span>
				<span class="btn btn-danger" onclick="clearAllt(this)"><i class="fa fa-minus"></i></span>
				@push("js")
                                        <script>
                                            function AddNewt() {
                                                $("#laraflat-t").append('<div class="t form-inline" style="margin-top:5px;margin-bottom:5px">'+'<input class="form-control" name="t[]"  type="text" placeholder="{{ trans("post.t")}}" >'+'<span class="btn btn-warning" onclick="removet(this)">'+' <i class="fa fa-minus"></i></span>'+'</div>');
                                            }
                                            function removet(e) {
                                                $(e).closest("div.t").remove();
                                            }
                                            function clearAllt(e) {
                                                $("#laraflat-t").html("");
                                            }
                                        </script>
            @endpush
					</div>
		</div>
		<div class="form-group">
			<label for="image">{{ trans("post.image")}}</label>
				@if(isset($item) && $item->image != "")
				<br>
				<img src="{{ url(env("SMALL_IMAGE_PATH")."/".$item->image) }}" class="thumbnail" alt="" width="200">
				<br>
				@endif
				<input type="file" name="image" >
		</div>
		<div class="form-group">
			<label for="photo">{{ trans("post.photo")}}</label>
				<div id="laraflat-photo">
					@isset($item)
						@if(json_decode($item->photo))
							<input type="hidden" name="oldFiles_photo" value="{{ $item->photo }}">
							@php $files = returnFilesImages($item , "photo"); @endphp
							<div class="row text-center">
							@foreach($files["image"] as $jsonimage )
								<div class="col-lg-2 text-center"><img src="{{ url(env("SMALL_IMAGE_PATH")."/".$jsonimage) }}" class="img-responsive" /><br>
								<a class="btn btn-danger" onclick="deleteThisItem(this)" data-link="{{ url("deleteFile/post/".$item->id."?name=".$jsonimage."&filed_name=photo") }}"><i class="fa fa-trash"></i></a></div>
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
						<input name="photo[]"  type="file" multiple >
					</div>
		</div>
		<div class="form-group">
			<label for="file">{{ trans("post.file")}}</label>
				@if(isset($item) && $item->file != "")
				<br>
				<img src="{{ url(env("SMALL_IMAGE_PATH")."/".$item->file) }}" class="thumbnail" alt="" width="200">
				<br>
				@endif
				<input type="file" name="file" >
		</div>
		<div class="form-group">
			<label for="files">{{ trans("post.files")}}</label>
				<div id="laraflat-files">
					@isset($item)
						@if(json_decode($item->files))
							<input type="hidden" name="oldFiles_files" value="{{ $item->files }}">
							@php $files = returnFilesImages($item , "files"); @endphp
							<div class="row text-center">
							@foreach($files["image"] as $jsonimage )
								<div class="col-lg-2 text-center"><img src="{{ url(env("SMALL_IMAGE_PATH")."/".$jsonimage) }}" class="img-responsive" /><br>
								<a class="btn btn-danger" onclick="deleteThisItem(this)" data-link="{{ url("deleteFile/post/".$item->id."?name=".$jsonimage."&filed_name=files") }}"><i class="fa fa-trash"></i></a></div>
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
						<input name="files[]"  type="file" multiple >
					</div>
		</div>
		<div class="form-group">
			<label for="date">{{ trans("post.date")}}</label>
				<input type="text" name="date" class="form-control datepicker" id="date" value="{{ isset($item->date) ? $item->date : old("date") }}"  placeholder="{{ trans("post.date")}}">
		</div>
		<div class="form-group">
			<label for="icon">{{ trans("post.icon")}}</label>
				<input type="text" name="icon" class="form-control icon-field" id="icon" value="{{ isset($item->icon) ? $item->icon : old("icon") }}"  placeholder="{{ trans("post.icon")}}">
		</div>
		<div class="form-group">
			<label for="url">{{ trans("post.url")}}</label>
				<input type="url" name="url" class="form-control" id="url" value="{{ isset($item->url) ? $item->url : old("url") }}"  placeholder="{{ trans("post.url")}}">
		</div>
		<div class="form-group">
			<label for="lng">{{ trans("post.lng")}}</label>
				 <input type="text" name="lng" class="form-control lng" style="display:none" id="lng" value="{{ isset($item->lng) ? $item->lng : old("lng") }}"  placeholder="{{ trans("post.lng")}}" > 
		</div>
		<div class="form-group">
			<label for="lat">{{ trans("post.lat")}}</label>
				 <input type="text" name="lat" class="form-control lat" style="display:none" id="lat" value="{{ isset($item->lat) ? $item->lat : old("lat") }}"  placeholder="{{ trans("post.lat")}}" > 
				<div class="pac-card" id="pac-card">
					<div>
						<div id="title">
							{{ trans("admin.Autocomplete search") }}
						</div>
						<div id="type-selector" class="pac-controls">
							<input type="radio" name="type" id="changetype-all" checked="checked">
							<label for="changetype-all">{{ trans("admin.All") }}</label>
							<input type="radio" name="type" id="changetype-establishment">
							<label for="changetype-establishment">{{ trans("admin.Establishments") }}</label>
							<input type="radio" name="type" id="changetype-address">
							<label for="changetype-address">{{ trans("admin.Addresses") }}</label>
							<input type="radio" name="type" id="changetype-geocode">
							<label for="changetype-geocode">{{ trans("admin.Geocodes") }}</label>
						</div>
						 <div id="strict-bounds-selector" class="pac-controls" > 
							<input type="checkbox" id="use-strict-bounds" value ="" > 
							<label for="use-strict-bounds" > {{ trans("admin.Strict Bounds") }} </label > 
						</div>
						</div>
						<div id="pac-container">
							<input id="pac-input" type="text" placeholder="{{ trans("admin.Enter a location") }}">
						</div> 
						</div> 
						<div id="map" style="width: 100%;height: 500px;"></div>
						<div id="infowindow-content">
						 <img src="" width ="16" height ="16" id="place-icon">
						<span id="place-name"  class="title"></span><br> 
						<span id="place-address"></span> 
				</div>		</div>
		<div class="form-group">
			<label for="youtube">{{ trans("post.youtube")}}</label>
				@if(isset($item) && $item->youtube != "")
				<br>
				<iframe width="420" height="315" src="https://www.youtube.com/embed/{{ isset($item->youtube) ? getYouTubeId($item->youtube) : old("youtube")  }}"></iframe>
				<br>
				@endif
				<input type="url" name="youtube" class="form-control" id="youtube" value="{{ isset($item->youtube) ? $item->youtube : old("youtube")  }}"  placeholder="{{ trans("post.youtube")}}">
		</div>
		<div class="form-group">
			<label for="active">{{ trans("post.active")}}</label>
				<div class="form-check">
					<label class="form-check-label">
					<input class="form-check-input" name="active" {{ isset($item->active) && $item->active  == 0 ? "checked" : "" }} type="radio" value="0">
					{{ trans("post.No")}}
				</label>
				<label class="form-check-label">
				<input class="form-check-input" name="active" {{ isset($item->active) && $item->active  == 1 ? "checked" : "" }} type="radio" value="1" >
									{{ trans("post.Yes")}}
				</label>
				</div>		</div>


            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    {{ trans('home.save') }}  {{ trans('post.post') }}
                </button>
            </div>
        </form>
    @endcomponent
@endsection
