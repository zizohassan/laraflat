<h2>{{ ucfirst(trans('admin.Random'))}} {{ ucfirst('post') }}</h2>
<hr>
@php $sidebarPost = \App\Application\Model\Post::inRandomOrder()->limit(5)->get(); @endphp
		@if (count($sidebarPost) > 0)
			@foreach ($sidebarPost as $d)
				 <div>
					<h2 > {{ str_limit($d->title_lang , 50) }}</h2 > 
					<p> {{ str_limit($d->body_lang , 300) }}</p > 
					{{ $d->active == 1 ? trans("post.Yes") : trans("post.No")  }}
					 <p><a href="{{ url("post/".$d->id."/view") }}" ><i class="fa fa-eye" ></i ></a> <small ><i class="fa fa-calendar-o" ></i > {{ $d->created_at }}</small ></p > 
				<hr > 
				</div> 
			@endforeach
		@endif
			