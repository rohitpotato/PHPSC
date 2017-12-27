@extends ('templates.defaults')

@section ('content')
	<div class="row">
        <div class="col-lg-6">
          <form class="form-vertical" role="form" method="post" action"{{ route('profile.edit') }}">
          	{{ csrf_field() }}
             <div class="row">
                  <div class="col-lg-6">
                     <div class="form-group{{$errors->has('first_name') ? ' has-error':'' }}">
                          <label for="first_name" class="control-label">First name</label>
                           <input type="text" name="first_name" class="form-control" id="first_name" value="{{ Auth::user()->first_name ?: Request::old('first_name') }}">

                           @if($errors->has('first_name'))
                           	<span class = "help-block" {{$errors->first('first_name') }}</span>
                           	@endif
                      </div>
                   </div>
               <div class="col-lg-6">
                    <div class="form-group{{$errors->has('last_name') ? ' has-error':'' }}"">
                           <label for="last_name" class="control-label">Last name</label>
                           <input type="text" name="last_name" class="form-control" id="last_name" value="{{ Auth::user()->last_name ?: Request::old('last_name') }}">
                            @if($errors->has('last_name'))
                           	<span class = "help-block" {{$errors->first('last_name') }}</span>
                           	@endif
                     </div>
                </div>
           </div>
               <div class="form_group{{ $errors->has('location') ? ' has-error': '' }}"">
                 <label for="location" class="control-label">Location</label>
                  <input type="text" name="location" class="form-control" id="location" value="{{ Auth::user()->location ?: Request::old('location') }}">
                  </div>
                   @if($errors->has('location'))
                      	<span class = "help-block" {{$errors->first('location') }}</span>
                  	@endif
                  <hr><br>
               <div class="form-group">
                  <button tupe="submit" class="btn btn-default">Update</button>
              </div>
      </form>
       </div>
   </div>
@endsection