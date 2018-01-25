@extends(layoutExtend())

@section('title')
    {{ trans('categorie.categorie') }} {{  isset($item) ? trans('home.edit')  : trans('home.add')  }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => trans('categorie.categorie') , 'model' => 'categorie' , 'action' => isset($item) ? trans('home.edit')  : trans('home.add')  ])
         @include(layoutMessage())
        <form action="{{ concatenateLangToUrl('admin/categorie/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="title">{{ trans("categorie.title")}}</label>
                {!! extractFiled("title" , isset($item->title) ? $item->title : old("title") , "text" , "categorie") !!}
            </div>


            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    {{ trans('home.save') }}  {{ trans('categorie.categorie') }}
                </button>
            </div>
        </form>
    @endcomponent
@endsection
