@extends('templates.default')

@section('content')

	@if ($session->has('info'))
		<div class="alert alert-info" role="alert">
			{{ $session->remove('info') }}
		</div>
	@endif

	<h3>Welcome to Application</h3>
	<p> To proceed further kindly add your Device Id</p>
<div class="row">
	<div class="col-lg-6">
		<form class="form-vertical" role="form" method="post" action="{{ route('newdashBoard') }}">
			<div class="form-group{{ $errors->has('mac_address') ? ' has-error' : ''}} ">
				<label for="mac_address" class="control-label">Device Number</label>
				<input type="text" name="mac_address" class="form-control" id="mac_address" value="{{ Request::old('mac_address')? :''}}">
			</div>
			<div>
				<button type="submit" class="btn btn-default">Add Device</button>
			</div>

		</form>
	</div>
<div>
@stop