@extends(layoutExtend())

@section('title')
    {{ trans('setting.setting') }} {{  isset($item) ? trans('curd.edit') : trans('curd.add') }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => trans('setting.setting') , 'model' => 'setting' , 'action' => isset($item) ? trans('curd.edit') : trans('curd.add') ])
    @include(layoutMessage())
        <form action="{{ concatenateLangToUrl('admin/setting/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}


            @if(env('APP_ENV') == 'local' || !isset($item))
            <div class="form-group">
                <div class="form-line">
                    <label for="">{{ trans('setting.name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ isset($item) ? $item->name : old('name')}}"/>
                </div>
            </div>
            @else
                {{ $item->name  }}
            @endif



                <div class="form-group">
                    <div class="">
                        <label for="">{{ trans('setting.type') }}</label>
                        @php $type = isset($item) ? $item->type : null @endphp
                        {!! Form::select('type' , setting_type() , $type  , ['id' => 'setting_type'  , 'class' => 'form-control'] ) !!}
                    </div>
                </div>



            <div class="setting_content">
                @if(isset($item))
                        @if($item->type == 'text')
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="body_setting" id="body" class="form-control" value="{{ $item->body_setting }}"/>
                                </div>
                            </div>
                        @elseif($item->type == 'image')
                            <div class="form-group">
                                <div class="form-line">
                                    <img src="{{ url('/'.env('UPLOAD_PATH').'/'.$item->body_setting) }}" class="img-responsive thumbnail" />
                                    <input type="file" name="body_setting">
                                </div>
                            </div>
                        @elseif($item->type == 'textarea')
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea type="text" name="body_setting" id="body" class="form-control">{{ $item->body_setting }}</textarea>
                                </div>
                            </div>
                        @endif
                    @else
                        @include('admin.setting.script.text')
                @endif
            </div>


            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    {{ trans('home.save') }}   {{ trans('setting.setting') }}
                </button>
            </div>
        </form>
    @endcomponent
@endsection

@section('script')
        <script>
            $('#setting_type').on('change' , function(){
                var value  = $(this).val();
                var content  = $('.setting_content');
                if(value == 'text'){
                    content.html('@include('admin.setting.script.text')');
                }else if(value == 'image'){
                    content.html('@include('admin.setting.script.image')');
                }else if(value == 'textarea'){
                    content.html('@include('admin.setting.script.textarea')');
                }
            });
        </script>
@endsection
