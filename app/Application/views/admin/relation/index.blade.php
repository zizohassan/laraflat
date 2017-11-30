@extends(layoutExtend())

@section('title')
    {{ trans('categorie.Commnads') }} {{ trans('home.control') }}
@endsection

@section('content')
    <form action="{{ concatenateLangToUrl('admin/relation/exe') }}" method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <div class="">
                        <label for="">{{ trans('admin.primary_key') }}</label>
                        <select name="primary_key" id="primary_key" class="form-control" required>
                            @foreach($models as $model)
                                <option value="{{ $model }}">{{ $model }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <div class="">
                        <label for="">{{ trans('admin.foreign Key') }}</label>
                        <select name="foreign_key" id="foreign_key" class="form-control" required>
                            @foreach($models as $model)
                                <option value="{{ $model }}">{{ $model }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <div class="">
                        <label for="">{{ trans('admin.Enable foreign Keys') }}</label>
                        <select name="enable_foreign" id="enable_foreign" class="form-control" required>
                            <option value="1">{{ trans('admin.Yes') }}</option>
                            <option value="0">{{ trans('admin.No') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <div class="">
                        <label for="">{{ trans('admin.Relation Type') }}</label>
                        <select name="relation_type" id="relation_type" class="form-control" required>
                            <option value="oto">{{ trans('admin.One To One') }}</option>
                            <option value="otm">{{ trans('admin.One To many') }}</option>
                            <option value="mtm">{{ trans('admin.Many To Many') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <div class="">
                        <label for="">{{ trans('admin.Col1') }}</label>
                        {!! Form::select('col1' , [] , null, ['class' => 'form-control','id' => 'col2' ] ) !!}
                        <span>{{ trans('admin.title or name') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <div class="">
                        <label for="">{{ trans('admin.Col2') }}</label>
                        {!! Form::select('col2' , [] , null, ['class' => 'form-control', 'id' => 'col1' ] ) !!}
                        <span>{{ trans('admin.select the id') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mtmfc">
                <div class="form-group">
                    <div class="">
                        <label for="">{{ trans('admin.Forign Column') }}</label>
                        {!! Form::select('fkey' , [] , null, ['class' => 'form-control', 'id' => 'fkey' ] ) !!}
                        <span>{{ trans('admin.select title') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mtmtype">
                <div class="form-group">
                    <div class="">
                        <label for="">{{ trans('admin.Type many To Many') }}</label>
                        <select name="typeMtm" id="typeMtm" class="form-control" required>
                            <option value="checkbox">{{ trans('admin.Checkbox') }}</option>
                            <option value="select">{{ trans('admin.Select') }}</option>
                        </select>
                        <span>{{ trans('admin.select title') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="{{ trans('admin.Execute') }}" class="btn btn-default" />
        </div>
    </form>

    <table class="table table-bordered  table-striped">
        <tr>
            <th>{{ trans('admin.Name') }}</th>
            <th>{{ trans('admin.Command') }}</th>
            <th>#</th>
        </tr>
        @foreach($relations as $h)
            <tr>
                <td>{{ $h->name }}</td>
                <td>{{ $h->command }} {{ $h->name }} --cols={{ $h->options }}</td>
                <td>
                    @if($h->command != 'laraflat:rollback')
                        <form action="{{ concatenateLangToUrl('admin/relation/rollback') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="command" value="{{ $h->options }}">
                            <input type="hidden" name="name" value="{{ $h->name }}">
                            <div class="form-group">
                                <input type="submit" name="submit" value="{{ trans('admin.RollBack') }}" class="btn btn-danger" />
                            </div>
                        </form>
                    @else
                        ----
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endsection

@section('script')
    @include('admin.relation.script')
@endsection
