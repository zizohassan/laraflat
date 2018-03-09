@extends(layoutExtend())
@section('title')
    {{ trans('page.page') }} {{ trans('home.view') }}
@endsection
@section('content')
    @component(layoutForm() , ['title' => trans('page.page') , 'model' => 'page' , 'action' => trans('home.view')  ])
        <table class="table table-bordered  table-striped">
            <tr>
                <th width="150">{{ trans("page.title") }}</th>
                <td>{{ nl2br($item->title_lang) }}</td>
            </tr>
            <tr>
                <th>{{ trans("page.body") }}</th>
                <td>{!! nl2br($item->body_lang)  !!} </td>
            </tr>
            <tr>
                <th>{{ trans("page.active") }}</th>
                <td>
                    {{ $item->active == 1 ? trans("page.Yes") : trans("page.No")  }}
                </td>
            </tr>
        </table>
        @include("admin.page.comment.show")
        @include("admin.page.comment.edit")
        @include('admin.page.buttons.delete' , ['id' => $item->id])
        @include('admin.page.buttons.edit' , ['id' => $item->id])
    @endcomponent
@endsection
