<h2>{{ ucfirst(trans('admin.Random'))}} {{ ucfirst('post') }}</h2>
<hr>
@php $sidebarPost = \App\Application\Model\Post::inRandomOrder()->limit(5)->get(); @endphp
		@if (count($sidebarPost) > 0)
			@foreach ($sidebarPost as $d)
				 <div>
					<h2 > {{ str_limit($d->title , 50) }}</h2 > 
					<p> {{ json_decode($d->t) ? str_limit(implode("," , json_decode($d->t)) , 300) : "" }}</p > 
					 <img src="{{ url(env("SMALL_IMAGE_PATH")."/".$d->image)}}"  width = "80" />
					 <p><a href="{{ url("post/".$d->id."/view") }}" ><i class="fa fa-eye" ></i ></a> <small ><i class="fa fa-calendar-o" ></i > {{ $d->created_at }}</small ></p > 
				<hr > 
				</div> 
			@endforeach
		@endif
			