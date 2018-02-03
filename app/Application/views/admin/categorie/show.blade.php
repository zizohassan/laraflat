@extends(layoutExtend())

@section('title')
    {{ trans('categorie.categorie') }} {{ trans('home.view') }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => trans('categorie.categorie') , 'model' => 'categorie' , 'action' => trans('home.view')  ])
        <table class="table table-bordered table-striped">
            <tr>
                <th width="150">{{ trans("categorie.title") }}</th>
                <td>{{ nl2br($item->title_lang) }}</td>
            </tr>
        </table>

        @include('admin.categorie.buttons.delete' , ['id' => $item->id])
        @include('admin.categorie.buttons.edit' , ['id' => $item->id])
    @endcomponent
@endsection
