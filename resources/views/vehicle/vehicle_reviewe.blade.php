

<div class="row ">
	<div class="col">
		<div class="card">
			<div class="card-header bg-green">
				<div class="col text-center">
					<h5>
                <b>Vehicle Review</b>
              </h5> </div>
			</div>
			<!--/card-header-->
			<form method="POST" action="/MTOapprove" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
				<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
				<div class="card-body table-responsive p-0">
					<table id="example5" class="table table-hover table-striped table-bordered">
						<thead>
							<tr class="text-nowrap">
								<th>Booking No</th>
								<th>Emp Id</th>
								<th>Wing/Dept/Div</th>
								<th>Name</th>
								<th>Date of Requisition</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>Vehicle Name</th>
								<th>Purpose</th>
								<th>Places to Visit</th>
								<th>Supervisor</th>
								<th>Assign vehicle</th>
								<th>Approve</th>
								<th>Reject</th>
							</tr>
						</thead>
					<table>
				
				<!--/card-body-->
			</div>
			</form>
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
			<script src="{{asset('/admin-lte/datatables/buttons.flash.min.js')}}"></script>
			<script src="{{asset('/admin-lte/datatables/jszip.min.js')}}"></script>
			<script src="{{asset('/admin-lte/datatables/pdfmake.min.js')}}"></script>
			<script src="{{asset('/admin-lte/datatables/vfs_fonts.js')}}"></script>
			<!-- checkin form -->
			<script>
			$(function() {
				$("#example5").DataTable({
					"dom": 'Bfrtip',
					"responsive": true,
					"lengthChange": true,
					"searching": true,
					"ordering": false,
					"info": true,
					"autoWidth": true,
					"paging": true,
					buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
				});
			});
			</script>