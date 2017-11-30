@extends(layoutExtend())

@section('title')
    {{ trans('user.user') }} {{ trans('curd.view') }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => trans('user.user') , 'model' => 'user' , 'action' => trans('curd.view')])

        <table class="table table-bordered table-responsive table-striped">
            @php
                $fields = rename_keys(
                removeFromArray($data['fields'] , ['id' , 'api_token', 'remember_token' , 'password' , 'updated_at']) ,
            [
                trans('user.name') ,
                trans('user.email'),
                trans('user.group'),
                trans('user.created_at'),
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
