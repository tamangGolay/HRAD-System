

<style>




.w-25 {
	white-space: nowrap;
}

#saveBtn {
	width: 120px;
}

a {
	color: black !important;
	text-decoration: none;
}

.btn-primary {
	color: #fff !important;
	background-color: #007bff;
	border-color: #007bff;
}

.success {
	color: #fff !important;
	background-color: #28a745;
	border-color: #28a745;
}

.danger {
	color: #fff !important;
	background-color: #dc3545;
	;
	border-color: #28a745;
}

.thw {
	white-space: nowrap;
}

.fat{
	width: 14%;

}


.card-nima {
    margin-bottom: .75rem;
}

.card-nima {
    float: center;
    font-size: 1.1rem;
    font-weight: 400;
    margin: 0;
}
.card-nima {
    margin-bottom: .75rem;
}

</style>


			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
			<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
			<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<div class="container">
<div class="row">
	<div class="col">
		<div class="card">
		<div class="chgpsswd2 card-header bg-green text-center">
				<div class="card-nima">
					
              <b>User List</b>
             </div>
			</div>
			<div class="card-body table-responsive">
				<table id="example3" class="table table-hover table-striped table-bordered" width="100%">
					<thead>
						<tr class="thw">
							<th>Employee No</th>
							<th>Name</th>
							<th>Contact No</th>
							<th>Wing/Dept/Div</th>
							<th>Grade</th>
							<th>User Role</th>
							<!-- <th>Dzongkhag</th> -->

							<th class="fat">Action</th>
						</tr>
					</thead>
					<tbody> @foreach($userList as $ul)
						<tr>
							<td> {{$ul->emp_id}} </td>
							<td> {{$ul->uname}} </td>
							<td> {{$ul->contact_number}} </td>
							<td> {{$ul->description}} </td>
							<td> {{$ul->grade}} </td>
							<td> {{$ul->name}} </td>
							<!-- <td> {{$ul->Dzongkhag_Name}} </td> -->

							<td>
							<a href="javascript:void(0)" data-toggle="tooltip"   data-id="{{$ul->uid}}" data-original-title="Edit" class="edit mt-1 ml-2 btn btn-success btn edit"> <i class="fa fa-edit" style="color:white"></i></a>
							<a href="javascript:void(0)" data-toggle="tooltip" id="" data-id="{{$ul->uid}}" id="delete" data-original-title="Delete" class="btn mt-7 ml-2 danger btn delete"> <i class="fa fa-window-close" style="color:white"></i></a>	</button>
							</td>
						</tr> @endforeach </tbody>
				</table>
			</div>
			<div class="float-right"> {{$userList->links()}} </div>
			<div>
				<!--/card-body-->
			</div>
		</div>
	</div>
</div>

<div>



<div class="modal fade" id="ajaxModel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="modelHeading"></h4> </div>
						<div class="modal-body">
							<form id="Form" name="Form" class="form-horizontal"> @csrf
								<input type="hidden" id="token" value="{{ csrf_token() }}">


								<input type="hidden" value="<?php echo $userList[0]->uid;?>" name="id" id="id" readonly>
						


								<div class="form-group row">
									<label class="col-sm-4 text-md-right" for="emp_id">{{ __('Employee Number:') }}</label>
									<div class="col-sm-4">
									<input type="text" value="<?php echo $userList[0]->emp_id; ?>" name="emp_id" id="emp_id" readonly>

									</div>
								</div>

								
								<div class="form-group row">
									<label class="col-sm-4 text-md-right" for="name">{{ __('Contact Number:') }}</label>
									<div class="col-sm-4">
									<input type="number" value="<?php echo $userList[0]->contact_number; ?>" name="contact_number" id="contact_number" required>

									</div>
								</div>


								<div class="form-group row">
									<label class="col-sm-4 text-md-right" for="dzongkhag">{{ __('Dzongkhag:') }}</label>
									<div class="col-sm-4">
									<select name="dzongkhag" id="dzongkhag" value="<?php echo $userList[0]->Dzongkhag_Name; ?>" required>
										@foreach($dzongkhag as $dzongkhag)
											<option value="{{$dzongkhag->id}}">{{$dzongkhag->Dzongkhag_Name}}</option>
										@endforeach
									</select>
									</div>
								</div>


								<div class="form-group row">
									<label class="col-sm-4 text-md-right" for="designation">{{ __('Designation:') }}</label>
									<div class="col-sm-4">
									<input type="text" value="<?php echo $userList[0]->designation; ?>" name="designation" id="designation" required>

									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-4 text-md-right" for="designation">{{ __('Gender:') }}</label>
									<div class="col-sm-4">
									<input type="text" value="<?php echo $userList[0]->gender; ?>" name="gender" id="gender" required>

									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-4 text-md-right" for="name">{{ __('Name:') }}</label>
									<div class="col-sm-4">
									<input type="text" value="<?php echo $userList[0]->uname; ?>" name="name" id="name" >

									</div>
								</div>


							

								<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="orgunit">{{ __('Wing/Dept/Div:') }}</label>
						<div class="col-sm-6">
							<select name="org_unit" id="org_unit" class="form-control" required> @foreach($orgunit as $orgunits)
								<option value="{{$orgunits->id}}">{{$orgunits->description}}</option> @endforeach </select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="role">{{ __('Grade:') }}</label>
						<div class="col-sm-6">
						<select name="grade" id="grade" class="form-control" required>
						<option value=" ">Select Grade</option> 

							@foreach($grade as $grade)

							<option value="{{$grade->id}}">
							@if($grade->id < 21)

							{{$grade->grade}}</option> 
							@endif
							@endforeach 
			</select> 
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="name">{{ __('Email:') }}</label>
							<div class="col-sm-4">
								<input type="text" value="<?php echo $userList[0]->email; ?>" name="email" id="email" >

							</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="role">{{ __('Role:') }}</label>
						<div class="col-sm-6">
							<select class="form-control" name="role" id="role" required> @foreach($roles as $role)
								<option value="{{$role->id}}">{{$role->name}}</option> @endforeach </select>
						</div>
					</div>

					<div class="form-group row">
						<label for="conferenceuser" class="col-md-4 col-form-label text-md-right">{{ __('Conference User:') }}</label>
						<div class="col-md-6">
							<div class="input-group ">
								<input type="text" class="form-control" id="conferenceuser" name="conferenceuser" autocomplete="off" placeholder=" 1 = Conference User or 0 = other employee" required />
								<div class="input-group-append"> </div>
							</div>
						</div>
					</div>
								
								
								
								<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
									<button type="submit" class="btn btn-outline-success" id="saveBtn" value="create">Save changes </button>
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


								<input type="hidden" value="<?php echo $userList[0]->uid;?>" name="id" id="id" readonly>
						


							
								
								<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
									<button type="submit" class="btn btn-outline-success" id="saveUserBtn" value="create">Yes</button>
									<button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>



<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
	document.getElementById('contenthead').innerHTML = '<strong>User List</strong>';
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
	$("#example3").DataTable({
		"dom": 'Bfrtip',
		"responsive": true,
		"lengthChange": true,
		"searching": true,
		"ordering": false,
		"info": true,
		"autoWidth": true,
		"paging": true,
		"retrieve":true,
		buttons: ['copyHtml5', 'excelHtml5', 'pdfHtml5']
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
					$.get("{{ route('g.store') }}" + '/' + guestHouse_id + '/edit', function(data) {
						$('#modelHeading').html("Edit User");
						$('#saveBtn').val("edit-book");
						$('#ajaxModel').modal('show');
						$('#id').val(data.id);//#id is from modal form and data.id is from modal(fillable) database
						$('#name').val(data.name);
						$('#emp_id').val(data.emp_id);
						$('#contact_number').val(data.contact_number);
						$('#role').val(data.role_id);//#input id and with data(DB field name)
						$('#org_unit').val(data.org_unit_id);
						$('#conferenceuser').val(data.conference_user);
						$('#grade').val(data.grade);
						$('#designation').val(data.designation);
						$('#gender').val(data.gender);
						$('#email').val(data.email);

						$('#dzongkhag').val(data.dzongkhag);




						

					

						

				

				
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
			<!-- changes -
