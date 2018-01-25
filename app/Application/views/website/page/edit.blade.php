@extends(layoutExtend('website'))
@section('title')
    {{ trans('page.page') }} {{  isset($item) ? trans('home.edit')  : trans('home.add')  }}
@endsection
@section('content')
    <div class="pull-{{ getDirection() }} col-lg-9">
        @include(layoutMessage('website'))
        <a href="{{ url('page') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> {{ trans('website.Back') }}
        </a>
        <form action="{{ concatenateLangToUrl('page/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="title">{{ trans("page.title")}}</label>
                {!! extractFiled("title" , isset($item->title) ? $item->title : old("title") , "text" , "page") !!}
            </div>
            <div class="form-group">
                <label for="body">{{ trans("page.body")}}</label>
                {!! extractFiled("body" , isset($item->body) ? $item->body : old("body") , "textarea" , "page") !!}
            </div>
            <div class="form-group">
                <label for="active">{{ trans("page.active")}}</label>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" name="active"
                               {{ isset($item->active) && $item->active  == 0 ? "checked" : "" }} type="radio"
                               value="0">
                        {{ trans("page.No")}}
                    </label>
                    <label class="form-check-label">
                        <input class="form-check-input" name="active"
                               {{ isset($item->active) && $item->active == 1 ? "checked" : "" }} type="radio" value="1">
                        {{ trans("page.Yes")}}
                    </label>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default">
                    <i class="fa fa-save"></i>
                    {{ trans('website.Update') }}  {{ trans('website.page') }}
                </button>
            </div>
        </form>
        @include("website.page.comment.edit")
    </div>
@endsection
