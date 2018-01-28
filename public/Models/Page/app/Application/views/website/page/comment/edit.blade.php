@if(isset($item) && auth()->check())	<form method="post" action="{{ concatenateLangToUrl("page/add/comment/".$item->id) }}">{{ csrf_field() }}
		<div class="form-group">
			<label for="comment">{{ trans( "admin.Comment") }}</label>
			<textarea name="comment" id="comment" rows="8" class="form-control"></textarea>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-info">{{ trans( "admin.Add Comment") }}</button>
		</div>
	</form>
@endif