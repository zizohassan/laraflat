@extends(layoutExtend())

@section('title')
    {{ adminTrans('contact' , 'contact') }} {{ adminTrans('home' , 'view') }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => adminTrans('contact' , 'contact') , 'model' => 'contact' , 'action' => adminTrans('home' , 'view')  , 'button' => false  ])
    @include('admin.contact.buttons.delete' , ['id' => $item->id])
    @include('admin.contact.buttons.edit' , ['id' => $item->id])
    <table class="table table-bordered  table-striped">
        @php
        $fields = rename_keys(
        removeFromArray($data['fields'] , ['id' , 'created_at' , 'updated_at']) ,
        [
        adminTrans('contact' , 'name'),
        adminTrans('contact' , 'email'),
        adminTrans('contact' , 'subject'),
        adminTrans('contact' , 'phone'),
        adminTrans('contact' , 'user_id'),
        adminTrans('contact' , 'message'),
        ]);
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
                    @if($field == 'user_id')
                        @if($item[$field] == 0)
                            <td> {{ trans('admin.Visitor') }}</td>
                        @else
                            @php $user = \App\Application\Model\User::find($item[$field]) @endphp
                            <td><a href="{{ url('admin/user/item/'.$user->id) }}">{{ $user->name }}</a></td>
                        @endif
                    @else
                        <td>{!!  nl2br($item[$field])  !!}</td>
                    @endif
                @endif
            </tr>
        @endforeach
    </table>
    @include('admin.contact.replay' , ['id' => $item->id])
    @endcomponent
@endsection
