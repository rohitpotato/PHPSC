@extends ('templates.defaults')

@section ('content')
<h3>Edit Status</h3>
	<div class="row">
        <div class="col-lg-6">
          <form class="form-vertical" role="form" method="post" action="{{ route('status.update', ['id' => $id->id]) }}" >
          	{{ csrf_field() }}
             <div class="row">
                  <div class="col-lg-6">
                     <div class="form-group{{$errors->has('body') ? ' has-error':'' }}">
                          <input type = "hidden"  name = "id" value = "{{ $id->id }}">
                           <input type="text" name="body" class="form-control" id="body" value="{{ $id->body }}">

                           @if($errors->has('body'))
                           	<span class = "help-block" {{$errors->first('body') }}</span>
                           	@endif
                      </div>
                      <input type="submit" value="Update" class="btn btn-default btn-sm">
                      </div>
                   </div>
                  </div>
                 </form>
                 <form action = "{{ route('status.delete',['id' => $id->id]) }}" method="POST" class="form-vertical" role="form">
                  {{ csrf_field() }}
                  <div>
                      <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                   </div>
            </form> 
                </div>
               </div>
@endsection