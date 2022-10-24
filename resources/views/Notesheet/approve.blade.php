<style>
.topic{
  background-color:#2c9e41;
  color: black;
} 
.back{
  color:black;
}

</style>
 <link href="{{asset('css/bose.css')}}" rel="stylesheet">
<!-- called in bose.css -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->

<div class="container">
<div class="row">
  <div class="col">
    <div class="card">
      <div class="topic bg-green">
        <br>
        <div class="col text-center">
          <h5>
                <b> Remarks From Supervisor(s) </b>
              
              </h5>
			</div>
		<br>
      </div>
      <div>
      
      </div>

      <div class="card-body table-responsive">
      <a href="/home" text-left"><i class="fa fa-arrow-left fa-lg back"></i> <span class="back">Home</span></a>  <br>
      <table id="example1" class=" table data-table table-hover table-striped  table-bordered" style="width:100%">
          <thead>
            <tr>
          <th>Notesheet Id</th>
              <th>Name</th>
              <th>Remarks</th> 
            </tr>
            </thead>

						<tbody>
              @foreach($notesheetRemarks as $rv)
              <tr>
                <td>{{$rv->noteId}}</td>
                <td>{{$rv->modifier}}</td>
                <td>{{$rv->remarks}}</td>
              </tr>@endforeach
            </tbody>  
          </table>
    
      </div>
      
    </div>
  </div>
</div>
</div>

  <script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
    
   <script src="{{asset('/admin-lte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('/admin-lte/plugins/jquery-validation/additional-methods.min.js')}}"></script>
    <!-- DataTables -->
    <script src="{{URL::asset('/admin-lte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <!-- Script for export file from datatable -->
    <script src="{{asset('/admin-lte/datatables/nima.js')}}"></script>
    <script src="{{asset('/admin-lte/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/admin-lte/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('/admin-lte/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{asset('/admin-lte/datatables/buttons.print.min.js')}}"></script>
    <!-- <script src="{{asset('/admin-lte/datatables/buttons.flash.min.js')}}"></script> -->
    <script src="{{asset('/admin-lte/datatables/jszip.min.js')}}"></script>
    <!-- <script src="{{asset('/admin-lte/datatables/pdfmake.min.js')}}"></script> -->
    <script src="{{asset('/admin-lte/datatables/vfs_fonts.js')}}"></script>
    <!-- checkin form -->



    <script>
    $(function() {
      $("#example1").DataTable({
        "dom": 'Bfrtip',
        "responsive": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "paging": true,
        "retrieve":true,
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5']
      });
    });
    </script>

 <!-- <script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>  -->
    <script type="text/javascript">
    $(document).ready(function() {
      document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
    });
    </script>





