@extends(layoutExtend())

@section('title')
    {{ trans('permission.permission') }}   {{ trans('curd.view') }}
@endsection

@section('content')
    @component(layoutForm(), ['title' => trans('permission.permission') , 'model' => 'permission' , 'action' => trans('curd.view') ])

    <table class="table table-bordered table-responsive table-striped">
        @php
        $fields = rename_keys(
        removeFromArray($data['fields'] , ['id' , 'created_at' , 'updated_at']) ,
            [
                trans('permission.name') ,
                trans('permission.slug') ,
                trans('permission.des') ,
                trans('permission.Controller Name') ,
                trans('permission.Function Name') ,
                trans('permission.Controller Type') ,
                trans('permission.Allow') ,
                trans('permission.NameSpace') ,
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
                    <td><img src="{{ url(env('UPLOAD_PATH').'/'.$item[$field]) }}"/></td>
                @else
                    <td>{!!  nl2br($item[$field])  !!}</td>
                @endif
            </tr>
        @endforeach
    </table>

    @include('admin.permission.buttons.delete' , ['id' => $item->id])
    @include('admin.permission.buttons.edit' , ['id' => $item->id])

    @endcomponent
@endsection
