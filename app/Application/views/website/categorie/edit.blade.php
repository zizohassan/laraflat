@extends(layoutExtend('website'))

@section('title')
    {{ trans('categorie.categorie') }} {{  isset($item) ? trans('home.edit')  : trans('home.add')  }}
@endsection

@section('content')
    <div class="pull-{{ getDirection() }} col-lg-9">
        @include(layoutMessage('website'))
        <a href="{{ url('categorie') }}" class="btn btn-danger"><i
                    class="fa fa-arrow-left"></i> {{ trans('website.Back') }}  </a>
        <form action="{{ concatenateLangToUrl('categorie/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="title">{{ trans("categorie.title")}}</label>
                {!! extractFiled("title" , isset($item->title) ? $item->title : old("title") , "text" , "categorie") !!}
            </div>

            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default">
                    <i class="fa fa-save"></i>
                    {{ trans('website.Update') }}  {{ trans('website.categorie') }}
                </button>
            </div>
        </form>
    </div>
@endsection
