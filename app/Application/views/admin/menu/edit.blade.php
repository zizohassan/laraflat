@extends('admin.layout.app')

@section('title')
    menu {{  isset($item) ? ucfirst('edit') : ucfirst('add') }}
@endsection

@section('style')
    {{ Html::style('admin/plugins/nestable/jquery-nestable.css') }}
@endsection

@section('content')
    @component('admin.layout.form' , ['title' => 'menu' , 'action' => isset($item) ? 'edit' : 'add' ])
        @include('admin.layout.messages')
        <form action="{{ url('admin/menu/item') }}/{{ isset($item) ? $item->id : '' }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="form-line">
                    <input type="text" name="name" id="name" class="form-control" value="{{ isset($item) ? $item->name : '' }}"/>
                </div>
            </div>
            @if(isset($item))
                @include('admin.menu.helper.dropSection')
            @endif
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-default" >
                    <i class="material-icons">check_circle</i>
                    save menu
                </button>
                @if(isset($item))
                    <span class="btn btn-info waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal" >
                        <i class="material-icons">playlist_add</i>
                        Add New Item
                    </span>
                @endif
            </div>
        </form>
    @if(isset($item))
        @include('admin.menu.helper.model')
    @endif
    @endcomponent
@endsection
@section('script')
    @if(isset($item))
       @include('admin.menu.helper.scripts')
    @endif
@endsection
