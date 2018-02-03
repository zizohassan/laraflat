<h2>{{ ucfirst(trans('admin.Latest'))}} {{ ucfirst('post') }}</h2>
<hr>
@php $sidebarPost = \App\Application\Model\Post::orderBy("id", "DESC")->limit(5)->get(); @endphp
		@if (count($sidebarPost) > 0)
			@foreach ($sidebarPost as $d)
				 <div>
					<a href="{{ url("post/".$d->id."/view") }}" ><p>{{ str_limit($d->title_lang , 20) }}</a></p > 
					<p><a href="{{ url("post/".$d->id."/view") }}" ><i class="fa fa-eye" ></i ></a> <small ><i class="fa fa-calendar-o" ></i > {{ $d->created_at }}</small ></p > 
				<hr > 
				</div> 
			@endforeach
		@endif
			