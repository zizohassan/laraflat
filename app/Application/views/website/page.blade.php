@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                   <h1>
                       {{ getDefaultValueKey($page->title) }}
                   </h1>

                    <p>
                        {{ getDefaultValueKey($page->body) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
