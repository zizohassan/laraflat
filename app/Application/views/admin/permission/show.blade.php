@extends('admin.layout.app')

@section('title')
    permission View
@endsection

@section('content')
    @component('admin.layout.form' , ['title' => 'permission' , 'action' => 'View' ])

        <table class="table table-bordered table-responsive table-striped">
            @php
                $fields = rename_keys(
                     removeFromArray($data['fields'] , ['id']) ,
                     ['Permission Name','Permission Slug','Permission Description' , 'Permission Model' , 'Permission Add' , 'Permission edit' , 'Permission view' , 'Permission Delete']
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
