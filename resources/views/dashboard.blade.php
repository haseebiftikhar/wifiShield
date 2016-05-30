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
					<button type="submit" class="btn btn-default select-btn" style="border: 2px solid #48C9B0">ALL</button>
					</form>
				</td>
				@foreach($macAddress as $macAddres)
				@if($flag == 5)
				<?php $flag = 0; ?>
				<tr></tr>
					<td>
					
						<form class="form-vertical no-pad" role="form" method="get" action="/wifiShield/newRoute/{!!$macAddres->device_name!!}">
						<button type="submit" class="btn btn-default select-btn" <?php if($macAddres->status){ echo 'style="border: 2px solid #00BE42;"';} ?>>{!!$macAddres->device_name!!}</button>
						</form>
					
					</td>
				@else
				<?php $flag = $flag+1; ?>
					<td>
					<form class="form-vertical no-pad" role="form" method="get" action="/wifiShield/newRoute/{!!$macAddres->device_name!!}">
					<button type="submit" class="btn btn-default select-btn" <?php if($macAddres->status){ echo 'style="border: 2px solid #00BE42;"';} ?>>{!!$macAddres->device_name!!}</button>
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
		<div id="myfirstchart" style="height: 250px;"></div>
	<!--			
			<div id="temps_div">
				<div style="position: relative;">
        			<div dir="Temps" style="position: relative; width: 135px; height: 600px;">
        				{!! \Lava::render('LineChart', 'Temps', 'temps_div') !!}
            			@linechart('Temps', 'temps_div') 
            		</div>
            	</div>
        	</div> -->

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
			<form class="form-vertical" role="form" method="post" action="/wifiShield/getdata/">

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
		<div class="col-lg-3 no-pad">
			<div class="panel panel-default">
	        <div class="panel-heading">Todays Average Voltage</div>
			<div class="panel-body">
				<h3 style="color:blue; text-align:center;">{!!$data['voltage']!!} V</h3>
			</div>
			</div>
			<div class="panel panel-default">
	        <div class="panel-heading">Todays Average Current</div>
			<div class="panel-body">
				<h3 style="color:red; text-align:center;">{!!$data['current']!!} A</h3>
			</div>
			</div>
			<div class="panel panel-default">
	        <div class="panel-heading">Todays Average Power</div>
			<div class="panel-body">
				<h3 style="color:orange; text-align:center;">{!!$data['power']!!} W</h3>
			</div>
			</div>
		</div>

		<div class="col-lg-1 no-pad"></div>

		<div class="col-lg-4 no-pad">
			<div class="panel panel-default">
	        <div class="panel-heading">Display Statics</div>
			<div class="panel-body no-pad">
                <table>
					  <tr>
					    <th>Status</th>
					    <th>Data</th>
					  </tr>
						<tr class="tr-hover">
						<td><input id="toggle-voltage" class="toggle-valueOnOff toggle-checkit" checked='checked'  type="checkbox" data-value="voltage" data-toggle="toggle">
						</td>	
						<td>
							<h4>Voltage</h4>
							<div id="console-event"></div>
						</td>
						</tr>

						<tr class="tr-hover">
						<td><input id="toggle-current" class="toggle-valueOnOff toggle-checkit" checked='checked'  type="checkbox" data-value="current" data-toggle="toggle">
						</td>	
						<td>
							<h4>Current</h4>
							<div id="console-event"></div>
						</td>
						</tr>

						<tr class="tr-hover">
						<td><input id="toggle-power" class="toggle-valueOnOff toggle-checkit" checked='checked' type="checkbox" data-value="power" data-toggle="toggle">
						</td>	
						<td>
							<h4>Power</h4>
							<div id="console-event"></div>
						</td>
						</tr>
					</table>
	        </div>
			</div>
		</div>
	</div>
</div>
</div>

<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script>
    $(function() {
    $('.toggle-valueOnOff').on('change',function() {
    	var value = $(this).attr('data-value');
      	var data = $(this).prop('checked');
      	var formdata = 'value='+value+'&status='+data;
      	console.log('DATA'+data+'...'+value);
      	//$.ajax({
      	//	type: "POST",
         //   url: "/wifiShield/vlotage",
         //   data: formdata,
         //   success: function(html) {
           	//console.log(html);
        // 	}
       // });
	    });

    var chart = new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'myfirstchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [{"date":"0","voltage":0,"current":0,"power":0}],

  // The name of the data record attribute that contains x-values.
  xkey: 'date',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['voltage','current','power'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Avg Voltage','Avg Current','Avg Power'],
  resize: 'true'

});
   $.ajax({
      	type: "GET",
      	dataType: 'json',
     	url: "http://127.0.0.1:149/wifiShield/getdata",
     	data: 'voltage=on&power=on&current=on',
   })
    .done(function( data ) {
      // When the response to the AJAX request comes back render the chart with new data
      chart.setData(data);
    })
   .fail(function() {
      // If there is no communication between the server, show an error
      alert( "error occured" );
    });

   	$('.toggle-checkit').on('change',function(){
   		var current = $('#toggle-current').prop('checked');
   		var power = $('#toggle-power').prop('checked');
   		var voltage = $('#toggle-voltage').prop('checked');
   		if(current){
   			var currentvalue = 'on';
   		}else{
   			var currentvalue = 'off';
   		}
   		if(power){
   			var powervalue = 'on';
   		}else{
   			var powervalue = 'off';
   		}
   		if(voltage){
   			var voltagevalue = 'on';
   		}else{
   			var voltagevalue = 'off';
   		}

   			$.ajax({
		      	type: "GET",
		      	dataType: 'json',
		     	url: "/wifiShield/getdata",
		     	data: 'voltage='+voltagevalue+'&power='+powervalue+'&current='+currentvalue,
		   })
		    .done(function( data ) {
		      // When the response to the AJAX request comes back render the chart with new data
		      chart.setData(data);
		    });
	});
	})

</script>

@stop