<h2>{{ ucfirst(trans('admin.Random'))}} {{ ucfirst('page') }}</h2>
<hr>
@php $sidebarPage = \App\Application\Model\Page::inRandomOrder()->limit(5)->get(); @endphp
@if(count($sidebarPage) > 0)
    @foreach($sidebarPage as $d)
        <div>
            <h2>{{ str_limit(getDefaultValueKey($d->title) , 50) }}</h2>
            <p>{!! str_limit(getDefaultValueKey($d->body) , 300) !!}</p>
            {{ $d->active == 1 ? trans("page.Yes") : trans("page.No")  }}
            <p><a href="{{ url("page/".$d->id."/view") }}"><i class="fa fa-eye"></i></a>
                <small><i class="fa fa-calendar-o"></i> {{ $d->created_at }}</small>
            </p>
            <hr>
        </div>
    @endforeach
@endif
			