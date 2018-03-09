@extends(layoutExtend())

@section('title')
    {{ trans('categorie.categorie') }} {{  isset($item) ? trans('home.edit')  : trans('home.add')  }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => trans('categorie.categorie') , 'model' => 'categorie' , 'action' => isset($item) ? trans('home.edit')  : trans('home.add')  ])
         @include(layoutMessage())
        <form action="{{ concatenateLangToUrl('admin/categorie/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group {{  $errors->has("title.en")  &&  $errors->has("title.ar")  ? "has-error" : "" }}">
                <label for="title">{{ trans("categorie.title")}}</label>
                {!! extractFiled(isset($item) ? $item : null ,"title" , isset($item->title) ? $item->title : old("title") , "text" , "categorie") !!}
            </div>

            @if ($errors->has("title.en"))
                <div class="alert alert-danger">
                            <span class='help-block'>
                                <strong>{{ $errors->first("title.en") }}</strong>
                             </span>
                </div>
            @endif
            @if ($errors->has("title.ar"))
                <div class="alert alert-danger">
                            <span class='help-block'>
                                <strong>{{ $errors->first("title.ar") }}</strong>
                            </span>
                </div>
            @endif


            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    {{ trans('home.save') }}  {{ trans('categorie.categorie') }}
                </button>
            </div>
        </form>
    @endcomponent
@endsection
