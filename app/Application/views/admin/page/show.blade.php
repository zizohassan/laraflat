@extends(layoutExtend())

@section('title')
    {{ trans('page.page') }}  {{ trans('curd.view') }}
@endsection

@section('content')
    @component(layoutForm()  , ['title' => trans('page.page') , 'model' => 'page' , 'action' => 'View' ])

    <table class="table table-bordered table-responsive table-striped">
        @php
        $fields = rename_keys(
        removeFromArray($data['fields'] , ['id' , 'created_at' , 'updated_at']) ,
        [
            trans('page.title') ,
            trans('page.slug') ,
            trans('page.body') ,
            trans('page.status'),
            trans('page.date') ,
            trans('page.image')
        ]
        );
        @endphp
        @foreach($fields as $key =>  $field)
            <tr>
                <th>{{ $key }}</th>
                @php $type = getFileType($field , $item[$field]) @endphp
                @if($type == 'File')
                    <td><a href="{{ url(env('UPLOAD_PATH').'/'.$item[$field]) }}">{{ $item[$field] }}</a></td>
                @elseif($type == 'Image')
                    <td><img src="{{ url(env('SMALL_IMAGE_PATH').'/'.$item[$field]) }}" class=" thumbnail"
                             width="200"/></td>
                @else
                    @if($field == 'title' || $field == 'body')
                        <td>{!!  getDefaultValueKey(nl2br($item[$field]))  !!}</td>
                    @else
                        <td>{!!  nl2br($item[$field])  !!}</td>
                    @endif

                @endif
            </tr>
        @endforeach
    </table>

    @include('admin.page.buttons.delete' , ['id' => $item->id])
    @include('admin.page.buttons.edit' , ['id' => $item->id])

    @endcomponent
@endsection
