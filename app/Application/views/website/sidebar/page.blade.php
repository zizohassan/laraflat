<h2>{{ ucfirst(trans('admin.Latest'))}} {{ ucfirst('page') }}</h2>
<hr>
@php $sidebarPage = \App\Application\Model\Page::orderBy("id" , "DESC")->limit(5)->get(); @endphp
		@if(count($sidebarPage) > 0)
			@foreach($sidebarPage as $d)
				<div>
					<a href="{{ url("page/".$d->id."/view") }}" ><p>{{ str_limit(getDefaultValueKey($d->title) , 20) }}</a></p>
					<p><a href="{{ url("page/".$d->id."/view") }}" ><i class="fa fa-eye"></i></a> <small><i class="fa fa-calendar-o"></i> {{ $d->created_at }}</small></p>
				<hr>
				</div>
			@endforeach
		@endif
			