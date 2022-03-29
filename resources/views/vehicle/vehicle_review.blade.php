<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet" />
<div class="row ">
	<div class="col">
		<div class="card ">
			<div class="card-header bg-green">
				<div class="col text-center">
					<h5>
            <b>Booking Details</b>
          </h5> </div>
			</div>
			<!--/card-header-->
			<form method="POST" action="/conferenceapprove" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
				<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}"> @if(session()->has('alert-success'))
				<div class="alert alert-info"> {{ session()->get('alert-success') }} </div> @endif @if(session()->has('fail'))
				<div class="alert alert-danger"> {{ session()->get('fail') }} </div> @endif
				<style>
				button {
					width: 40px;
				}
				
				.w-25 {
					white-space: nowrap;
				}
				</style>
				<div class="card-body table-responsive p-0">
					<div>
						<table id="example1" class="table table-hover table-striped table-bordered">
							<thead>
								<tr>
									<th>Emp Id</th>
									<th>Name</th>
									<th>Contact No</th>
									<th>Wing/Dept/Div</th>
									<th>Meeting Name</th>
									<th>Conference Name</th>
									<th class="w-25 ">Start Date and Time</th>
									<th class="w-25 ">End Date and Time</th>
									<th>No of People</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody> @foreach($review as $rv)
								<tr>
									<td> {{$rv->emp_id}}
										<!-- pass employee id -->
										<!-- <input type="hidden" name="emp_id[]" id="emp_id" value="{{$rv->emp_id}}"> -->
									</td>
									<td> {{$rv->vname}} </td>
									<!-- <td>
                     {{$rv->designation}}
                    </td> -->
									<td> {{$rv->contact_number}} </td>
									<td> {{$rv->description}} </td>
									<td> {{$rv->meeting_name}} </td>
									<td> {{$rv->Conference_Name}} </td>
									<td> {{date("Y-m-d h:i A",strtotime($rv->start_date))}} </td>
									<td class="text-nowrap"> {{date("Y-m-d h:i A",strtotime($rv->end_date))}} </td>
									<td> {{$rv->no_of_people}} </td>
									<td style="width:40%">
										<!-- give specific employee id from button -->
										<button type="submit" name="id[]" id="id" value="{{$rv->id}}" class="btn btn-success col-sm-12 col-md-10 col-lg-12"> <i class="fa fa-check " style="color:white"></i></button> &nbsp;&nbsp;
										<button type="submit" id="reject" class="btn btn-danger mt-2 col-sm-12 col-md-10 col-lg-12" method="POST" action="/conferencereject"> <i class="fa fa-times" style="color:white"></i></button>
									</td>
									<!-- </tr> -->@endforeach </tbody>
						</table>
					</div>
					<div class="float-right"> {{$review->links()}} </div>
					<div>
						<!--/card-body-->
			</form>
			</div>
			</div>
			<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
			<script type="text/javascript">
			$(document).ready(function() {
				document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center>Boardroom and Conference booking details</strong>';
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
				$("#example1").DataTable({
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