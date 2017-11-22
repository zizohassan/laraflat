@extends(layoutExtend())

@section('title')
    {{ trans('permission.permission') }} {{  isset($item) ? trans('home.edit') : trans('home.add') }}
@endsection

@section('content')
    @component( layoutForm() , ['title' => trans('permission.permission') , 'model' => 'permission' , 'action' => isset($item) ? trans('home.edit') : trans('home.add') ])
    @include(layoutMessage())
    <form action="{{ concatenateLangToUrl('admin/permission/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="form-line">
                <input type="text" name="name" id="name" placeholder="{{ trans('permission.name') }}" class="form-control" value="{{ isset($item) ? $item->name : old('name') }}"/>
            </div>
        </div>

        <div class="form-group">
            <div class="form-line">
                <input type="text" name="slug" id="name" class="form-control" placeholder="{{ trans('permission.slug') }}" value="{{ isset($item) ? $item->slug : old('slug')  }}"/>
            </div>
        </div>


        <div class="form-group">
            <div class="form-line">
                <textarea  name="description" id="description"  placeholder="{{ trans('permission.des') }}" class="form-control">{{ isset($item) ? $item->description : old('description') }}</textarea>
            </div>
        </div>


        <div class="form-group">
            <div class="form-line">
                @php $type = isset($item) ? $item->controller_type : null @endphp
                {!! Form::select('controller_type'  , $data['controller_type'] , $type , ['class' => 'form-control' , 'id' => 'type' , 'required']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="form-line">
                @php $controller_name = isset($item) ? $item->controller_name : null @endphp
                {!! Form::select('controller_name'  , [] , $controller_name , ['class' => 'form-control' , 'id' => 'controllers' , 'required']) !!}
            </div>
        </div>


        <div class="form-group">
            <div class="form-line">
                @php $method_name= isset($item) ? $item->method_name : null @endphp
                {!! Form::select('method_name'  , [] , $method_name , ['class' => 'form-control' , 'id' => 'method_name' , 'required']) !!}
            </div>
        </div>


        <div class="form-group">
            <div class="form-line">
                <label for="">{{ trans('admin.Not Allow')}}
                    <input type="radio" name="permission" {{ isset($item) && $item->permission == 0 ? 'checked' : '' }} value="0">
                </label>
                <label for="">{{ trans('admin.Allow')}}
                    <input type="radio" name="permission" {{ isset($item) && $item->permission == 1 ? 'checked' : '' }} value="1">
                </label>
            </div>
        </div>


        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-default" >
                <i class="material-icons">check_circle</i>
                {{ trans('permission.permission') }} {{ trans('home.save') }}
            </button>
        </div>


    </form>
    @endcomponent
@endsection


@section('script')
    @include('admin.permission.scripts')
@endsection