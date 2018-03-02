@extends(layoutExtend())

@section('title')
    {{ trans('categorie.Commnads') }} {{ trans('home.control') }}
@endsection

@section('content')
    <form action="{{ concatenateLangToUrl('admin/command/exe') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="">
                <label for="">{{ trans('user.Laraflat Commands') }}</label>
                <select name="commands" id="commands" class="form-control">
                    @foreach($commands as $keyCommandArray => $command)
                        <option value="{{ $keyCommandArray }}">{{ $command }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div id="form"></div>
        <div id="cols"></div>
         <div class="form-group">
            <input type="submit" name="submit" value="{{ trans('admin.Execute') }}" class="btn btn-default" />
            <span class="btn btn-danger" onclick="$('#otherForm').slideToggle()">{{ trans('admin.Add Command') }}</span>
         </div>
    </form>
    <form action="{{ concatenateLangToUrl('admin/laravel/haveCommand') }}" method="post" id="otherForm" style="display: none">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="">
                <label for="">{{ trans('user.Laraflat Model Name') }}</label>
                <input type="text" name="name" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="">
                <label for="">{{ trans('user.Laraflat Commands') }}</label>
                <textarea name="cols" id="" cols="30" rows="10" class="form-control"></textarea>
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
        @foreach($history as $h)
            <tr>
                <td>{{ $h->name }}</td>
                <td>{{ $h->command }} {{ $h->name }} --cols={{ $h->options }}</td>
                <td>
                    @if($h->command != 'laraflat:rollback')
                        <form action="{{ concatenateLangToUrl('admin/command/exe') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="commands" value="laraflat:rollback">
                            <input type="hidden" name="name" value="{{ ucfirst($h->name) }}">
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
   @include('admin.commands.script')
@endsection
