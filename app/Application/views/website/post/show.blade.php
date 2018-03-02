@extends(layoutExtend('website'))

@section('title')
    {{ trans('post.post') }} {{ trans('home.view') }}
@endsection

@section('content')
<div class="pull-{{ getDirection() }} col-lg-9">
        <a href="{{ url('post') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> {{ trans('website.Back') }}  </a>
		 <table class="table table-bordered  table-striped" > 
				<tr>
				<th>{{ trans("post.title") }}</th>
					<td>{{ nl2br($item->title_lang) }}</td>
				</tr>
				<tr>
				<th>{{ trans("post.body") }}</th>
					<td>{{ nl2br($item->body_lang) }}</td>
				</tr>
				<tr>
				<th>{{ trans("post.active") }}</th>
					<td>
				{{ $item->active == 1 ? trans("post.Yes") : trans("post.No")  }}
					</td>
				</tr>
		</table>

        @include('website.post.buttons.delete' , ['id' => $item->id])
        @include('website.post.buttons.edit' , ['id' => $item->id])
</div>
@endsection
