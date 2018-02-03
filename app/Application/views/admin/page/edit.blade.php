@extends(layoutExtend())
 @section('title')
    {{ trans('page.page') }} {{  isset($item) ? trans('home.edit')  : trans('home.add')  }}
@endsection
@section('style')
    {{ Html::style('/admin/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}
@endsection
 @section('content')
    @component(layoutForm() , ['title' => trans('page.page') , 'model' => 'page' , 'action' => isset($item) ? trans('home.edit')  : trans('home.add')  ])
        @include(layoutMessage())
        <form action="{{ concatenateLangToUrl('admin/page/item') }}{{ isset($item) ? '/'.$item->id : '' }}"
              method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
             <div class="form-group">
                <label for="title">{{ trans("page.title")}}</label>
                {!! extractFiled(isset($item) ? $item : null,  "title" , isset($item->title) ? $item->title : old("title") , "text" , "page") !!}
            </div>
            <div class="form-group">
                <label for="body">{{ trans("page.body")}}</label>
                {!! extractFiled(isset($item) ? $item : null , "body" , isset($item->body) ? $item->body : old("body") , "textarea" , "page" , 'tinymce' ) !!}
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
                               {{ isset($item->active) && $item->active  == 1 ? "checked" : "" }} type="radio"
                               value="1">
                        {{ trans("page.Yes")}}
                    </label>
                </div>
                </label>
            </div>
              <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default">
                    <i class="material-icons">check_circle</i>
                    {{ trans('home.save') }}  {{ trans('page.page') }}
                </button>
            </div>
        </form>
        @include("admin.page.comment.edit")
    @endcomponent
@endsection
 @section('script')
    @include(layoutPath('layout.helpers.tynic'))
@endsection
 