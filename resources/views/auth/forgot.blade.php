@extends('templates.default')

@section('content')

@if ($session->has('info'))
				<div class="alert alert-info" role="alert">
					{{ $session->remove('info') }}
				</div>
@endif

	<h3>Password Reset Wizard</h3>
	<p>Enter your valid email</p>
<div class="row">
	<div class="col-lg-6">
		<form class="form-vertical" role="form" method="post" action="{{ route('auth.forgot') }}">
			<div class="form-group{{ $errors->has('email') ? ' has-error' : ''}} ">
					<label for="email" class="control-label">Email</label>
					<input type="text" name="email" class="form-control" id="email" value="{{ Request::old('email')? :''}}">
					
					@if ($errors->has('email'))
						<span class="help-block">{{ $errors->first('email')}}</span>
					@endif

				</div>
			<div>
				<button type="submit" class="btn btn-default">Submit</button>
			</div>
		</form>

	</div>
<div>

@stop