<nav class="navbar navbar-default" role="navigation">
	<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="{{ route('data') }}">Energy Monitoring and Control System</a>
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

					<li>
						<div class="dropdown">
						  <button class="dropbtn">Select Device</button>
						  <div class="dropdown-content">
						  @if ($macAddress)
							  @foreach($macAddress as $macAddres)
							  <a href="/wifiShield/newRoute/{!!$macAddres->device_name!!}">{!!$macAddres->device_name!!}</a>
							  @endforeach
						  @endif

						  </div>
					</div>
					</li>

					<li><div class="dropdown">
						  <button class="dropbtn">Device</button>
						  <div class="dropdown-content">
							  <a href="{{ route('add.device') }}">Add Device</a>
							  <a href="{{ route('remove.device') }}">Remove Device</a>
							  <a href="{{ route('turn.device') }}">Turn ON/OFF</a>
							</div>
					</div></li>
					<li><a href="{{ route('signout') }}">Sign out</a></li>
				@else
					<li><a href="{{ route('auth.signup') }}">Sign up</a></li>
					<li><a href="{{ route('auth.signin') }}">Sign in</a></li>
				@endif
			</ul>
		</div>
	</div>
</nav>