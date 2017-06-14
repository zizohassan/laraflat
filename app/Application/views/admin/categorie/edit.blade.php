@extends(layoutExtend())

@section('title')
     {{ adminTrans('categorie' , 'Category') }} {{  isset($item) ? adminTrans('home' , 'edit') : adminTrans('home','add') }}
@endsection

@section('content')
    @component(layoutForm() , ['title' =>  adminTrans('categorie' , 'Category') , 'model' => 'categorie' , 'action' => isset($item) ? adminTrans('home' , 'edit') : adminTrans('home','add') ])
        @include(layoutMessage())
        <form action="{{ concatenateLangToUrl('admin/categorie/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            {!! extractFiled('name' , isset($item->name) ? $item->name : null , 'text' , 'categorie') !!}

            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    {{ adminTrans('home' , 'save') }} {{ adminTrans('categorie' , 'Category') }}
                </button>
            </div>
        </form>
    @endcomponent
@endsection
