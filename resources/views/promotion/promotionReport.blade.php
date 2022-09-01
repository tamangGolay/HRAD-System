<! DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE = edge">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
    <title> Promotion Order </title>
    <! - Bootstrap5 CSS ->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

   <style>
    a {
        color: black !important;
        text-decoration: none;
    }
    
    
 
    .alert-success {
      color: #fff !important;
        background-color: #28a745 !important;
        border-color: #28a745 !important;
}
   table, th, td {
  border: 1px solid black;
}
 th, td {
  border-color: #96D4D4;
  
}
/*
.col1{
   width:100px;
}
.col2{
   width:500px;
}
h1 {
 color: #1a3300;
}; */
   </style>
</head>
<body>
    <div class = "container ">
    <div class = "row">
        <div class="col">
        <div class = "card">
        <div class="card-header bg-green">
        <div class="col text-center">
          <h5>
                <b> Promotion Order</b>
              </h5>
			</div>		
        </div>
          
            <br>

            
            <div class = "col-md-12">
            <div class="card-body table-responsive p-0">
					<table id="table5" class="table table-hover table-striped table-bordered">
                <!-- <table class = "table"> -->
                    <!-- <h2 class="headnote"> NoteSheet  </h2> -->
                    <thead>
                      <tr class="text-nowrap">
                        <th scope = "col" class="col1"> SN </th>
                        <th scope = "col" class="col1"> EmployeeId</th>
                        <th scope = "col" class="col1"> Employee Name</th>
                        <th scope = "col" class="col1"> Office </th>
                        <th scope = "col" class="col2"> Download </th>

                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($promotion as $promotion)

                        <tr>
                            <td class="col1"> {{$promotion->id}} </td>
                           <td class="col1"> {{$promotion-> empId}} </td>
                           <td class="col1"> {{$promotion-> empName}} </td>
                            <td class="col1"> {{$promotion->officeName}} </td>
                            <td class="col2"><a href="promotionReport/{{$promotion->id}}" class="btn btn-success">Download</a> </td>
                        </tr>
                    @endforeach

                    </tbody>
                  </table>
            </div>
            </div>
        </div>
    </div>
</div> </div>
        
            
    <script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
    <script src = "https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity = "sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KinkN" crossorigin="anonymous"></script>
   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <script src = "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"> </script>
   
    <!-- jquery-validation -->
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
		<!-- <script src="{{asset('/admin-lte/datatables/dataTables.buttons.min.js')}}"></script>
		<script src="{{asset('/admin-lte/datatables/buttons.html5.min.js')}}"></script>
		<script src="{{asset('/admin-lte/datatables/buttons.print.min.js')}}"></script> -->
		<!-- <script src="{{asset('/admin-lte/datatables/buttons.flash.min.js')}}"></script> -->
		<script src="{{asset('/admin-lte/datatables/jszip.min.js')}}"></script>
		<!-- <script src="{{asset('/admin-lte/datatables/pdfmake.min.js')}}"></script> -->
		<script src="{{asset('/admin-lte/datatables/vfs_fonts.js')}}"></script>
		<!-- checkin form -->

		
		<link href="{{asset('css/bose.css')}}" rel="stylesheet"> 
		<!-- called in bose.css -->

		<script>
	
		$(function() {
			$("#table5").DataTable({
				"dom": 'Bfrtip',
				"responsive": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": false,
				"paging": true,
				"retrieve":true,
				
			});
		});
// buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5']
		</script>
</body>
</html>