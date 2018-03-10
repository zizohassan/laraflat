@extends(layoutExtend())

@section('title')
    {{ trans('user.user') }} {{ trans('curd.view') }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => trans('user.user') , 'model' => 'user' , 'action' => trans('curd.view')])

        <table class="table table-bordered  table-striped">
            @php $item = $data['fields'] @endphp
            <tr>
                <th width="200">{{ trans('user.group')  }}</th>
                <td>{{ $item->group->name }}</td>
            </tr>
            <tr>
                <th>{{ trans('user.name')  }}</th>
                <td>{{ $item->name }}</td>
            </tr>
            <tr>
                <th>{{  trans('user.created_at')  }}</th>
                <td>{{ $item->created_at }}</td>
            </tr>
        </table>

        @include('admin.user.buttons.delete' , ['id' => $item->id])
        @include('admin.user.buttons.edit' , ['id' => $item->id])

    @endcomponent
@endsection
