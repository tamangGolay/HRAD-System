<link href="{{asset('css/bose.css')}}" rel="stylesheet"> 
		<!-- called in bose.css -->

<div class="row ">
	<div class="col">
		<div class="card ">
			<div class="card-header bg-green">
				<div class="col text-center">
					<h5>
                <b>HRC Services Vehicle Review</b>
              </h5> </div>
			</div>
			<!--/card-header-->
			<form method="POST" action="/vehicleapprove" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
				<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
				<div class="card-body table-responsive p-0">
					<table id="table13" class="table table-hover table-striped table-bordered">
						<thead>
							<tr class="text-nowrap">
								<th>Booking No</th>
								<th>Emp Id</th>
								<th>Wing/Dept/Div</th>
								<th>Name</th>
								<th>Date of Requisition</th>
								<th>Start Date</th>
								<th>End Date</th>
								
								<th>Purpose</th>
								<th>Places to Visit</th>
								<th>Approve</th>
								<th>Rejected</th>
							</tr>
						</thead>
						<tbody> @foreach($hrcsReview as $rv)
							<tr>
								<td> {{$rv->id}} </td>
								<td> {{$rv->emp_id}} </td>
								<td> {{$rv->description}} </td>
								<td> {{$rv->vname}} </td>
								<td class="text-nowrap"> {{$rv->dateOfRequisition}} </td>
								<td class="text-nowrap"> {{$rv->start_date}} </td>
								<td class="text-nowrap"> {{$rv->end_date}} </td>
								
								<td> {{$rv->purpose}} </td>
								<td> {{$rv->placesToVisit}} </td>
								<td>
									<!-- give specific employee id from button -->
									<button type="submit" name="id[]" id="id" value="{{$rv->id}}" class="button1 btn-outline-success text-dark text-center "> Approve</button> &nbsp;&nbsp; </td>
								<td>
			</form>
			<form method="POST" action="/vehiclereject" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
				<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
				<button type="submit" name="id[]" id="id" value="{{$rv->id}}" class="button2 btn-outline-danger text-center text-dark"> Reject</button>
				<br>
				<br>
				<div>
					<textarea name="reason" id="reason" placeholder="reason for rejection" style="margin-left:5%" required></textarea>
				</div>
			</form>
			</td>
			</tr> @endforeach </tbody>
			</table>
			<div class="float-right"> {{$hrcsReview->links()}} </div>
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

		
		<link href="{{asset('css/bose.css')}}" rel="stylesheet"> 
		<!-- called in bose.css -->

		<script>
	
		$(function() {
			$("#table13").DataTable({
				"dom": 'Bfrtip',
				"responsive": true,
				"lengthChange": true,
				"searching": true,
				"ordering": false,
				"info": true,
				"autoWidth": false,
				"paging": true,
				"retrieve":true,
				buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5']
			});
		});

		</script>