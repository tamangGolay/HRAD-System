<!DOCTYPE html>
<html> @include('layouts.head')
<style>
a {
	color: black;
	text-decoration: none;
	/* no underline */
}

#loginid {
	color: black;
	background-color: #ddffaa;
	border: 1px solid dark;
	border-radius: 40px 10px 10px 30px;
	transform: all 2ms;
}

#loginid:hover {
	color: white;
	font-weight: 400;
	background-color: #aaee66;
	border: 2px solid grey;
	border-radius: 40px 10px 10px 30px;
	;
}
</style>

<body class="hold-transition sidebar-mini sidebar-collapse">
	<div class="container-fluid">
		<!-- Navbar -->
	</div>
	<!-- Content Wrapper. Contains page content -->
	<div class="content">
		<!-- Content Header (Page header) -->
		<!-- /.content-header -->
		<!-- Main content -->
		<section class="content"> @yield('content') </section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<!-- ./wrapper -->
</body>

</html>