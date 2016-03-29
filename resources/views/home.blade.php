@extends('templates.default')

@section('content')
	<h3>Welcome to Application</h3>
	<p>What the hell dont waste your time !!</p>
	<p>go to the top right corner and Signup/Sign in</p>
	@if ($session->has('info'))
		<div class="alert alert-info" role="alert">
			{{ $session->remove('info') }}
		</div>
	@endif
@stop