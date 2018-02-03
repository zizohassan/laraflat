<h2>{{ ucfirst(trans('admin.Random'))}} {{ ucfirst('post') }}</h2>
<hr>
@php $sidebarPost = \App\Application\Model\Post::inRandomOrder()->limit(5)->get(); @endphp
		@if (count($sidebarPost) > 0)
			@foreach ($sidebarPost as $d)
				 <div>
					<h2 > {{ str_limit($d->title_lang , 50) }}</h2 > 
					 <img src="{{ url(env("SMALL_IMAGE_PATH")."/".getImageFromJson($d ,"image"))}}"  width = "80" />
					 <a href="{{ url(env("UPLOAD_PATH")."/".getImageFromJson($d , "file"))}}"><i class="fa fa-file"></i></a>
					 <p><a href="{{ url("post/".$d->id."/view") }}" ><i class="fa fa-eye" ></i ></a> <small ><i class="fa fa-calendar-o" ></i > {{ $d->created_at }}</small ></p > 
				<hr > 
				</div> 
			@endforeach
		@endif
			