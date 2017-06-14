@include(layoutBreadcrumb())
        <div class="card">
            <div class="card-block">
                @php $button = isset($button) ? $button : true @endphp
                @include(layoutHeader() , ['button' => $button])
                <div class="body">
                    {!! $table !!}
                </div>
            </div>
        </div>
