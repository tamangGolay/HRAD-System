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
					<table id="report" class="table table-hover table-striped table-bordered">
						<thead>
							<tr class="text-nowrap">
								<th>Sl.No</th>
								<th>Emp Id</th>
                                <!-- <th>Name</th> -->
								<th>Wing/Dept/Div</th> 								
								<th>Pant Size</th>
								<th>Shirt Size</th>
								<th>Jacket Size</th>
								<th>Shoe Size</th>
                                <th> Gumboot Size </th>
                                <th> Raincoat Size </th>								
								
								<th> Delete </th>
							</tr>
						</thead>
						<tbody> @foreach($data1 as $rv)
							<tr>
							<td> {{$rv->uniformId}} </td>
								<td> {{$rv->empId}} </td>
                                <td> {{$rv->shortOfficeName}} </td>	
                                <td> {{$rv->pantSizeName}} </td>
								<td> {{$rv->shirtSizeName}} </td>
								<td> {{$rv->jacket}} </td>
                                <td> {{$rv->ukShoeSize}} </td>
								<td> {{$rv->uKSize}}  </td>
								<td> {{$rv->sizeName}}  </td>

								 </form>
								
								 <td>
							<a href="javascript:void(0)" data-toggle="tooltip"   data-id="{{$rv->id}}" data-original-title="Edit" class="edit mt-1 ml-2 btn btn-success btn edit"> <i class="fa fa-edit" style="color:white"></i></a>
						 <form method="POST" action="{{ route('nieuws', [$rv->id]) }}">
    								{{ csrf_field() }}  {{ method_field('DELETE') }}
   								<button type="submit">Delete</button>
										
									</form> 
								</td> 
								
								
		                      	</tr> @endforeach </tbody>
			                </table>
			 <div class="float-right"> {{$data1->links()}} </div> 
			
			</div>


			<div class="modal fade" id="ajaxModel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="modelHeading"></h4> </div>
						<div class="modal-body">
							<form id="Form" name="Form" class="form-horizontal"> @csrf
								<input type="hidden" id="token" value="{{ csrf_token() }}">

								<input type="hidden" value="<?php echo $data1[0]->id;?>" name="id" id="id" >
						

				
								<div class="form-group row">
									<label class="col-sm-4 text-md-right" for="emp_id">{{ __('Employee Number:') }}</label>
									<div class="col-sm-4">
									<input type="text" value="<?php echo $data1[0]->empId; ?>" name="emp_id" id="emp_id"  readonly>

									</div>
								</div>

								

								<div class="form-group row">
									<label class="col-sm-4 text-md-right" for="office">{{ __('Office:') }}</label>
									<div class="col-sm-4">
									<input type="text" value="<?php echo $data1[0]->shortOfficeName; ?>" name="office" id="office" readonly>

									</div>
								</div>


								
					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="pant">{{ __('Pant:') }}</label>
						<div class="col-sm-6">

							<select class="form-control" name="pant" id="pant" required> 
							<option value="">Select pant Size</option>	
							@foreach($pant as $pant)
								<option value="{{$pant->id}}" > {{$pant->pantSizeName}}
								</option>
								@endforeach </select>
						</div>
					</div>


					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="shirt">{{ __('Shirt:') }}</label>
						<div class="col-sm-6">

							<select class="form-control" name="shirt" id="shirt" required> 
							<option value="">Select Shirt Size</option>	
							@foreach($shirt as $shirt)
								<option value="{{$shirt->id}}" > {{$shirt->shirtSizeName}}
								</option>
								@endforeach </select>
						</div>
					</div>


					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="jacket">{{ __('Jacket:') }}</label>
						<div class="col-sm-6">

							<select class="form-control" name="jacket" id="jacket" required> 
							<option value="">Select jacket Size</option>	
							@foreach($jacket as $jacket)
								<option value="{{$jacket->id}}" > {{$jacket->sizeName}}
								</option>
								@endforeach </select>
						</div>
					</div>
								
					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="shoe">{{ __('Shoe:') }}</label>
						<div class="col-sm-6">

							<select class="form-control" name="shoe" id="shoe" required> 
							<option value="">Select shoe Size</option>	
							@foreach($shoe as $shoe)
								<option value="{{$shoe->id}}" > {{$shoe->ukShoeSize}}
								</option>
								@endforeach </select>
						</div>
					</div>
								
					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="gumboot">{{ __('Gumboot:') }}</label>
						<div class="col-sm-6">

							<select class="form-control" name="gumboot" id="gumboot" required> 
							<option value="">Select gumbbot Size</option>	
							@foreach($gumboot as $gumboot)
								<option value="{{$gumboot->id}}" > {{$gumboot->uKSize}}
								</option>
								@endforeach </select>
						</div>
					</div>


					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="raincoat">{{ __('Raincoat:') }}</label>
						<div class="col-sm-6">

							<select class="form-control" name="raincoat" id="raincoat" required> 
							<option value="">Select shoe Size</option>	
							@foreach($raincoat as $raincoat)
								<option value="{{$raincoat->id}}" > {{$raincoat->sizeName}}
								</option>
								@endforeach </select>
						</div>
</div>

	





													
					<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
									<button type="submit" class="btn btn-outline-success" id="saveBtn" value="create">Save changes </button>
									<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>      

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>


			<div class="modal fade" id="userModel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="modelUserHeading"></h4> </div>
						<div class="modal-body">
							<form id="Form" name="Form" class="form-horizontal"> @csrf
								<input type="hidden" id="token" value="{{ csrf_token() }}">


									<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
									<button type="submit" class="btn btn-outline-success" id="saveUserBtn" value="create">Yes</button>
									<button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
			<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
			<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
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
			$("#report").DataTable({
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
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>   -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
			<!-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> -->
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
			<!-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> -->
			<script type="text/javascript">

			$(function() {
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

				
	
				$('body').on('click', '.edit', function() {
					var guestHouse_id = $(this).data('id');
					$.get("{{ route('uni.store') }}" + '/' + guestHouse_id + '/edit', function(data) {
						$('#modelHeading').html("Edit User");
						$('#saveBtn').val("edit-book");
						$('#ajaxModel').modal('show');
						$('#id').val(data.id);//#id is from modal form and data.id is from modal(fillable) database
						$('#emp').val(data.empId); //input id,database
						$('#office').val(data.officeId);
						$('#pant').val(data.pant);
						$('#shirt').val(data.shirt);
						$('#jacket').val(data.jacket);
						$('#shoe').val(data.shoe);
						$('#gumboot').val(data.gumboot);
						$('#raincoat').val(data.raincoat);

					})
				});
				$('#saveBtn').click(function(e) {
					e.preventDefault();
					$(this).html('Save');
					$.ajax({
						data: $('#Form').serialize(),
						url: "{{ route('g.store') }}",
						type: "POST",
						dataType: 'json',
						success: function(data) {
							$('#Form').trigger("reset");
							$('#ajaxModel').modal('hide');
							//   table.draw();
							window.onload = callajaxOnPageLoad(page);
							var alt = document.createElement("div");
							alt.setAttribute("style", "position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
							alt.innerHTML = "Data Updated Successfully! ";
							setTimeout(function() {
								alt.parentNode.removeChild(alt);
							}, 4500);
							document.body.appendChild(alt);
							
							window.location.href = '/home';
							table.draw();
						},
						error: function(data) {
							console.log('Error:', data);
							$('#saveBtn').html('Save Changes');
						}
					});
				});


				$('body').on('click', '.delete', function() {
					var guestHouse_id = $(this).data('id');
					$.get("{{ route('g.store') }}" + '/' + guestHouse_id + '/edit', function(data) {
						$('#modelUserHeading').html("Do you want to delete user?");
						$('#saveUserBtn').val("edit-book");
						$('#userModel').modal('show');
						$('#id').val(data.id);//#id is from modal form and data.id is from modal(fillable) database
					})
				});
				$('#saveUserBtn').click(function(e) {
					e.preventDefault();
					$(this).html('Yes');
					$.ajax({
						data: $('#Form').serialize(),
						url: "{{ route('deleteuser') }}",
						type: "POST",
						dataType: 'json',
						success: function(data) {
							$('#Form').trigger("reset");
							$('#userModel').modal('hide');
							//   table.draw();
							window.onload = callajaxOnPageLoad(page);
							var alt = document.createElement("div");
							alt.setAttribute("style", "position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
							alt.innerHTML = "Data Updated Successfully! ";
							setTimeout(function() {
								alt.parentNode.removeChild(alt);
							}, 4500);
							document.body.appendChild(alt);
							$.get('/getView?v=userList', function(data) {
								$('#contentpage').empty();
								$('#contentpage').append(data.html);
							});
							table.draw();
						},
						error: function(data) {
							console.log('Error:', data);
							$('#saveBtn').html('Save Changes');
						}
					});
				});
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
			<script src="{{asset('/admin-lte/datatables/jszip.min.js')}}"></script>
			<!-- <script src="{{asset('/admin-lte/datatables/pdfmake.min.js')}}"></script> -->
			<script src="{{asset('/admin-lte/datatables/vfs_fonts.js')}}"></script>
			<!-- checkin form -->
			<script>
			$(document).ready(function() {
				$('#myTable').DataTable({
					dom: "Bfrtip",
					"pagingType": "simple_numbers",
					"Searching": true,
					"ordering": false,
					buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5']
				});
			});
			</script>
			<script type="text/javascript">
			$(document).ready(function() {
				document.getElementById('contenthead').innerHTML = '<strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
			});
			</script>
			<!-- changes -->
