@extends('templates.default')

@section('content')

	@if ($session->has('info'))
		<div class="alert alert-info" role="alert">
			{{ $session->remove('info') }}
		</div>
	@endif

	<h3>Remove your device</h3>
	<p>Select your device carefully because once device is removed your usage history for that device will be deleted.</p>

<div class="row">
<h1></h1><h2></h2>
	<div class="col-lg-12">
		<form class="form-vertical" role="form" method="post" action="{{ route('remove') }}">
			<div class="form-group">
				<div>
					<select name="device">
						<option value="nodevice">Select Device</option>
							@if ($macAddress)
								@foreach($macAddress as $macAddres)
								  	<option value="{!!$macAddres->device_name!!}">{!!$macAddres->device_name!!}</option>
								@endforeach
							@endif
					</select>
				</div>
			</div>

			<div class="form-group">
				<div>
					<button type="submit" class="btn btn-default">Remove</button>
				</div>
			</div>
		</form>
	</div>

</div>

@stop