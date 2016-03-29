<nav class="navbar navbar-default" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">A P P L I C A T I O N</a>
		</div>
		<div class="collapse navbar-collapse">
			@if (Auth::Check())
				<!--<ul class="nav navbar-nav">
					<li><a href="#">Timeline</a></li>
					<li><a href="#">Friends</a></li>
				</ul>
				<form class="navbar-form navbar-left" role="search" action="#">
					<div class="form-group">
						<input type="text" name="querry" class="form-control" placeholder="Find people">
					</div>
					<button type="submit" class="btn btn-default">Search</button>
				</form>-->
			@endif
				<ul class="nav navbar-nav navbar-right">
					@if(Auth::Check())
						<li><a href="{{ route('newdashBoard') }}">{{Auth::user()->getnameOrUsername()}}</a></li>
						<li><a href="{{ route('add.device') }}">Add new device</a></li>
						<li><a href="{{ route('signout') }}">Sign out</a></li>
					@else
						<li><a href="{{ route('auth.signup') }}">Sign up</a></li>
						<li><a href="{{ route('auth.signin') }}">Sign in</a></li>
					@endif
				</ul>
			</div>
		</div>
	</div>
</nav>