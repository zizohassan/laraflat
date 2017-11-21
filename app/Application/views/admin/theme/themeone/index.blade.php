@extends(layoutExtend())

@section('title')
    home Control
@endsection


@section('content')

    <div class="row clearfix">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="card card-block">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">{{ trans('home.user') }}</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['userCount']}}" data-speed="15" data-fresh-interval="20">{{$data['userCount']}}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="card card-block">
                    <div class="icon">
                        <i class="material-icons">help</i>
                    </div>
                    <div class="content">
                        <div class="text">{{ trans('home.groups') }}</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['groupCount']}}" data-speed="1000" data-fresh-interval="20">{{$data['groupCount']}}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="card card-block">
                    <div class="icon">
                        <i class="material-icons">forum</i>
                    </div>
                    <div class="content">
                        <div class="text">{{ trans('home.permissions') }}</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['permissionsCount']}}" data-speed="1000" data-fresh-interval="20">{{ $data['permissionsCount'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="card card-block">
                    <div class="icon">
                        <i class="material-icons">person_add</i>
                    </div>
                    <div class="content">
                        <div class="text">{{ trans('home.roles') }}</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['roleCount']}}" data-speed="1000" data-fresh-interval="20">{{ $data['roleCount'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="card card-block">
                    <div class="icon">
                        <i class="material-icons">find_in_page</i>
                    </div>
                    <div class="content">
                        <div class="text">{{ trans('home.pages') }}</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['pages']}}" data-speed="1000" data-fresh-interval="20">{{ $data['pages'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="card card-block">
                    <div class="icon">
                        <i class="material-icons">menu</i>
                    </div>
                    <div class="content">
                        <div class="text">{{ trans('home.menus') }}</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['menus']}}" data-speed="1000" data-fresh-interval="20">{{ $data['menus'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="card card-block">
                    <div class="icon">
                        <i class="material-icons">build</i>
                    </div>
                    <div class="content">
                        <div class="text">{{ trans('home.setting') }}</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['setting']}}" data-speed="1000" data-fresh-interval="20">{{ $data['setting'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="card card-block">
                    <div class="icon">
                        <i class="material-icons">info</i>
                    </div>
                    <div class="content">
                        <div class="text">{{ trans('home.logs') }}</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['logs']}}" data-speed="1000" data-fresh-interval="20">{{ $data['logs'] }}</div>
                    </div>
                </div>
            </div>
    </div>



    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
            <div class="card card-block">
                <div class="header">
                    <h5>{{ trans('home.last_register_user') }}</h5>
                </div>
                <div class="body">
                    <div class="">
                        <table class="table table-hover dashboard-task-infos">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('home.username') }}</th>
                                <th>{{ trans('home.created_at') }}</th>
                                <th>{{ trans('curd.edit') }}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($data['lastRegisterUser'] as $last)
                                <tr>
                                    <td>{{ $last->id }}</td>
                                    <td>{{ $last->name }}</td>
                                    <td>{{ $last->created_at}}</td>
                                    <td>
                                        <a href="{{ url('admin/user/item/'.$last->id) }}">{{ trans('home.edit') }}</a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
            <div class="card card-block">
                <div class="">
                    <div class="m-b--35 font-bold"><h5>{{ trans('home.admin_panel_log') }}</h5></div>
                    <ul class="list-unstyled m-x-n m-b-0">
                        @foreach($data['log'] as $Log)
                            <li class="b-t p-a-1">
                                <a href="{{ url('admin/log/'.$Log->id.'/view') }}" class="col-white">
                                    @if($Log->user)
                                        #{{ $Log->user->name }}
                                    @else
                                        {{ trans('admin.Visitor') }}
                                    @endif
                                    <span class="pull-right align-left">
                                         <b>{{ $Log->model }}</b> : {{ $Log->action }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection



