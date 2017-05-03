@extends('admin.layout.app')

@section('title')
    log View
@endsection

@section('content')
    @component('admin.layout.form' , ['title' => 'log' , 'action' => 'View' , 'button' => false ])
        <table class="table table-bordered table-responsive table-striped">
            @php
                $fields = rename_keys(
                     removeFromArray($data['fields'] , ['id']) ,
                     ['Log Action' , 'Log Table' , 'Log Status' , 'Error Messages' , 'User ID' ,  'Created At' , 'Last Update']
                );
            @endphp
                 @foreach($fields as $key =>  $field)
                        <tr>
                            <th>{{ $key }}</th>

                            @php $json = json_decode($item[$field]) @endphp
                            @if($field == 'messages' &&  $json != '')

                                <td>
                                    <ol>
                                        @foreach($json as $fKey => $f)
                                            <li>
                                                <b>
                                                    {{ $fKey }}
                                                </b>
                                                :
                                                @foreach($f as $m)
                                                    {{ $m }}<br>
                                                @endforeach
                                            </li>
                                        @endforeach
                                    </ol>
                                </td>
                            @elseif($field == 'user_id')
                                <td> {{ \App\Application\Model\User::find($item[$field])->name }} </td>
                            @else
                                 <td>{!!  nl2br($item[$field])  !!}</td>
                            @endif
                        </tr>
                    @endforeach
        </table>
        @include('admin.log.buttons.delete' , ['id' => $item->id])
    @endcomponent
@endsection
