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
		
			<iframe src="http://111.68.98.142:5601/app/kibana#/visualize/create?embed=true&type=histogram&indexPattern=wifishield&_g=(refreshInterval:(display:Off,pause:!f,value:0),time:(from:now-15m,mode:quick,to:now))&_a=(filters:!(),linked:!f,query:(query_string:(analyze_wildcard:!t,query:'date:%5B%22{{$from_date}}%22%20TO%20%22{{$to_date}}%22%5D,mac_address:%22{{$mac_address->mac_address}}%22')),uiState:(),vis:(aggs:!((id:'1',params:(customLabel:Voltage,field:voltage),schema:metric,type:avg),(id:'2',params:(customLabel:Power,field:power),schema:metric,type:avg),(id:'3',params:(customLabel:Current,field:current),schema:metric,type:avg),(id:'4',params:(customInterval:'2h',customLabel:Date,extended_bounds:(),field:date,interval:d,min_doc_count:1),schema:segment,type:date_histogram)),listeners:(),params:(addLegend:!t,addTimeMarker:!f,addTooltip:!t,defaultYExtents:!f,mode:grouped,scale:linear,setYExtents:!f,shareYAxis:!t,times:!(),yAxis:()),title:'New%20Visualization',type:histogram))" height="600" width=""></iframe>

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
				<div class="form-group">
								<label for="from_date" class="control-label">From</label>
								<input type="text" name="from_date" class="form-control" id="from_date" value="{{ Request::old('from_date')? :''}}">
				</div>

				<div>
						<p>YYYY-MM-DD</p>
				</div>

				<div>
					<button type="submit" class="btn btn-default">Search</button>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="form-group">
								<label for="to_date" class="control-label">To</label>
								<input type="text" name="to_date" class="form-control" id="to_date" value="{{ Request::old('to_date')? :''}}">
				</div>

				<div>
						<p>YYYY-MM-DD</p>
				</div>

			</div>
			<div class="col-lg-6">
				<div class="form-group">
								<label for="find_device" class="control-label">Device</label>
								<input type="text" name="find_device" class="form-control" id="find_device" value="{{ Request::old('find_device')? :''}}">
				</div>
				<div>
						<p>Name of your device</p>
				</div>

			</div>
			
	</form>
	
	</div>
</div>

@stop