@extends(layoutExtend())

@section('title')
    {{ adminTrans('user' , 'user') }} {{ adminTrans('curd' , 'view') }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => adminTrans('user' , 'user') , 'model' => 'user' , 'action' => adminTrans('curd' , 'view')])

        <table class="table table-bordered table-responsive table-striped">
            @php
                $fields = rename_keys(
                removeFromArray($data['fields'] , ['id' , 'api_token', 'remember_token' , 'password' , 'updated_at']) ,
            [
                adminTrans('user' , 'name') ,
                adminTrans('user' , 'email'),
                adminTrans('user' , 'group'),
                adminTrans('user' , 'created_at'),

             ]
            );
            @endphp
            @foreach($fields as $key =>  $field)
                <tr>
                    <th>{{ $key }}</th>
                    <td> {{ $item[$field] }}</td>
                </tr>
            @endforeach
        </table>

        @include('admin.user.buttons.delete' , ['id' => $item->id])
        @include('admin.user.buttons.edit' , ['id' => $item->id])

    @endcomponent
@endsection
