@extends(layoutExtend())

@section('title')
    {{ adminTrans('log' , 'log') }}
    {{  isset($item) ? adminTrans('curd' , 'edit')  : adminTrans('curd' , 'add')  }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => adminTrans('log' , 'log') , 'action' => isset($item) ? adminTrans('curd' , 'edit')  : adminTrans('curd' , 'add')  ])
    @include(layoutMessage())
        <form action="{{ concatenateLangToUrl('admin/log/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="form-line">
                    <input type="text" name="name" id="name" class="form-control" value="{{ isset($item) ? $item->name : '' }}"/>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    {{ adminTrans('home' , 'save') }} {{ adminTrans('log' , 'log') }}
                </button>
            </div>
        </form>
    @endcomponent
@endsection
