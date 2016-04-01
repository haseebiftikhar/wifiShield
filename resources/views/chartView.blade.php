@extends('templates.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		<div class="col-lg-3">
			<form class="form-vertical" role="form" method="post" action="#">
				<div class="form-group{{ $errors->has('city') ? ' has-error' : ''}} ">
					<label for="city" class="control-label">City</label>
					<input type="text" name="city" class="form-control" id="city" value="{{ Request::old('city')? :''}}">
					
					@if ($errors->has('city'))
						<span class="help-block">{{ $errors->first('city')}}</span>
					@endif
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-default">Submit</button>
				</div>
			</form>
		</div>
		<div style="clear:both"></div>
			<div id="chart-div">
				<div class="col-lg-6">

					@linechart('Temps', 'chart-div')
				</div>
			</div>
		<div class="col-lg-3"></div>
	</div>
</div>


	
@stop