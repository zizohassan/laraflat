@extends(layoutExtend())
@section('title')
    {{ trans('page.page') }} {{ trans('home.view') }}
@endsection
@section('content')
    @component(layoutForm() , ['title' => trans('page.page') , 'model' => 'page' , 'action' => trans('home.view')  ])
        <table class="table table-bordered  table-striped">
            <tr>
                <th>{{ trans("page.title") }}</th>
                <td>{{ getDefaultValueKey(nl2br($item->title)) }}</td>
            </tr>
            <tr>
                <th>{{ trans("page.body") }}</th>
                <td>{!! getDefaultValueKey(nl2br($item->body))  !!} </td>
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
