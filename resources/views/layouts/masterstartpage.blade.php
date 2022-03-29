<!DOCTYPE html>
<html>
@include('layouts.head')
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div class="wrapper">
 

  <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <section class="content-header" style="background-color:dark">
      @yield('pagehead')
    </section>    
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" style="background-color:#F3F3F1;">
      @yield('content')
    </section>
    <!-- /.content -->



            

            @yield('scripts')
@include('layouts.scripts')


</body>
</html>
