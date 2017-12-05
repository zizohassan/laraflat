@extends(layoutExtend())

@section('title')
    {{  trans('home.File Manager')}} {{ trans('home.control') }}
@endsection



@section('content')
    <div id="elfinder"></div>
@endsection


@section('script')
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    {{ Html::script('admin/plugins/tinymce/plugins/elfinder/js/elfinder.min.js') }}

        <script type="text/javascript" charset="utf-8">
            $().ready(function() {
                $('#elfinder').elfinder({
                    customData: {
                        _token: '{{ csrf_token() }}'
                    },
                    url : '/admin/plugins/tinymce/plugins/elfinder/php/connector.php'
                });
            });
        </script>
@endsection
