<! DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE = edge">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">

<style>
    table, th, td {
        border: 1px solid black;
    }
    th, td {
        border-color: #96D4D4;
    }
  </style>
<!-- </head> -->

<body>
    <div class = "container">
        <div class = "row">
            <div class = "col">
                <div class="card ">
                    <div class="card-header bg-green">
                        <div class="col text-center">
                        <h5>
                            <b> Notesheet Report</b>
                        </h5>
			            </div>
                    </div>
                <br>
                <div class = "row">
                    <div class = "col-md-12">
                        <div class="card-body table-responsive p-0">
					        <table id="table5" class="table table-hover table-striped table-bordered">
                               <thead>
                                <tr class="text-nowrap">
                                    <th scope = "col" class="col1"> Sl.No </th>
                                   
                                    <th scope = "col" class="col1"> EmployeeId</th>
                                    <th scope = "col" class="col1"> Employee Name</th>
                                    <th scope = "col" class="col1"> Office </th>
                                    <th scope = "col" class="col2"> Topic </th>
                                    <th scope = "col" class="col2"> Download </th>

                                </tr>
                               </thead>
                               <tbody>
                                @foreach ($notesheet as $nt)
                                <tr>
                                    <td class="col1"> {{$nt->noteId}} </td>
                                    <td class="col1"> {{$nt-> createdBy}} </td>
                                    <td class="col1"> {{$nt-> empName}} </td>
                                    <td class="col1"> {{$nt-> longOfficeName}} </td>
                                    <td class="col1"> {{$nt-> topic}} </td>
                                    <td class="col2"><a href="notesheetReport/{{$nt->noteId}}" class="btn btn-success">Download</a> </td>
                                </tr>
                                @endforeach
                               </tbody>
                            </table>
                        </div>
                        <div class="float-right">
                     {{$notesheet->links()}}
                 </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
          

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
		<script src="{{asset('/admin-lte/datatables/dataTables.buttons.min.js')}}"></script>
		<script src="{{asset('/admin-lte/datatables/buttons.html5.min.js')}}"></script>
		<script src="{{asset('/admin-lte/datatables/buttons.print.min.js')}}"></script>
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
				"dom": 'Blfrtip',
				"responsive": true,
				"lengthChange": true,
				"searching": true,
				"ordering": false,
				"info": true,
				"autoWidth": false,
				"paging": true,
				"retrieve":true,                
                lengthMenu: [[10, 50, 100, 250, -1], [10, 50,100, 250, "All"]],
				buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5']
			});
		});
	
</script>