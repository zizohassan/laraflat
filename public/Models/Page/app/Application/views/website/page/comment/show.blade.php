		@php $comments = \App\Application\Model\PageComment::where("page_id" ,$item->id )->with("user")->get(); @endphp
			<h3>{{ trans( "admin.Comments") }} ({{ count($comments) }})</h3>
		@if(count($comments) > 0)
		<ol>
		@foreach($comments as $comment)
			<li>
				<div>
					<span>{{ $comment->user->name}}</span>
					<span>{{ $comment->created_at}}</span>
					<p>{{ $comment->comment}}</p>
@if(auth()->check() && $comment->user_id == auth()->user()->id)			<a href="{{concatenateLangToUrl("page/delete/comment/".$comment->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
			<span class="btn btn-info" onclick="$(this).next().slideToggle()"><i class="fa fa-edit"></i></span>
	<form method="post" action="{{ concatenateLangToUrl("page/update/comment/".$comment->id) }}" style="display:none">	{{ csrf_field() }}
		<div class="form-group">
			<label for="comment">{{ trans( "admin.Comment") }}</label>
			<textarea name="comment" id="comment" rows="8" class="form-control">{{ $comment->comment }}</textarea>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-info">{{ trans( "admin.Update Comment") }}</button>
		</div>
	</form>
@endif		{!! !$loop->last ? "<hr>"  : ""   !!} 
				</div>
			</li>
		@endforeach
		</ol>
		@endif
