@extends('templates.default')

@section('content')

@if ($session->has('info'))
		<div class="alert alert-info" role="alert">
			{{ $session->remove('info') }}
		</div>
@endif

<div class="row no-gap">
	<div class="col-lg-12 no-pad">
		<div class="panel panel-default">
	    <div class="panel-heading"><h5>Select Devices</h5></div>
		<div class="panel-body">
			<table>
			<?php $flag = 1; ?>
			
				<td>
					<form class="form-vertical no-pad" role="form" method="get" action="/wifiShield/data">
					<button type="submit" class="btn btn-default select-btn">ALL</button>
					</form>
				</td>
				@foreach($macAddress as $macAddres)
				@if($flag == 4)
				<?php $flag = 0; ?>
				<tr></tr>
					<td>
					
						<form class="form-vertical no-pad" role="form" method="get" action="/wifiShield/newRoute/{!!$macAddres->device_name!!}">
						<button type="submit" class="btn btn-default select-btn">{!!$macAddres->device_name!!}</button>
						</form>
					
					</td>
				@else
				<?php $flag = $flag+1; ?>
					<td>
					<form class="form-vertical no-pad" role="form" method="get" action="/wifiShield/newRoute/{!!$macAddres->device_name!!}">
					<button type="submit" class="btn btn-default select-btn">{!!$macAddres->device_name!!}</button>
					</form>
					</td>
				@endif
			
				@endforeach
				
			</table>
		</div>
		</div>
	</div>		
<div style="clear:both"></div>
<div class="row no-gap">
<!--	<div class="col-lg-2 no-pad">
		<div class="panel panel-default">
	        <div class="panel-heading"><h4 class="heading-color">Select Device</h4></div>
			<div class="panel-body">
            <table>
            	<tr>
					<form class="form-vertical no-pad" role="form" method="post" action="{{ route('newdashBoard') }}">
						<button type="submit" class="btn btn-default device-btn">ALL</button>
					</form>
				
				</tr>
				@foreach($macAddress as $macAddres)
				<tr>
					<form class="form-vertical no-pad" role="form" method="get" action="/wifiShield/newRoute/{!!$macAddres->device_name!!}">
						<button type="submit" class="btn btn-default device-btn">{!!$macAddres->device_name!!}</button>
					</form>
				
				</tr>
				@endforeach
				
			</table>
        </div>
		</div>
	</div> -->
	<div class="col-lg-12 no-pad">
	<div class="panel panel-default">
    <div class="panel-heading"><h4 class="heading-color">Average Usage History</h4></div>
	<div class="panel-body">
		<div class="outter-class no-pad no-gap">
		
			
			<div id="temps_div">
				<div style="position: relative;">
        			<div dir="Temps" style="position: relative; width: 135px; height: 600px;">
        				{!! \Lava::render('LineChart', 'Temps', 'temps_div') !!}
            			@linechart('Temps', 'temps_div')
            		</div>
            	</div>
        	</div>

		</div>
	</div>
	</div>
	</div>
	</div>
</div>

<div style="clear:both"></div>
<div class="container">
<div class="row">
	<div class="col-lg-12">
		<div class="col-lg-3 no-pad">
		<div class="panel panel-default">
    	<div class="panel-heading">Search by date range</div>
		<div class="panel-body">
			<form class="form-vertical" role="form" method="post" action="/wifiShield/search/">

			<div class="form-group">
				<label for="from_date" class="control-label">Start date</label>
				<input type="date" name="from_date" class="form-control" id="from_date" value="{{ Request::old('from_date')? :''}}" placeholder="From Date">
			</div>
			<div class="form-group">
				<label for="to_date" class="control-label">End date</label> 
				<input type="date" name="to_date" class="form-control" id="to_date" value="{{ Request::old('to_date')? :''}}" placeholder="To Date">
			</div>
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
			<div>
				<button type="submit" class="btn btn-default search-btn">Search</button>
			</div>

			</form>
		</div>
		</div>
		</div>

		<div class="col-lg-1 no-pad"></div>
		<div class="col-lg-2 no-pad">
			<div class="panel panel-default">
	        <div class="panel-heading">Todays Average Voltage</div>
			<div class="panel-body">
				<h4>{!!$data['voltage']!!}</h4>
			</div>
			</div>
			<div class="panel panel-default">
	        <div class="panel-heading">Todays Average Current</div>
			<div class="panel-body">
				<h4>{!!$data['current']!!}</h4>
			</div>
			</div>
			<div class="panel panel-default">
	        <div class="panel-heading">Todays Average Power</div>
			<div class="panel-body">
				<h4>{!!$data['power']!!}</h4>
			</div>
			</div>
		</div>

		<div class="col-lg-1 no-pad"></div>

		<div class="col-lg-5 no-pad">
			<div class="panel panel-default">
	        <div class="panel-heading">Select Device</div>
			<div class="panel-body no-pad">
                <table>
					@foreach($macAddress as $macAddres)
					<tr>
						<form class="form-vertical no-pad" role="form" method="get" action="/wifiShield/newRoute/{!!$macAddres->device_name!!}">
							<button type="submit" class="btn btn-default device-btn">{!!$macAddres->device_name!!}</button>
						</form>
					
					</tr>
					@endforeach
					
				</table>
	        </div>
			</div>
		</div>
	</div>
</div>
</div>

<div style="clear:both"></div>


@stop