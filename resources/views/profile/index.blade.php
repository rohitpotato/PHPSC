 @extends ('templates.defaults')

@section ('content')
  <div class="row">
        <div class="col-lg-5">
           @include ('users.partials.userblock')
          <hr>
            @if(!$statuses->count())
              <p>{{ $user->username }} hasn't posted anything yet!</p>
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
                           @if($status->user->id !== Auth::user()->id) 
                            <li><a href="{{ route('status.like', ['statusId' => $status->id]) }}">Like</a></li>
                           @endif 
                           @if($status->user_id == Auth::user()->id) 
                            <li><a href="{{route('status.edit',['id' => $status->id])}}">Edit Post</a></li>
                           @endif 
                            <li>{{ $status->likes->count() }} {{ str_plural('like',$status->likes->count()) }}</li>
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
                              @if($reply->user->id !== Auth::user()->id)  
                              <li><a href = "{{ route('status.like', ['statusId' => $reply->id ]) }}">Like</a></li>
                              @endif
                              <li>{{ $reply->likes->count() }} {{ str_plural('like',$reply->likes->count()) }}</li>
                              </ul>
                            </div>
                           </div>   
                        @endforeach
                 
                      @if(Auth::user()->isFriendsWith($user) || Auth::user()->id == $status->user_id)
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
                     @endif     

               </div>
                
                @endforeach

             
           @endif
                    
     </div>
       
        



                <div class="col-lg-4 col-lg-offset-3">
                      @if(Auth::user()->hasFriendRequestPending($user))
                            <p>Waiting for {{ $user->getNameorUsername() }} to accept your friend request</p>
                       
                      @elseif(Auth::user()->hasFriendRequestReceived($user))
                        <a href = "{{ route('friend.accept',['username' => $user->username ])}}" class = "btn btn-primary">Accept Friend Request</a>
                        @elseif(Auth::user()->isFriendsWith($user))
                        <p>You and {{$user->getFirstNameorUsername() }} are friends!</p>
                        @elseif(Auth::user()->id != $user->id)
                          <a href = "{{route('friend.add', ['username' => $user->username] ) }}" class = "btn btn-primary">Add Friend</a>
                       @endif

                        <h4>{{ $user->getFirstNameorUsername() }}'s friends</h4>
                        @if(!$user->friends()->count())
                        	<p>{{ $user->getFirstNameorUsername() }} has no friends</p>
                        @else 
                        	@foreach($user->friends() as $user)
                        		@include('users/partials/userblock')
                        	@endforeach	
                        @endif
                </div>
   </div>
</div> 
  @endsection      