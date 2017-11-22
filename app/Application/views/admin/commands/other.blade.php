@extends(layoutExtend())

@section('title')
    {{ trans('categorie.Commnads') }} {{ trans('home.control') }}
@endsection

@section('content')
    <form action="{{ concatenateLangToUrl('admin/command/otherExe') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="">
                <label for="">{{ trans('user.Laraflat Commands') }}</label>
                <select name="commands" id="commands" class="form-control">
                    @foreach($commands as $command)
                        <option value="{{ $command }}">{{ $command }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <input type="submit" name="submit" value="{{ trans('admin.Execute') }}" class="btn btn-default" />
        </div>
    </form>

@endsection


