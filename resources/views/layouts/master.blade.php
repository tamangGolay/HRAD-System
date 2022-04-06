<!DOCTYPE html>
<html> @include('layouts.head')

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
	<div class="wrapper">
		<!-- Navbar -->@include('layouts.nav')
		<!-- /.navbar -->
		<!-- Main Sidebar Container -->
	
			<!-- Brand Logo --> </aside>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper" style="background-color:white;">
			<!-- Content Header (Page header) -->
			<section class="content-header" style="background-color:white;"> @yield('pagehead') </section>
			<!-- /.content-header -->
			<!-- Main content -->
			<section class="content" style="background-color:white;"> @yield('content') </section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->@include('layouts.footer')
		<!-- Control Sidebar -->
		<!-- <aside class="control-sidebar control-sidebar-dark"> -->
		<!-- Control sidebar content goes here -->
		<!-- </aside> -->
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->@include('layouts.scripts') </body>

</html>
