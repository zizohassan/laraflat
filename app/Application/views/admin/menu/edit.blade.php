@extends(layoutExtend())

@section('title')
    {{ trans('menu.menu') }} {{  isset($item) ? trans('curd.edit'):  trans('curd.add') }}
@endsection

@section('style')
    {{ Html::style('admin/plugins/nestable/jquery-nestable.css') }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => trans('menu.menu') , 'model' => 'menu' , 'action' => isset($item) ? trans('curd.edit'): trans('curd.add') ])
    @include(layoutMessage())
        <form action="{{ concatenateLangToUrl('admin/menu/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="form-line">
                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ trans('menu.name') }}" value="{{ isset($item) ? $item->name : old('name') }}"/>
                </div>
            </div>
            @if(isset($item))
                @include('admin.menu.helper.dropSection')
            @endif
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    {{ trans('home.save') }} {{ trans('menu.menu') }}
                </button>
                @if(isset($item))
                    <span class="btn btn-info waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal" >
                        <i class="material-icons">playlist_add</i>
                        {{ trans('menu.add_new_item') }}
                    </span>
                @endif
            </div>
        </form>
    @if(isset($item))
        @include('admin.menu.helper.model')
    @endif
    @endcomponent
@endsection
@section('script')
    @if(isset($item))
       @include('admin.menu.helper.scripts')
    @endif
@endsection
