
<div class="row ">
	<div class="col">
		<div class="card ">
			<div class="card-header bg-green">
				<div class="col text-center">
					<h5>
                <b>Office Wise Uniform Report</b>
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
								<th>Wing/Dept/Div</th> 								
								<th>Uniform Name</th>
								<th>S</th>
								<th>M</th>
								<th>L</th>							
								<th>XL</th>
								<th>2XL</th>
								<th>3XL</th>
								<th>4XL</th>
								<th>5XL</th>
								<th>6XL</th>
								<th>Dzongkhag</th>
							</tr>
							
						</thead>
						<tbody> @foreach($data2 as $rv)
							<tr>
								<td> {{$rv->id}} </td>										
                                <td> {{$rv->description}} </td>	
								<td> 
									@if ($rv->uniform_id ==1 )
										Pant
									
									@elseif($rv->uniform_id ==2 )
										Shirt
																			
									@elseif ($rv->uniform_id ==3 )
										Jacket
									
									@elseif($rv->uniform_id ==4 )
										Shoe
									
									@elseif ($rv->uniform_id ==5 )
										Gumboot
									
									@else ($rv->uniform_id ==6 )
										Raincoat
									@endif

								</td>
                                <td> {{$rv->S}} </td>
								<td> {{$rv->M}} </td>
								<td> {{$rv->L}} </td>
                                <td> {{$rv->XL}} </td>	
								<td> {{$rv->Size_2XL}} </td>
								<td> {{$rv->Size_3XL}} </td>
								<td> {{$rv->Size_4XL}} </td>
								<td> {{$rv->Size_5XL}} </td>
								<td> {{$rv->Size_6XL}} </td>

								<td> {{$rv->Dzongkhag_Name}} </td>

				</form>
			</td>
			</tr> @endforeach </tbody>
			</table>
			<!-- <div class="float-right"> {{$data2->links()}} </div> -->
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
	