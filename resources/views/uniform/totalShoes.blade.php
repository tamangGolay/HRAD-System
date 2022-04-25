<div class="row ">
	<div class="col">
		<div class="card ">
			<div class="card-header bg-green">
				<div class="col text-center">
					<h5>
                <b>Total Number of Shoes</b>
              </h5> </div>
			</div>
			<!--/card-header-->
			<form method="POST" action="/vehicleapprove" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
				<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
				<div class="card-body table-responsive p-0">
					<table id="table1" class="table table-hover table-striped table-bordered">
						<thead>
							<tr class="text-nowrap">
								<th>Sl.No</th>
								<th>Org Unit</th>
								<th>Uniform Id</th>
								<th>3</th>
								<th>4</th>
								<th>5</th>
								<th>6</th>
								<th>7</th>
								<th>8</th>
								<th>9</th>
								<th>10</th>
								<th>11</th>
								<th>12</th>
								<th>13</th>
								<th>14</th>
								<th>15</th>
								<th>Dzongkhags</th>
								
			
							</tr>
						</thead>
						<tbody> @foreach($data2 as $rv)
							<tr>
								<td> {{$rv->id}} </td>
								<td> {{$rv->description}} </td>
								<td> {{$rv->uniform_id}} </td>
								<td> {{$rv->shoe_3}} </td>
								<td> {{$rv->shoe_4}} </td>
								<td> {{$rv->shoe_5}} </td>
								<td> {{$rv->shoe_6}} </td>
								<td> {{$rv->shoe_7}} </td>
								<td> {{$rv->shoe_8}} </td>
								<td> {{$rv->shoe_9}} </td>
								<td> {{$rv->shoe_10}} </td>
								<td> {{$rv->shoe_11}} </td>
								<td> {{$rv->shoe_12}} </td>
								<td> {{$rv->shoe_13}} </td>
								<td> {{$rv->shoe_14}} </td>
								<td> {{$rv->shoe_15}} </td>
								<td> {{$rv->Dzongkhag_Name}} </td>
								
								
													
			</form>
			</td>
			</tr> @endforeach </tbody>
			</table>
			
			<div>
				<!--/card-body-->
				</form>
			</div>
			</div>
		</div>

		
		
		<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
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
			$("#table1").DataTable({
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


		$('form').submit(function () {
    // Bail out if the form contains validation errors
    if ($.validator && !$(this).valid()) return;

    var form = $(this);
    $(this).find('input[type="submit"], button[type="submit"]').each(function (index) {
        // Create a disabled clone of the submit button
        $(this).clone(false).removeAttr('id').prop('disabled', true).insertBefore($(this));

        // Hide the actual submit button and move it to the beginning of the form
        $(this).hide();
        form.prepend($(this));
    });
	});

		</script>