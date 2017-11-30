@extends(layoutExtend())

@section('title')
    {{ trans('categorie.Custom Permissions') }} {{ trans('home.control') }}
@endsection

@section('content')
    <table class="table table-bordered  table-striped">
        <tr>
            <th>{{ trans('admin.Name') }}</th>
            <th>{{ trans('admin.Control') }}</th>
        </tr>
            <tr>
                <td>{{ trans('admin.Website') }}</td>
                <td><a href="{{ url('admin/custom-permissions/readFile/website.php') }}" class="btn btn-primary"><i class="fa fa-edit"></i></a></td>
            </tr>
        <tr>
            <td>{{ trans('admin.Admin') }}</td>
            <td><a href="{{ url('admin/custom-permissions/readFile/admin.php') }}" class="btn btn-primary"><i class="fa fa-edit"></i></a></td>
        </tr>
    </table>
@endsection

