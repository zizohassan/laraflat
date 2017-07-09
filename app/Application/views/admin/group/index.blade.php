@extends(layoutExtend())

@section('title')
    {{  adminTrans('group' , 'group')}} {{ adminTrans('home' , 'control') }}
@endsection


@section('style')
    @include('admin.shared.style')
@endsection

@section('content')
    @include(layoutTable(), ['title' =>  adminTrans('group' , 'group'), 'model'=>'group', 'table' => $dataTable->table([] , true) ])
@endsection

@section('script')
    @include('admin.shared.scripts')
@endsection