@extends('templates.default')

@section('content')

	@if ($session->has('info'))
		<div class="alert alert-info" role="alert">
			{{ $session->remove('info') }}
		</div>
	@endif

	<h3>Turn Your Device ON/OFF</h3>
	<p>Select your device carefully, it may take few minutes!!.</p>

<div class="row">
<h1></h1><h2></h2>
	<div class="col-lg-12">
		<form class="form-vertical" role="form" method="post" action="{{ route('status') }}">
			<div class="form-group">
				<div class="col-lg-9">
					<div>
						<select name="tdevice">
							<option value="nodevice">Select Device</option>
								@if ($macAddress)
									@foreach($macAddress as $macAddres)
									  	<option value="{!!$macAddres->device_name!!}">{!!$macAddres->device_name!!}</option>
									@endforeach
								@endif
						</select>
					</div>
					<h1></h1>
					<div>
						<select name="status">
							<option value="ON">ON</option>
							<option value="OFF">OFF</option>
						</select>
					</div>
					<h1></h1>
					<div>
						<button type="submit" class="btn btn-default">Change Status</button>
					</div>
				</div>
			</div>

		</form>
	</div>

</div>

@stop