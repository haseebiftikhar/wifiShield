@extends('templates.default')

@section('content')
	<h3>Welcome to Chatty</h3>
	<p>The Best Social Network ... etc</p>
	@if ($session->has('info'))
		<div class="alert alert-info" role="alert">
			{{ $session->remove('info') }}
		</div>
	@endif
@stop