@extends(layoutExtend())

@section('title')
    {{ adminTrans('log' , 'log') }} {{ adminTrans('curd' , 'view') }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => adminTrans('log' , 'log') , 'model' => 'log' , 'action' => adminTrans('curd' , 'view') , 'button' => false ])
        <table class="table table-bordered table-responsive table-striped">
            @php
                $fields = rename_keys(
                     removeFromArray($data['fields'] , ['id']) ,
                     [ adminTrans('log' , 'action') ,  adminTrans('log' , 'model') ,  adminTrans('log' , 'status') , adminTrans('log' , 'message') , adminTrans('log' , 'user_id')  ,   adminTrans('log' , 'created_at') , adminTrans('log' , 'last_update') ]
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
