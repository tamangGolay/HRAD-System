<style>
 
.button1 {
	margin-left: 25%;
}

.button2 {
	position:absolute;
	margin-left: 0.5%;
	margin-top:0.5%;
}  

/* 
button{
	position:absolute;
} */
</style>
<div class="row ">
	<div class="col">
		<div class="card ">
			<div class="card-header bg-green">
				<div class="col text-center">
					<h5>
                <b>Reports</b>
              </h5> </div>
			</div>

			<form method="POST" action="/date_search" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
				<br>

			<div class="container">
				<div class="row">
					<div class="container-fluid">
						<div class="form-group row">
							<label for="date" class="col-form-label col-sm-4">Start Date</label>
						<div class="col-sm-3">
							<input type="date" class="form-control" id="fromdate" name="fromdate" required/>
						</div>

						<label for="date" class="col-form-label col-sm-4">End Date</label>
						<div class="col-sm-3">
							<input type="date" class="form-control" id="todate" name="todate" required/>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn-info"  name="search">search</div>
						</div>
					
					</div>
				</div>
			</div>

</form>




			<!--/card-header-->
			<form method="POST" action="/date_search" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
				<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
				<div class="card-body table-responsive p-0">
					<table id="table1" class="table table-hover table-striped table-bordered">
						<thead>
							<tr class="text-nowrap">
								<th>Emp Id</th>
								<th>Wing/Dept/Div</th>
								<th>Name</th>
								<th>Date of Requisition</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>Vehicle Name</th>
								<th>Purpose</th>
								<th>Places to Visit</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody> @foreach($reports as $rv)
							<tr>
								<td> {{$rv->emp_id}} </td>
								<td> {{$rv->description}} </td>
								<td> {{$rv->vname}} </td>
								<td class="text-nowrap"> {{$rv->dateOfRequisition}} </td>
								<td class="text-nowrap"> {{$rv->start_date}} </td>
								<td class="text-nowrap"> {{$rv->end_date}} </td>
								<td> {{$rv->vehicle_name}} </td>
								<td> {{$rv->purpose}} </td>
								<td> {{$rv->placesToVisit}} </td>


								<td>
									
									@if($rv->status == '4')

									Approved

									@if($rv->status == '5')

									Approved

									@elseif($rv->status == '3')

									rejected

									@endif									
								</td>
								
			                </tr> @endforeach 
                        </tbody>
			</table>
			<div class="float-right"> {{$reports->links()}} </div>
			<div>
				<!--/card-body-->
			</form>
			</div>
			</div>
		</div>
		<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center></strong>';
		});
		</script>
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
		<script>
	
		$(function() {
			$("#table1").DataTable({
				"dom": 'Bfrtip',
				"responsive": true,
				"lengthChange": true,
				"searching": true,
				"ordering": false,
				"info": true,
				"autoWidth": false,
				"paging": true,
				buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5']
			});
		});

		</script>