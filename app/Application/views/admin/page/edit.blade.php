@extends('admin.layout.app')

@section('title')
    page {{  isset($item) ? ucfirst('edit') : ucfirst('add') }}
@endsection

@section('style')
    {{ Html::style('/admin/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}
@endsection

@section('content')
    @component('admin.layout.form' , ['title' => 'page' , 'action' => isset($item) ? 'edit' : 'add' ])
        @include('admin.layout.messages')
        <form action="{{ url('admin/page/item') }}/{{ isset($item) ? $item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="form-line">
                    <label for="">Page Title</label>
                    <input type="text" name="title" id="title" placeholder="Page Title" class="form-control" value="{{ isset($item) ? $item->title : '' }}"/>
                </div>
            </div>


            <div class="form-group">
                <div class="form-line">
                    <label for="">Page Slug</label>
                    <input type="text" name="slug" id="slug" placeholder="Page Slug" class="form-control" value="{{ isset($item) ? $item->slug : '' }}"/>
                </div>
            </div>



            <div class="form-group">
                <div class="form-line">
                    <label for="">Page Body</label>
                    <textarea name="body" id="tinymce" cols="30" class="tinymce" rows="10">{{ isset($item) ? $item->body : '' }}</textarea>
                </div>
            </div>


            <div class="form-group">
                <div class="">
                    <label for="">Page Status</label>
                    @php $status = isset($item) ? $item->status  : null @endphp
                    {!! Form::select('status' , status() , $status, ['class' => 'form-control' ] ) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <label for="">Publish Date</label>
                    <input type="text" name="date" class="datepicker form-control" value="{{ isset($item) ? $item->date : '' }}">
                </div>
            </div>



            <div class="form-group">
                <div class="form-line">
                    <label for="">Page Image</label>
                    @if(isset($item) && $item->image != '')
                        <img src="{{ url('/'.env('UPLOAD_PATH').'/'.$item->image) }}" class="img-responsive thumbnail" alt="">
                        <br>
                    @endif    
                    <input type="file" name="image" class="">
                </div>
            </div>


            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    save page
                </button>
            </div>
        </form>
    @endcomponent
@endsection
@section('script')
    @include('admin.layout.helpers.tynic')
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
