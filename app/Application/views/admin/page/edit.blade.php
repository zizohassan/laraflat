@extends(layoutExtend())

@section('title')
    {{ adminTrans('page' , 'page') }} {{  isset($item) ? adminTrans('curd' , 'edit'): adminTrans('curd' , 'add') }}
@endsection

@section('style')
    {{ Html::style('/admin/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => adminTrans('page' , 'page') ,'model' => 'page' , 'action' => isset($item) ? adminTrans('curd' , 'edit') : adminTrans('curd' , 'add') ])
    @include(layoutMessage())
        <form action="{{ concatenateLangToUrl('admin/page/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            {!! extractFiled('title' , isset($item->title) ? $item->title : old('title') , 'text' , 'page') !!}


            <div class="form-group">
                <div class="form-line">
                    <label for="">{{ adminTrans('page' , 'slug') }}</label>
                    <input type="text" name="slug" id="slug" placeholder="{{ adminTrans('page' , 'slug') }}" class="form-control" value="{{ isset($item) ? $item->slug : old('slug') }}"/>
                </div>
            </div>

            {!! extractFiled('body' , isset($item->body) ? $item->body : old('body') , 'textarea' , 'page' , 'tinymce' ) !!}

            <div class="form-group">
                <div class="">
                    <label for="">{{ adminTrans('page' , 'status') }}</label>
                    @php $status = isset($item) ? $item->status  : null @endphp
                    {!! Form::select('status' , status() , $status, ['class' => 'form-control' ] ) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <label for="">{{ adminTrans('page' , 'date') }}</label>
                    <input type="text" name="date" class="datepicker form-control" value="{{ isset($item) ? $item->date : old('date') }}">
                </div>
            </div>



            <div class="form-group">
                <div class="form-line">
                    <label for="">{{ adminTrans('page' , 'image') }}</label>
                    @if(isset($item) && $item->image != '')
                        <img src="{{ url('/'.env('UPLOAD_PATH').'/'.$item->image) }}" class="img-responsive thumbnail" alt="">
                        <br>
                    @endif    
                    <input type="file" name="image" class="" {{ !isset($item) ? "required='required'" : '' }}>
                </div>
            </div>


            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    {{ adminTrans('home' , 'save') }} {{ adminTrans('page' , 'page') }}
                </button>
            </div>
        </form>
    @endcomponent
@endsection
@section('script')
    @include(layoutPath('layout.helpers.tynic'))
    {{ Html::script('/admin/plugins/momentjs/moment.js') }}
    {{ Html::script('/admin/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}
    <script>
        $('.datepicker').bootstrapMaterialDatePicker({
            time:false,
            format:"L",
            setDate:"{{ date('d/m/Y')  }}",
            nowButton:true
        });
    </script>
@endsection
