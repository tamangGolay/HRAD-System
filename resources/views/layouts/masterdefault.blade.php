<!DOCTYPE html>
<html>
@include('layouts.head')
<style>
a {
  color: black;
  text-decoration: none; /* no underline */
}

#loginid {
color:black;
border:1px solid grey;
border-radius:40px 10px 10px 30px;
transform:all 2ms;
}

#loginid:hover {
    color:#222222;
    font-weight:400;
    background-color:#EAB57F;
    border:2px solid dark;
    border-radius:40px 10px 10px 30px;;
}

</style>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="container-fluid">
  <!-- Navbar -->
    <div class="container">
       

      
     </div>
</div>
  <!-- Content Wrapper. Contains page content -->
<div class="content">
    <!-- Content Header (Page header) -->    
    <!-- /.content-header -->    
    <!-- Main content -->
    <section class="content">
      @yield('content')
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->

<!-- ./wrapper -->
</body>
</html>
