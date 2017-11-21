@extends(layoutExtend())

@section('title')
    {{ trans('setting.setting') }}    {{ trans('curd.view') }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => trans('setting.setting')  , 'model' => 'setting' , 'action' => trans('curd.view') ])

        <table class="table table-bordered table-responsive table-striped">
            @php
                $fields = rename_keys(
                     removeFromArray($data['fields'] , ['id' , 'created_at' , 'updated_at']) ,
                     [
            trans('setting.name'),
            trans('setting.type'),
            trans('setting.body'),
                     ]);
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

        @include('admin.setting.buttons.delete' , ['id' => $item->id])
        @include('admin.setting.buttons.edit' , ['id' => $item->id])

    @endcomponent
@endsection
