<! DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE = edge">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
    <title> Increment Report </title>
    <! - Bootstrap5 CSS ->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

   <style>
   table, th, td {
  border: 1px solid black;
}
 th, td {
  border-color: #96D4D4;
 
}
/* .col1{
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
    <div class = "container">
            <div class = "row">
            <div class = "col">
            <div class="card ">
         <div class="card-header bg-green">
        <div class="col text-center">
          <h5>
                <b> Incrment Order</b>
              </h5>
			</div>
		
</div>
      <br>

                <div class = "col-md-12">
                    <div class="card-body table-responsive p-0">
					    <table id="table5" class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">SN</th>
                            <th scope="col">Name(Employee ID)</th>
                            <th scope="col">Designation(Grade)</th>
                            <th scope="col">Old Basic</th>
                            <!-- <th scope="col">Increment</th> -->
                            <th scope="col">New Basic</th>
                            <th scope="col">Office Address</th>
                            <th scope="col">Action 
                            <!-- <input type="checkbox" name="main_checkbox" id="checkbox"class=""><label></label> -->
                            <!-- <button class="btn btn-sm btn-success d-none" id=deleteAllBtn>Generate Increment Order</button> -->
                            </th>
                            </tr>
                        </thead>
                    <tbody>
                    @foreach ($increment as $increment)

                        <tr>
                            <td class="col1"> {{$increment->id}} </td>
                           <!-- <td class="col1"> {{$increment-> empId }} </td> -->

                           <td class="col1"> {{$increment-> empName }} ({{$increment->empId}}) </td>
                            <td class="col1"> {{$increment-> designation }} ({{$increment->grade}}) </td>                     
                            <td class="col1"> {{$increment-> oldBasic}} </td>                           
                            <td class="col1"> {{$increment-> newBasic}} </td>
                            <td class="col1"> {{$increment-> officeDetails}} </td>
                            <td class="col2">
                                 <a href="incrementReport/{{$increment->id}}" class="btn btn-success">Download</a> 
                                 
                                </td>



                        </tr>
                    @endforeach


                    </tbody>
                  </table>
            </div>
            </div>
</div>
</div>
        </div>
    </div>

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