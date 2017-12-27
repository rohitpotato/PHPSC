
@extends ('templates.defaults')

@section ('content')
	<div class = "row">
	<div class = "col-lg-6">
		<form role = 'form' action="{{ route('status.post') }}" method = "POST">
			{{ csrf_field() }}
			<div class = "form-group{{$errors->has('status') ? ' has-error': ''}}">
				<textarea placeholder = "Whats up {{ Auth::user()->username }}?" name = "status" class = "form-control" rows = '2'></textarea>

				@if($errors->has('status'))
					<span class = "help-block">{{$errors->first()}}</span>
				@endif	
			</div>
			<button type = "submit" class = "btn btn-default">Update Status</button>
			</form>
			<hr>

	</div>
</div>
	<div class = "row">
	<div class = "col-lg-5">
	@if(!$statuses->count())
		<p>There is nothing in your timeline!</p>
		@else
			@foreach($statuses as $status)
						<div class="media">
			    <a class="pull-left" href="#">
			        <img class="media-object" alt="" src="{{ $status->user->getAvatarUrl() }}">
			    </a>
			    <div class="media-body">
			        <h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $status->user->username]) }}">{{ $status->user->username }}</a></h4>
			        <p>{{ $status->body }}</p>
			        <ul class="list-inline">
			            <li>{{ $status->created_at->diffForHumans() }}</li>
			           @if($status->user->id != Auth::user()->id) 
			            <li><a href="{{ route('status.like', ['statusId' => $status->id]) }}">Like</a></li>
			            @endif
			            <li>{{ $status->likes->count() }} {{ str_plural('like',$status->likes->count()) }}</li>
			           @if($status->user_id == Auth::user()->id) 
			            <li><a href="{{route('status.edit',['id' => $status->id])}}">Edit Post</a></li>
			           @endif 
			            
			        </ul>
			        @foreach($status->replies as $reply)
			        <div class = "media">
			        	<a class = "pull-left" href = "">
			        	  <img class = "media-object" alt = " " src = "{{ $reply->user->getAvatarUrl() }}"></a>
			        	  <div class = "media-body">
			        	  <h5 class = "media-heading"><a href = "{{ route('profile.index', ['username' => $reply->user->username]) }}">{{$reply->user->username}}</a></h5>
			        	  <p>{{$reply->body}}</p>
			        	  <ul class="list-inline">
			        	  	<li>{{ $reply->created_at->diffForHumans() }}</li>
			        	  @if($reply->user->id != Auth::user()->id)
			        	  	<li><a href = "{{ route('status.like', ['statusId' => $reply->id]) }}">Like</a></li>
			        	  @endif	
			     
			        	  	<li>{{ $reply->likes->count() }} {{ str_plural('like',$reply->likes->count()) }}</li>
			        	  @if(Auth::user()->id == $reply->user_id)	
			        		<li><a href="{{route('status.commentedit',['replyId' => $reply->id]) }}">Edit Comment</a></li>
			        	  @endif	
			        	  	</ul>
			        	  </div>
			        	 </div> 	
			        @endforeach
			 
			        <form role="form" action="{{ route('status.reply',['statusId' => $status->id ]) }}" method="post">
			        {{csrf_field() }}
			            <div class="form-group{{$errors->has("reply-{$status->id}") ? ' has-error': '' }}">
			                <textarea name="reply-{{ $status->id }}" class="form-control" rows="2" placeholder="Reply to this status"></textarea>
			            </div>
			            <input type="submit" value="Reply" class="btn btn-default btn-sm">
			            <input type = "hidden" name = "statusid" value = "{{  $status->id }}">
			        </form>
			        @if($errors->has("reply-{status->id}" ))
			        	<span class = "help-block">{{$errors->first()}}</span>
			        	@endif

			    </div>
			
		@endforeach

		{{!! $statuses->render() !!}}
	@endif
		</div>
	</div>	
	
@endsection