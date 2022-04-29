<div class="row ">
	<div class="col">
		<div class="card ">
			<div class="card-header bg-green">
				<div class="col text-center">
					<h5>
                <b>Uniform Size of Individual</b>
              </h5> </div>
			</div>
			<!--/card-header-->
			<form method="POST" action="/" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
				<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
				<div class="card-body table-responsive p-0">
					<table id="table1" class="table table-hover table-striped table-bordered">
						<thead>
							<tr class="text-nowrap">
								<th>Sl.No</th>
								<th>Emp Id</th>
                                <th>Name</th>
								<th>Wing/Dept/Div</th> 								
								<th>Pant Size</th>
								<th>Shirt Size</th>
								<th>Jacket Size</th>
								<th>Shoe Size</th>
                                <th> Gumboot Size </th>
                                <th> Raincoat Size </th>								
								<th> Edit </th>
								<th> Delete </th>
							</tr>
						</thead>
						<tbody> @foreach($data1 as $rv)
							<tr>
								<td> {{$rv->id}} </td>
								<td> {{$rv->emp_id}} </td>
								<td> {{$rv->name}} </td>	
                                <td> {{$rv->description}} </td>	
                                <td> {{$rv->pant}} </td>
								<td> {{$rv->shirt}} </td>
								<td> {{$rv->jacket}} </td>
                                <td> {{$rv->shoe}} </td>
								<td> {{$rv->jumboot}}  </td>
								<td> {{$rv->raincoat}}  </td>

								<td>
									<a href="javascript:void(0)" data-toggle="tooltip" data-id="{{$rv->id}}" data-original-title="Edit" class="edit mt-1 ml-2 btn btn-outline-info btn edit"> 
										<i class="fa fa-edit" style="color:black"></i></a>
								</td> </form>
								
						        <td>  <form method="POST" action="{{ route('nieuws', [$rv->id]) }}">
    								{{ csrf_field() }}  {{ method_field('DELETE') }}
   								<button type="submit">Delete</button>
										
									</form> 
								</td> 
								
								
		                      	</tr> @endforeach </tbody>
			                </table>
			 <div class="float-right"> {{$data1->links()}} </div> 
			<div>
				<!--/card-body-->
				
			</div>
			</div>
			
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
			<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
			<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
			<!-- <div class="modal fade" id="ajaxModel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="modelHeading"></h4> </div>
						<div class="modal-body">
							<form id="Form" name="Form" class="form-horizontal"> @csrf
								<input type="hidden" id="token" value="{{ csrf_token() }}">
								<input type="hidden" value="<?php echo $data1[0]->id;?>" name="id" id="id" readonly>
								

								<div class="form-group row">
									<label for="dtpickerdemo2" class="col-md-5 col-form-label text-md-right"> &nbsp;&nbsp;&nbsp;Pant size:</label>
									<div class="col-sm-7 input-group date " id='dtpickerdemo2'>
										<input type="text" class="form-control" value="<?php echo $data1[0]->pant;?>" name="pant" id="pant" placeholder="Enter your pant size:" autocomplete="off" required/> <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span> </span>
									</div>
								</div>
								<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
									<button type="submit" class="btn btn-outline-success" id="saveBtn" value="create">Save changes </button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div> -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
			<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>			
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

			<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
				
		
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

	
	
	// $.ajaxSetup({
	// 			headers: {
	// 				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 			}
	// 		});
	// 		$('body').on('click', '.edit', function() {
	// 			var unifromId = $(this).data('id'); //pull uniform request id   
	// 			$.get("{{ route('a_b.store') }}" + '/' + unifromId + '/edit', function(data) { //pass vehicleid means requestid here
	// 				$('#modelHeading').html("Update your uniform size correctly!");
	// 				$('#ajaxModel').modal('show'); //post data as $request in vehiclecontroller using ajaxcontroller
	// 				$('#id').val(data.id);
	// 				// $('#vehicle').val(data.vehicleId); //here its vehicle id only
	// 				$('#pant').val(data.pant); //pulling data on modal is not handled here
	// 			})
	// 		});
	// 		$('#saveBtn').click(function(e) {
	// 			e.preventDefault();
	// 			$(this).html('Save');
	// 			$.ajax({
	// 				data: $('#Form').serialize(),
	// 				url: "{{ route('a_b.store') }}",
	// 				type: "POST",
	// 				dataType: 'json',
	// 				success: function(data) {
	// 					$('#Form').trigger("reset");
	// 					$('#ajaxModel').modal('hide');
	// 					//   table.draw();
	// 					window.onload = callajaxOnPageLoad(page);
	// 					var alt = document.createElement("div");
	// 					alt.setAttribute("style", "position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
	// 					alt.innerHTML = "Data Updated Successfully! ";
	// 					setTimeout(function() {
	// 						alt.parentNode.removeChild(alt);
	// 					}, 4500);
	// 					document.body.appendChild(alt);

	// 					window.location.href = '/home';

	// 					// $.get('/getView?v=/home', function(data) {
	// 					// 	$('#contentpage').empty();
	// 					// 	$('#contentpage').append(data.html);
	// 					// });
	// 					table.draw();
	// 				},
	// 				error: function(data) {
	// 					console.log('Error:', data);
	// 					$('#saveBtn').html('Save Changes');
	// 				}
	// 			});
	// 		});

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