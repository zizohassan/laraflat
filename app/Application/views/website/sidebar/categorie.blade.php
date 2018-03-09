<h2>{{ ucfirst(trans('admin.Latest'))}} {{ ucfirst('categorie') }}</h2>
<hr>
@php $sidebarCategorie = \App\Application\Model\Categorie::orderBy("id" , "DESC")->limit(5)->get(); @endphp
@if(count($sidebarCategorie) > 0)
    @foreach($sidebarCategorie as $d)
        <div>
            <p><a href="{{ url("categorie/".$d->id."/view") }}">{{ str_limit(getDefaultValueKey($d->title) , 20) }}</a></p>
            <p><a href="{{ url("categorie/".$d->id."/view") }}"><i class="fa fa-eye"></i></a>
                <small><i class="fa fa-calendar-o"></i> {{ $d->created_at }}</small>
            </p>
            <hr>
        </div>
    @endforeach
@endif
			