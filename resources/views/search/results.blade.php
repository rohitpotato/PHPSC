@extends ('templates.defaults')

@section ('content')
	<h3>Seach Results for "{{ request('query') }}"</h3>
	@if(!$users->count())
		<p>No results Found</p>
	@else
	<div class = 'row'>
		<div class = "col-lg-12">

		@foreach($users as $user)
			@include ('users/partials/userblock')
		@endforeach	
		</div>
	</div>
	@endif
@endsection