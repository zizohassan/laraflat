@extends('admin.layout.app')

@section('title')
    permission {{  isset($item) ? ucfirst('edit') : ucfirst('add') }}
@endsection

@section('content')
    @component('admin.layout.form' , ['title' => 'permission' , 'action' => isset($item) ? 'edit' : 'add' ])
        @include('admin.layout.messages')
        <form action="{{ url('admin/permission/item') }}/{{ isset($item) ? $item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="form-line">
                    <input type="text" name="name" id="name" placeholder="permission name" class="form-control" value="{{ isset($item) ? $item->name : '' }}"/>
                </div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <input type="text" name="slug" id="name" class="form-control" placeholder="permission slug" value="{{ isset($item) ? $item->slug : '' }}"/>
                </div>
            </div>
            <div class="form-group">
                <div class="form-line">
                    <textarea  name="description" id="description"  placeholder="permission description" class="form-control">{{ isset($item) ? $item->description : '' }}</textarea>
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
                            <label> Add  {!! Form::select('action_add' , permissionType() , $add , ['calss' => 'form-control']) !!}</label>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="">
                            @php $delete= isset($item) ? $item->action_delete  : '' @endphp
                            <label>Delete {!! Form::select('action_delete' , permissionType() , $delete , ['calss' => 'form-control']) !!}</label>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="">
                            @php $view= isset($item) ? $item->action_view  : '' @endphp
                            <label>View {!! Form::select('action_view' , permissionType() , $view , ['calss' => 'form-control']) !!}</label>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="">
                            @php $edit= isset($item) ? $item->action_edit  : '' @endphp
                            <label>Edit {!! Form::select('action_edit' , permissionType() , $edit , ['calss' => 'form-control']) !!}</label>
                        </div>
                    </div>

                </div>
            </div>





            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    save permission
                </button>
            </div>
        </form>
    @endcomponent
@endsection
