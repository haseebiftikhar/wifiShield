@extends('templates.default')

@section('content')

	@if ($session->has('info'))
		<div class="alert alert-info" role="alert">
			{{ $session->remove('info') }}
		</div>
	@endif

	<h3>Welcome to Application</h3>
	<p> To proceed further kindly add your Device MAC Address</p>
<div class="row">
	<div class="col-lg-6">
		<form class="form-vertical" role="form" method="post" action="{{ route('newdashBoard') }}">
			<div class="form-group{{ $errors->has('mac_address') ? ' has-error' : ''}} ">
				<label for="mac_address" class="control-label">Device MAC address</label>
				<input type="text" name="mac_address" class="form-control" id="mac_address" value="{{ Request::old('mac_address')? :''}}">
			</div>
			<div class="form-group{{ $errors->has('device_name') ? ' has-error' : ''}} ">
				<label for="device_name" class="control-label">Device Name</label>
				<input type="text" name="device_name" class="form-control" id="device_name" value="{{ Request::old('device_name')? :''}}">
			</div>
			<p> * Please give an arbritary name to your device</p>
			<div>
				<button type="submit" class="btn btn-default">Add Device</button>
			</div>

		</form>
	</div>
<div>
@stop