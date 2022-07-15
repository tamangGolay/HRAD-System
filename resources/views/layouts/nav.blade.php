<style>
	a:hover{
		color: black;
	}
</style>
<nav class="main-header navbar navbar-expand  bg-white">
	<div class="container"> @guest
		<ul class="navbar-nav">
			<li class="nav-item"> <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a> </li>
		</ul> @else
		<div class="collapse navbar-collapse order-3" id="navbarCollapse">
			<!-- <ul class="navbar-nav">
				<li class="nav-item"> <a class="nav-link" data-value="none" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> </li>
			</ul> -->
			<div id="hshadow">
				<h3 style="font-weight:700;color:black;">BPC Online System</h3> </div>
			<!-- Right Side Of Navbar -->
			<ul class="navbar-nav navbar-no-expand ml-auto col-sm-4 col-lg-3">
				<!-- Authentication Links -->
				<li class="nav-item dropdown">
					<a class="nav-link" data-value="none" data-toggle="dropdown" href="#"> <i class="fas fa-user"></i>&nbsp;
						<?php $roles = Auth::user()->role; ?> {{ Auth::user()->empName }} <i class="fas fa-angle-down"></i> </a>
					<div class="dropdown-menu dropdown-menu-right"> <a class="dropdown-item nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a> </div>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;"> @csrf </form>
				</li>
			</ul>
		</div> @endguest </div>
</nav>