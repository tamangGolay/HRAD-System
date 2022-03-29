<!-- Brand Logo -->
<!-- Sidebar -->@guest @else
<aside class="main-sidebar elevation-4 border-left" id="sidebar" style="background-color:#FFFF;">
	<div>
		<a href="{{url('/home')}}" class="brand-link"> <img src="{{asset('/logo.png')}}" alt="BPC Logo" class="brand-image img-circle elevation-3" style="height:50px;width:40px; opacity: .8"> <span class="brand-text font-weight-dark center text-dark"><strong>BPC System</strong></span> </a>
	</div>
	<!-- Sidebar Menu -->
	<div class="sidebar">
		<!-- Agency Head -->
		<nav class="mt-2" style="background-color:#FFFF;">
			<div class="dropdown-divider"></div>
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
				<!-- FR Deployment -->
				<li class="nav-item has-treeview menu-open">
					<a href="" class="nav-link text-dark" data-value="none"> <i class="nav-icon fas fa-folder-plus"></i>
						<p><strong>Dashboard</strong> <i class="fas fa-angle-left right"></i> </p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item"><a href="/home" class="nav-link text-secondary"><i class="fa fa-list-ol" aria-hidden="true"></i>&nbsp;&nbsp;<p>Dashboard</p></a></li>
					</ul>
				</li>
				<div class="dropdown-divider"></div>
				<li class="nav-item has-treeview menu-open">
					<a href="" class="nav-link text-dark" data-value="none"> <i class="nav-icon fas fa-folder-plus"></i>
						<p><strong>Manage</strong> <i class="fas fa-angle-left right"></i> </p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item"><a href="/conference_manage" class="nav-link text-secondary"><i class="fa fa-list-ol" aria-hidden="true"></i>&nbsp;&nbsp;<p>Conference</p></a></li>
					</ul>
					<ul class="nav nav-treeview">
						<li class="nav-item"><a href="/role_manage" class="nav-link text-secondary"><i class="fa fa-list-ol" aria-hidden="true"></i>&nbsp;&nbsp;<p>Role</p></a></li>
					</ul>
				</li>
			</ul>
		</nav>
	</div>
	<!-- sidebar -->
</aside>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
</script> @endguest