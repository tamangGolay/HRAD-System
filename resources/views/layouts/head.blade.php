<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
	<meta name="description" content="Bpc Online System">
	<meta name="author" content="ITD, Bhutan Power Corporation Limited">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>BPC Online System - @yield('title')</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{asset('admin-lte/plugins/fontawesome-free/css/all.min.css')}}">
	<!-- Ionicons -->
	<!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
	<!-- Tempusdominus Bbootstrap 4 -->
	<link rel="stylesheet" href="{{asset('admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
	<!-- iCheck -->
	<link rel="stylesheet" href="{{asset('admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
	<!-- JQVMap -->
	<!-- <link rel="stylesheet" href="{{asset("admin-lte/plugins/jqvmap/jqvmap.min.css")}}"> -->
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('admin-lte/dist/css/adminlte.min.css')}}">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="{{asset('admin-lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
	<!-- summernote -->
	<link rel="stylesheet" href="{{asset('admin-lte/plugins/summernote/summernote-bs4.css')}}">
	<!-- Google Font: Source Sans Pro -->
	<link href="{{URL::asset('admin-lte/plugins/googlefont/dashboard.css')}}" rel="stylesheet">
	<!-- DataTables -->
	<link rel="stylesheet" href="{{URL::asset('admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{URL::asset('admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{URL::asset('admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{URL::asset('admin-lte/plugins/datatables-buttons/css/jquery.dataTables.min.css')}}">
	<!-- Select2 -->
	<link rel="stylesheet" href="{{URL::asset('admin-lte/plugins/select2/css/select2.min.css')}}">
	<link rel="stylesheet" href="{{URL::asset('admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
	<!-- Google Font: Source Sans Pro -->
	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
	<!-- CodeMirror -->
	<link rel="stylesheet" href="{{URL::asset('admin-lte/plugins/codemirror/codemirror.css')}}">
	<link rel="stylesheet" href="{{URL::asset('admin-lte/plugins/codemirror/theme/monokai.css')}}">
	<!-- SimpleMDE -->
	<link rel="stylesheet" href="{{URL::asset('admin-lte/plugins/simplemde/simplemde.css')}}">
	
	<style>
	img {
		border-radius: 50%;
	}
	
	.bg-card-header {
		/* background-color:#aa9911; */
		background-color: #bce556;
		opacity: 0.8;
		font-weight: 600;
	}
	
	.spaceven {
		justify-content: space-evenly;
	}
	</style>


</head>

