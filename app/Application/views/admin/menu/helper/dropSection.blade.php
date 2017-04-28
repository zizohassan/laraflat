<div class="body">
    <div class="clearfix m-b-20">
        <div class="dd nestable-with-handle">
            <ol class="dd-list">
                @if($data['items'] != null)
                    @foreach($data['items'] as $key => $itemMenu)
                        @include('admin.menu.helper.li')
                    @endforeach
                @endif
            </ol>
        </div>
    </div>
</div>
