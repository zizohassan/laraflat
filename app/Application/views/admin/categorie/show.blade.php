@extends(layoutExtend())

@section('title')
    {{ adminTrans('categorie' , 'Category') }} {{ adminTrans('home' , 'view')  }}
@endsection

@section('content')
    @component(layoutForm()  , ['title' => adminTrans('categorie' , 'Category'), 'model' => 'categorie' ,  'action' => adminTrans('home' , 'view') ])

        <table class="table table-bordered table-responsive table-striped">
            @php
                $fields = rename_keys(
                     removeFromArray($data['fields'] , ['id' , 'created_at' , 'updated_at']) ,
                     [adminTrans('categorie' , 'name')]
                );
            @endphp
                 @foreach($fields as $key =>  $field)
                        <tr>
                            <th>{{ $key }}</th>
                            <td>{{ getDefaultValueKey($item[$field]) }}</td>
                        </tr>
                    @endforeach
        </table>

        @include('admin.categorie.buttons.delete' , ['id' => $item->id])
        @include('admin.categorie.buttons.edit' , ['id' => $item->id])

    @endcomponent
@endsection
