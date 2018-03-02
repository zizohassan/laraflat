@extends(layoutExtend())

@section('title')
    {{ trans('post.post') }} {{ trans('home.view') }}
@endsection

@section('content')
    @component(layoutForm() , ['title' => trans('post.post') , 'model' => 'post' , 'action' => trans('home.view')  ])
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

        @include('admin.post.buttons.delete' , ['id' => $item->id])
        @include('admin.post.buttons.edit' , ['id' => $item->id])
    @endcomponent
@endsection
