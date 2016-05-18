@extends('templates.default')

@section('content')

	@if ($session->has('info'))
		<div class="alert alert-info" role="alert">
			{{ $session->remove('info') }}
		</div>
	@endif


	<h3>Turn Your Device ON/OFF</h3>
	<p>Select your device carefully, it may take few minutes!!.</p>

@if ($macAddress)
<table>
  <col width="80">
  <col width="160">
  <tr>
    <th>Status</th>
    <th>Device name</th>
  </tr>
	@foreach($macAddress as $macAddres)
	<tr class="tr-hover">
	<td><input class="toggle-eventOnOff"  type="checkbox" data-value="{!!$macAddres->device_name!!}" data-toggle="toggle" 
		<?php if($macAddres->status){ echo 'checked="checked"';} ?> data-onstyle="success" data-offstyle="danger">
	</td>	
	<td>
		<h4>{!!$macAddres->device_name!!}</h4>
		<div id="console-event"></div>
	</td>
	</tr>
	@endforeach
</table>
@endif
<h1> </h1>
<div>
<a href="/wifiShield/data"><button class="button button2">Go Back</button>
</div>
<!--<div class="row">
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

</div>-->
<script>
    $(function() {
    $('.toggle-eventOnOff').on('change',function() {
    	var tdevice = $(this).attr('data-value');
      	var data = $(this).prop('checked');
      	var formdata = 'tdevice='+tdevice+'&status='+data;
      	console.log('DATA'+data+'...'+tdevice);
      	$.ajax({
      		type: "POST",
            url: "/wifiShield/status",
            data: formdata,
            success: function(html) {
           	//console.log(html);
         	}
        });
	    })
	})
</script>

@stop