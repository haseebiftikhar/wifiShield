@extends('templates.default')

@section('content')

@if ($session->has('info'))
		<div class="alert alert-info" role="alert">
			{{ $session->remove('info') }}
		</div>
@endif



<div style="clear:both"></div>
<div class="row">
	<div class="col-lg-12">
	<h4>Average Usage History</h4>
		<div class="outter-class">
		
			
			<div id="temps_div">
				<div style="position: relative;">
        			<div dir="Temps" style="position: relative; width: 935px; height: 600px;">
        				{!! \Lava::render('LineChart', 'Temps', 'temps_div') !!}
            			@linechart('Temps', 'temps_div')
            		</div>
            	</div>
        	</div>

		</div>
	</div>
</div>

<div style="clear:both"></div>
<h1></h1>
<div class="row">
	<div class="col-lg-12">
	<h4>Search by date range</h4>
	<form class="form-vertical" role="form" method="post" action="/wifiShield/search/">
		
			<div class="col-lg-3">
			<h5></h5>
				<div class="form-group">
					<label for="from_date" class="control-label">Start date</label>
					<input type="date" name="from_date" class="form-control" id="from_date" value="{{ Request::old('from_date')? :''}}" placeholder="From Date">
				</div>


				<div>
					<button type="submit" class="btn btn-default">Search</button>
				</div>
			</div>
			<div class="col-lg-3">
			<h5></h5>
				<div class="form-group">
					<label for="to_date" class="control-label">End date</label> 
					<input type="date" name="to_date" class="form-control" id="to_date" value="{{ Request::old('to_date')? :''}}" placeholder="To Date">
				</div>


			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label for="device" class="control-label">Device</label> 
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
				

			</div>
			
	</form>
	
	</div>
</div>


@stop