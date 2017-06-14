@extends(layoutExtend())

@section('title')
    {{ adminTrans('page' , 'page') }}  {{ adminTrans('curd' , 'view') }}
@endsection

@section('content')
    @component(layoutForm()  , ['title' => adminTrans('page' , 'page') , 'model' => 'page' , 'action' => 'View' ])

        <table class="table table-bordered table-responsive table-striped">
            @php
                $fields = rename_keys(
                     removeFromArray($data['fields'] , ['id'   , 'created_at' , 'updated_at']) ,
                [
                    adminTrans('page' , 'title') ,
                    adminTrans('page' , 'slug') ,
                    adminTrans('page' , 'body') ,
                    adminTrans('page' , 'status'),
                    adminTrans('page' , 'date') ,
                    adminTrans('page' , 'image')
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
                                <td> <img src="{{ url(env('UPLOAD_PATH').'/'.$item[$field]) }}" class="img-responsive thumbnail"  width="200"/></td>
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
