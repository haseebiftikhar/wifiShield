
@extends('templates.default')

@section('content')
@if ($session->has('info'))
				<div class="alert alert-info" role="alert">
					{{ $session->remove('info') }}
				</div>
@endif
	<h3>Add New Password</h3>
	<div class="row">
	<div class="col-lg-6">
		<form class="form-vertical" role="form" method="post" action="{{ route('reset') }}">
			<div class="form-group{{ $errors->has('password1') ? ' has-error' : ''}}">
				<label for="password" class="control-label">Enter password</label>
				<input type="password" name="password1" class="form-control" id="password1" value="">
				
				@if ($errors->has('password1'))
					<span class="help-block">{{ $errors->first('password1')}}</span>
				@endif

			</div>
			<div class="form-group{{ $errors->has('password2') ? ' has-error' : ''}}">
				<label for="password" class="control-label">Re Enter password</label>
				<input type="password" name="password2" class="form-control" id="password2" value="">
				
				@if ($errors->has('password2'))
					<span class="help-block">{{ $errors->first('password2')}}</span>
				@endif

			</div>
			
			
			<div class="form-group">
				<button type="submit" class="btn btn-default">Submit</button>
			</div>
			
			<input type="hidden" name="_token" value="{{ Session::token() }}"> 
		</form>

	</div>
	</div>
@stop