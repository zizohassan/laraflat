<h2>{{ ucfirst(trans('admin.Random'))}} {{ ucfirst('categorie') }}</h2>
<hr>
@php $sidebarCategorie = \App\Application\Model\Categorie::inRandomOrder()->limit(5)->get(); @endphp
@if(count($sidebarCategorie) > 0)
    @foreach($sidebarCategorie as $d)
        <div>
            <h2>{{ str_limit(getDefaultValueKey($d->title) , 20) }}</h2>
            <p><a href="{{ url("categorie/".$d->id."/view") }}"><i class="fa fa-eye"></i></a>
                <small><i class="fa fa-calendar-o"></i> {{ $d->created_at }}</small>
            </p>
            <hr>
        </div>
    @endforeach
@endif
			