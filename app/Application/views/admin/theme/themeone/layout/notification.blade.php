@foreach($note as $not)
    <li class="row">
        <div class="col-lg-12">
            <div class="menu-info">
                <h4>{!!   $not->data['link']  !!}</h4>
                <p>
                    <i class="material-icons">access_time</i> {{ $not->data['date']['date'] }}
                </p>
            </div>
        </div>
    </li>
{{ $not->markAsRead() }}
@endforeach

