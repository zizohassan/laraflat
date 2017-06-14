@extends(layoutExtend())

@section('title')
    {{ adminTrans('permission' , 'permission') }}   {{ adminTrans('curd' , 'view') }}
@endsection

@section('content')
    @component(layoutForm(), ['title' => adminTrans('permission' , 'permission') , 'model' => 'permission' , 'action' => adminTrans('curd' , 'view') ])

        <table class="table table-bordered table-responsive table-striped">
            @php
                $fields = rename_keys(
                     removeFromArray($data['fields'] , ['id' , 'created_at' , 'updated_at']) ,
                     [
                           adminTrans('permission' , 'name') ,
                            adminTrans('permission' , 'slug') ,
                            adminTrans('permission' , 'des') ,
                            adminTrans('permission' , 'model') ,
                            adminTrans('permission' , 'action_add') ,
                            adminTrans('permission' , 'action_edit') ,
                            adminTrans('permission' , 'action_view') ,
                            adminTrans('permission' , 'action_delete') ,
                    ]
                );
            @endphp
                 @foreach($fields as $key =>  $field)
                        <tr>
                            <th>{{ $key }}</th>
                            @php $type =  getFileType($field , $item[$field]) @endphp
                            @if($type == 'File')
                                <td> <a href="{{ url(env('UPLOAD_PATH').'/'.$item[$field]) }}">{{ $item[$field] }}</a></td>
                            @elseif($type == 'Image')
                                <td> <img src="{{ url(env('UPLOAD_PATH').'/'.$item[$field]) }}" /></td>
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
