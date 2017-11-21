@extends(layoutExtend())

@section('title')
    {{ trans('log.log') }} {{ trans('curd.view') }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => trans('log.log') , 'model' => 'log' , 'action' => trans('curd.view') , 'button' => false ])
    <table class="table table-bordered table-responsive table-striped">
        @php
        $fields = rename_keys(
        removeFromArray($data['fields'] , ['id']) ,
        [
            trans('log.action') ,
            trans('log.model') ,
            trans('log.status') ,
            trans('log.message') ,
            trans('log.user_id') ,
            trans('log.created_at') ,
            trans('log.last_update')
        ]
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
