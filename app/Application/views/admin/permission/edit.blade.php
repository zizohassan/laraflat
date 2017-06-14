@extends(layoutExtend())

@section('title')
    {{ adminTrans('permission' , 'permission') }} {{  isset($item) ? adminTrans('home' , 'edit') : adminTrans('home' , 'add') }}
@endsection

@section('content')
    @component( layoutForm() , ['title' => adminTrans('permission' , 'permission') , 'model' => 'permission' , 'action' => isset($item) ? adminTrans('home' , 'edit') : adminTrans('home' , 'add') ])
    @include(layoutMessage())
        <form action="{{ concatenateLangToUrl('admin/permission/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="form-line">
                    <input type="text" name="name" id="name" placeholder="{{ adminTrans('permission' , 'name') }}" class="form-control" value="{{ isset($item) ? $item->name : old('name') }}"/>
                </div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <input type="text" name="slug" id="name" class="form-control" placeholder="{{ adminTrans('permission' , 'slug') }}" value="{{ isset($item) ? $item->slug : old('slug')  }}"/>
                </div>
            </div>
            <div class="form-group">
                <div class="form-line">
                    <textarea  name="description" id="description"  placeholder="{{ adminTrans('permission' , 'des') }}" class="form-control">{{ isset($item) ? $item->description : old('description') }}</textarea>
                </div>
            </div>


            <div class="form-group">
                <div class="form-line">
                    @php $model = isset($item) ? $item->model : null @endphp
                    {!! Form::select('model'  , $data['model'] , $model , ['class' => 'form-control']) !!}
                </div>
            </div>


            <div class="form-group">
                <div class="">
                    <div class="col-sm-6">
                        <div class="">
                            @php $add = isset($item) ? $item->action_add  : '' @endphp
                            <label> {{ adminTrans('permission' , 'action_add') }}  {!! Form::select('action_add' , permissionType() , $add , ['calss' => 'form-control']) !!}</label>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="">
                            @php $delete= isset($item) ? $item->action_delete  : '' @endphp
                            <label>{{ adminTrans('permission' , 'action_delete') }} {!! Form::select('action_delete' , permissionType() , $delete , ['calss' => 'form-control']) !!}</label>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="">
                            @php $view= isset($item) ? $item->action_view  : '' @endphp
                            <label>{{ adminTrans('permission' , 'action_view') }} {!! Form::select('action_view' , permissionType() , $view , ['calss' => 'form-control']) !!}</label>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="">
                            @php $edit= isset($item) ? $item->action_edit  : '' @endphp
                            <label>{{ adminTrans('permission' , 'action_edit') }} {!! Form::select('action_edit' , permissionType() , $edit , ['calss' => 'form-control']) !!}</label>
                        </div>
                    </div>

                </div>
            </div>





            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    {{ adminTrans('home' , 'save') }} {{ adminTrans('permission' , 'permission') }}
                </button>
            </div>
        </form>
    @endcomponent
@endsection
