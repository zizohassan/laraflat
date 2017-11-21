@extends(layoutExtend())

@section('title')
    {{ trans('contact.contact') }} {{  isset($item) ? trans('home.edit')  : trans('home.add')  }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => trans('contact.contact') , 'model' => 'contact' , 'action' => isset($item) ? trans('home.edit')  : trans('home.add'),  'button' => false  ])
         @include(layoutMessage())
        <form action="{{ concatenateLangToUrl('admin/contact/item') }}{{ isset($item) ? '/'.$item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}


            <div class="form-group">
                <label for="name">{{ trans('contact.name') }}</label>
                <input type="text" name="name" id="name" value="{{ isset($item) ? $item->name : old('name') }}" class="form-control"/>
            </div>

            <div class="form-group">
                <label for="email">{{ trans('contact.email') }}</label>
                <input type="email" name="email" id="email" value="{{ isset($item) ? $item->email : old('email') }}" class="form-control"/>
            </div>


            <div class="form-group">
                <label for="subject">{{ trans('contact.subject') }}</label>
                <input type="text" name="subject" id="subject" value="{{ isset($item) ? $item->subject : old('subject') }}" class="form-control"/>
            </div>


            <div class="form-group">
                <label for="phone">{{ trans('contact.phone') }}</label>
                <input type="text" name="phone" id="phone" value="{{ isset($item) ? $item->phone : old('phone') }}" class="form-control"/>
            </div>


            <div class="form-group">
                <label for="experts">{{ trans('contact.message') }}</label>
                <textarea name="message" id="message" cols="30" rows="10" class="form-control">{{ isset($item) ? $item->message : old('message') }}</textarea>
            </div>



            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    {{ trans('home.save') }}  {{ trans('contact.contact') }}
                </button>
            </div>
        </form>
    @if(isset($item))
        @include('admin.contact.replay' , ['id' => $item->id])
    @endif
    @endcomponent
@endsection
