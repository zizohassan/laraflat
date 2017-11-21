@extends(layoutExtend())

@section('title')
    {{  trans('group.group')}} {{ trans('home.control') }}
@endsection


@section('style')
    @include('admin.shared.style')
@endsection

@section('content')
    @include(layoutTable(), ['title' =>  trans('group.group'), 'model'=>'group', 'table' => $dataTable->table([] , true) ])
@endsection

@section('script')
    @include('admin.shared.scripts')
@endsection