@extends(layoutExtend())

@section('title')
    {{  adminTrans('role' , 'role') }}     {{  adminTrans('curd' , 'view') }}

@endsection

@section('content')
    @component(layoutForm() , ['title' => adminTrans('role' , 'role') , 'model' => 'role' , 'action' => adminTrans('curd' , 'view') ])

        <table class="table table-bordered table-responsive table-striped">
            @php
                $fields = rename_keys(
                     removeFromArray($data['fields'] , ['id' , 'created_at' , 'updated_at']) ,
                     [
                            adminTrans('role' , 'name'),
                            adminTrans('role' , 'slug'),
                            adminTrans('role' , 'des')
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

        @include('admin.role.buttons.delete' , ['id' => $item->id])
        @include('admin.role.buttons.edit' , ['id' => $item->id])

    @endcomponent
@endsection
