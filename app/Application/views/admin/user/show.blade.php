@extends('admin.layout.app')

@section('title')
    User View
@endsection

@section('content')
    @component('admin.layout.form' , ['title' => 'user' , 'action' => 'View' ])

        <table class="table table-bordered table-responsive table-striped">
            @php
                $fields = rename_keys(
                                        removeFromArray($data['fields'] , ['id' , 'remember_token' , 'password' , 'updated_at']) ,
                                        ['UserName' , 'Email Adress' , 'Join At' , 'Permission Group']
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
