@extends ('templates.defaults')

@section ('content')
<h3>Edit Comment</h3>
	<div class="row">
        <div class="col-lg-6">
          <form class="form-vertical" role="form" method="post" action="{{ route('status.commentupdate', ['replyId' => $reply->id]) }}" >
          	{{ csrf_field() }}
             <div class="row">
                  <div class="col-lg-6">
                     <div class="form-group{{$errors->has('body') ? ' has-error':'' }}">
                          <input type = "hidden"  name = "id" value = "{{ $reply->id }}">
                           <input type="text" name="body" class="form-control" id="body" value="{{ $reply->body }}">

                           @if($errors->has('body'))
                           	<span class = "help-block" {{$errors->first('body') }}</span>
                           	@endif
                      </div>
                      <input type="submit" value="Update" class="btn btn-default btn-sm">
                      </div>
                   </div>
                  </div>
                 </form>
                </div>
               </div>
@endsection