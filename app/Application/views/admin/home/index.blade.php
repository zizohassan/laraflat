@extends('admin.layout.app')

@section('title')
    home Control
@endsection


@section('content')

    <div class="row clearfix">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">User</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['userCount']}}" data-speed="15" data-fresh-interval="20">{{$data['userCount']}}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">help</i>
                    </div>
                    <div class="content">
                        <div class="text">Groups</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['groupCount']}}" data-speed="1000" data-fresh-interval="20">{{$data['groupCount']}}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-light-green hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">forum</i>
                    </div>
                    <div class="content">
                        <div class="text">Permissions</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['permissionsCount']}}" data-speed="1000" data-fresh-interval="20">{{ $data['permissionsCount'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-orange hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">person_add</i>
                    </div>
                    <div class="content">
                        <div class="text">Role</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['roleCount']}}" data-speed="1000" data-fresh-interval="20">{{ $data['roleCount'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-blue-grey hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">find_in_page</i>
                    </div>
                    <div class="content">
                        <div class="text">Pages</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['pages']}}" data-speed="1000" data-fresh-interval="20">{{ $data['pages'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-red hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">menu</i>
                    </div>
                    <div class="content">
                        <div class="text">Menus</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['menus']}}" data-speed="1000" data-fresh-interval="20">{{ $data['menus'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-amber hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">build</i>
                    </div>
                    <div class="content">
                        <div class="text">Setting</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['setting']}}" data-speed="1000" data-fresh-interval="20">{{ $data['setting'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-light-blue hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">info</i>
                    </div>
                    <div class="content">
                        <div class="text">Logs</div>
                        <div class="number count-to" data-from="0" data-to="{{$data['logs']}}" data-speed="1000" data-fresh-interval="20">{{ $data['logs'] }}</div>
                    </div>
                </div>
            </div>
    </div>



    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
            <div class="card">
                <div class="header">
                    <h2>Last Register User</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);" class=" waves-effect waves-block">Action</a></li>
                                <li><a href="javascript:void(0);" class=" waves-effect waves-block">Another action</a></li>
                                <li><a href="javascript:void(0);" class=" waves-effect waves-block">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover dashboard-task-infos">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>UserName</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($data['lastRegisterUser'] as $last)
                                <tr>
                                    <td>{{ $last->id }}</td>
                                    <td>{{ $last->name }}</td>
                                    <td>{{ $last->created_at}}</td>
                                    <td>
                                        <a href="{{ url('admin/user/item/'.$last->id) }}">Edit</a>
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
            <div class="card">
                <div class="body bg-cyan">
                    <div class="m-b--35 font-bold">Admin Panel Log</div>
                    <ul class="dashboard-stat-list align-left">
                        @foreach($data['log'] as $Log)
                            <li>
                                <a href="{{ url('admin/log/'.$Log->id.'/view') }}" class="col-white">
                                    #{{ $Log->user->name }}
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
    <div class="row clearfix">
        <!-- Line Chart -->
        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>LINE CHART</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <canvas id="myChart"  ></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script>
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! $data['country'] !!},
                datasets: [{
                    label: '# of Votes',
                    height: 100,
                    data: {!! $data['count'] !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>

@endsection

