@extends('templates.default')

@section('content')
	<h3>Welcome to Energy Monitoring and Control System</h3>
	<p>A low cost smart energy monitoring and control system for self-aware buildings.</p>
	
	@if ($session->has('info'))
		<div class="alert alert-info" role="alert">
			{{ $session->remove('info') }}
		</div>
	@endif
@stop