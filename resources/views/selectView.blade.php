@extends('templates.default')

@section('content')

	<h3>Select View View view</h3>
	<div class="row">
	<div class="col-lg-6">
		<form class="form-vertical" role="form" method="post" action="{{ route('auth.signin') }}">
			
			<div class="form-group{{ $errors->has('city') ? ' has-error' : ''}} ">
					<label for="city" class="control-label">City</label>
					<input type="text" name="city" class="form-control" id="city" value="{{ Request::old('city')? :''}}">
					
					@if ($errors->has('city'))
						<span class="help-block">{{ $errors->first('city')}}</span>
					@endif
			</div>

			<div class="form-group{{ $errors->has('password') ? ' has-error' : ''}}">
				<label for="password" class="control-label">Password</label>
				<input type="password" name="password" class="form-control" id="password" value="">
				
				@if ($errors->has('password'))
					<span class="help-block">{{ $errors->first('password')}}</span>s
				@endif

			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="remember"> Remember me
				</label>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-default">Sign in</button>
			</div>
			<a href="{{ route('auth.forgot') }}"> Forgot Password</a>
			

			<input type="hidden" name="_token" value="{{ Session::token() }}"> 
		</form>
	</div>
	</div>

@stop