@extends('admin.layout.app')

@section('title')
    setting View
@endsection

@section('content')
    @component('admin.layout.form' , ['title' => 'setting' , 'action' => 'View' ])

        <table class="table table-bordered table-responsive table-striped">
            @php
                $fields = rename_keys(
                     removeFromArray($data['fields'] , ['id']) ,
                     ['Setting Name' , 'Setting Type' , 'Setting Body']
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

        @include('admin.setting.buttons.delete' , ['id' => $item->id])
        @include('admin.setting.buttons.edit' , ['id' => $item->id])

    @endcomponent
@endsection
