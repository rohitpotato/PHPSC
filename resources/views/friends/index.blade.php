@extends('templates.defaults')

@section('content')
	
	<div class="row">
		<div class="col-lg-6">
			<h3>Your friends</h3>
			@if ( ! $friends->count())
				<p>You currently have no friends.</p>
			@else 
				@foreach ($friends as $user)
					@include('users/partials/userblock')
				@endforeach
			@endif
		</div>
		<div class="col-lg-6">
			<h4>Friend requests</h4>
			@if ( ! $friendRequests->count())
				<p>You currently have no friend requests.</p>
			@else 
				@foreach ($friendRequests as $user)
					</div>
					@include('users/partials/userblock')
					<hr />
				@endforeach
			@endif
		</div>
	</div>

@stop