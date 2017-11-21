@extends(layoutExtend())

@section('title')
     {{ trans('categorie.Category') }} {{  isset($item) ? trans('home.edit') : trans('home.add') }}
@endsection

@section('content')
    @component(layoutForm() , ['title' =>  trans('categorie.Category') , 'model' => 'categorie' , 'action' => isset($item) ? trans('home.dit') : trans('home.add') ])
        @include(layoutMessage())
        <form action="{{ concatenateLangToUrl('admin/categorie/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            {!! extractFiled('name' , isset($item->name) ? $item->name : null , 'text' , 'categorie') !!}

            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    {{ trans('home.save') }} {{ trans('categorie.Category') }}
                </button>
            </div>
        </form>
    @endcomponent
@endsection
