
<style>
.w-25 {
	white-space: nowrap;
}

/* #saveBtn {
	width: 120px;
} */

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
.chgpsswd2{
	background-color: rgb(22 163 74) !important;
}

</style>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
			<!-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> -->
			<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<div class="container">
<div class="row">
<div id="backButton" style="position: absolute; top: 20px; left: 20px; cursor: pointer;">
    <i class="fa fa-arrow-left" aria-hidden="true"></i> <b>Back</b>
</div>

	<div class="col">
		<div class="card">
		<div class="chgpsswd2 card-header bg-green text-center">
				<div class="card-nima">
					
              <b>User List (HR Real)</b>
             </div>
			</div>
			
			<div class="card-body">
				<!-- <table class="table table-hover table-striped table-bordered data-table" width="100%"> -->
				<table class="table table-bordered data-table" style="width:100%">
					<thead>
						<tr class="thw">
							<th>Employee No</th>
							<th>Name</th>							
							<th>Designation</th>
							<th>Gender</th>
							<th>Office</th>	
							<th class="fat">Action</th>
						</tr>
					</thead>
					<tbody> 
				 </tbody>
				</table>
			</div>		
		</div>
	</div>
</div>
<div class="modal fade" id="ajaxModel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="modelHeading"></h4> </div>
						<div class="modal-body">
							<form id="Form" name="Form" class="form-horizontal"> @csrf
								<input type="hidden" id="token" value="{{ csrf_token() }}">

								<input type="hidden"  name="id" id="id" >
						


								<div class="form-group ">
									<label class="col-sm-4 col-lg-12" for="emp_id">Employee Number:</label>
									<div class="col-sm-6 col-lg-12">
									<input type="text" class="form-control" name="empId" id="empId" required>

									</div>
								</div>

								<div class="form-group ">
									<label class="col-sm-4 col-lg-12" for="empName">Name:</label>
									<div class="col-sm-6 col-lg-12">
									<input type="text"  class="form-control" name="empName" id="empName" required>

									</div>
								</div>

								<div class="form-group ">
									<label class="col-sm-4 col-lg-12" for="cidNo">Cid Number:</label>
									<div class="col-sm-6 col-lg-12">
									<input type="text"  class="form-control"  name="cidNo" id="cidNo" required>

									</div>
								</div>

								<div class="form-group ">
									<label class="col-sm-4 col-lg-12" for="dob">Date of Birth:</label>
									<div class="col-sm-6 col-lg-12">
									<input type="text"  class="form-control" name="dob" id="dob" required>

									</div>
								</div>

								<div class="form-group ">
									<label class="col-sm-4 col-lg-12" for="appointmentDate">Appointment Date:</label>
									<div class="col-sm-6 col-lg-12">
									<input type="text"  class="form-control"  name="appointmentDate" id="appointmentDate">

									</div>
								</div>

								<div class="form-group ">
									<label class="col-sm-4 col-lg-12" for="gradeId">Grade:</label>
									<div class="col-sm-6 col-lg-12">
										<select class="form-control" name="gradeId" id="gradeId" required> @foreach($payscalemaster as $grade)
											<option value="{{$grade->id}}" > {{$grade->grade}}
											</option>
										@endforeach 
										</select>
									</div>
								</div>

								<div class="form-group ">
									<label class="col-sm-4 col-lg-12" for="lastDop">Last Dop:</label>
									<div class="col-sm-6 col-lg-12">
									<input type="text"  class="form-control"  name="lastDop" id="lastDop" >

									</div>
								</div>

								<div class="form-group ">
									<label class="col-sm-4 col-lg-12" for="emailId">Email:</label>
									<div class="col-sm-6 col-lg-12">
									<input type="text"  class="form-control" name="emailId" id="emailId" >

									</div>
								</div>


								<div class="form-group ">
									<label class="col-sm-4 col-lg-12" for="basicPay">Basic Pay:</label>
									<div class="col-sm-6 col-lg-12">
									<input type="text"  class="form-control" name="basicPay" id="basicPay" >

									</div>
								</div>

						<div class="form-group ">
						<label class="col-sm-4 col-lg-12" for="designation">Designation:</label>
						<div class="col-sm-6 col-lg-12">

							<select class="form-control" name="designation" id="designation" required> @foreach($designation as $designation)
								<option value="{{$designation->id}}" > {{$designation->desisNameLong}}
								</option>
								@endforeach </select>
						</div>
					</div>

								<div class="form-group ">
									<label class="col-sm-4 col-lg-12" for="mobileNo">MobileNo:</label>
									<div class="col-sm-6 col-lg-12">
									<input type="text"  class="form-control" name="mobileNo" id="mobileNo" required>

									</div>
								</div>

								<div class="form-group ">
									<label class="col-sm-4 col-lg-12" for="incrementCycle">IncrementCycle:</label>
									<div class="col-sm-6 col-lg-12">
									<input type="text"  class="form-control"  name="incrementCycle" id="incrementCycle" >

									</div>
								</div>

								<div class="form-group ">
									<label class="col-sm-4 col-lg-12" for="gender">Gender:</label>
									<div class="col-sm-6 col-lg-12">
									<select class="form-control" name="gender" id="gender" required>
											<option value="Female">Female</option>
											<option value="Male">Male</option>	
											<option value="Other">Other</option>											
										</select>
									</div>
								</div>								

								<div class="form-group">
									<label class="col-sm-4 col-lg-12" for="empStatus">Employee Status:</label>
									<div class="col-sm-6 col-lg-12">
										<select class="form-control" name="empStatus" id="empStatus" required>
											<option value="Active">Active</option>
											<option value="On deputation">On deputation</option>
											<option value="On EOL">On EOL</option>
											<option value="On Study Leave">On Study Leave</option>
										</select>
									</div>
								</div>							


						<div class="form-group ">
						<label class="col-sm-4 col-lg-12" for="office">Office:</label>
						<div class="col-sm-6 col-lg-12">

							<select class="form-control" name="office" id="office" required> @foreach($officedetails as $office)
								<option value="{{$office->id}}" > {{$office->officeDetails}}
								</option>
								@endforeach </select>
						</div>
					</div>


					
					<div class="form-group ">
						<label class="col-sm-4 col-lg-12" for="Address">Office Address:</label>
						<div class="col-sm-6 col-lg-12">

							<select class="form-control" name="Address" id="Address" required> @foreach($officedetails as $office)
								<option value="{{$office->id}}" > {{$office->Address}}
								</option>
								@endforeach </select>
						</div>
					</div>

					<div class="form-group ">
						<label class="col-sm-4 col-lg-12" for="role">Role:</label>
						<div class="col-sm-6 col-lg-12">
							<select class="form-control" name="role" id="role" required> @foreach($roles as $role)
								<option value="{{$role->id}}" 
								@if($role->name == 'Super Admin' || $role->name == 'Admin') disabled @endif>
								{{$role->name}}</option> 
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
									<button type="submit" class="btn btn-outline-success" id="deleteNEWbtn" value="create">Yes</button>
									<button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div> 				
							

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>   -->
    <script type="text/javascript">

 //Loading the contents of the Datatable from here

 $(document).ready(function() {

	 var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
		"searching": true,
		"ordering": true,
		"paging": true,
		deferLoading: 0,   // table starts empty
        ajax: "{{ route('newHRList.index') }}",         // initial data in data table
        columns: [
            {data: 'empId', name: 'empId',orderable: true, searchable: true},
            {data: 'empName', name: 'empName',orderable: true, searchable: true}, 
			{data: 'desisNameLong', name: 'designationmaster.desisNameLong',orderable: true, searchable: true}, 
			{data: 'gender', name: 'gender',orderable: true, searchable: true}, 
			{data: 'officeDetails', name: 'officedetails.officeDetails',orderable: true, searchable: true},	
			{data: 'action', name: 'action',orderable: true, searchable: false},
        ]
    });
	
	//after edit
	
				$('body').on('click', '.editHRUSER', function() {
					var userHR_id = $(this).data('id');
					$.get("{{ route('newHRList.index') }}" + '/' + userHR_id + '/edit', function(data) {
						$('#modelHeading').html("Edit User");
						$('#saveBtn').val("edit-book");
						$('#ajaxModel').modal('show');
						$('#id').val(data.id);//#id is from modal form and data.id is from modal(fillable) database
						$('#employmentType').val(data.employmentType);
						$('#empName').val(data.empName);
						$('#empId').val(data.empId);
						$('#incrementCycle').val(data.incrementCycle);
						$('#gender').val(data.gender);
						$('#empStatus').val(data.empStatus);
						$('#role').val(data.role_id);		    	 //#input id and with data(DB field name)
						$('#office').val(data.office);
						$('#mobileNo').val(data.mobileNo);
						$('#designation').val(data.designationId);
						$('#basicPay').val(data.basicPay);
						$('#emailId').val(data.emailId);
						$('#lastDop').val(data.lastDop);
						$('#gradeId').val(data.gradeId);
						$('#appointmentDate').val(data.appointmentDate);
						$('#dob').val(data.dob);
						$('#cidNo').val(data.cidNo);

					})
				});
				$('#saveBtn').click(function(e) {
					e.preventDefault();
					$(this).html('Save');
					$.ajax({
						data: $('#Form').serialize(),
						url: "{{ route('newHRList.store') }}",
						type: "POST",
						dataType: 'json',
						success: function(data) {
							$('#Form').trigger("reset");
							$('#ajaxModel').modal('hide');
							table.draw();
							 // Reload DataTable
							window.onload = callajaxOnPageLoad(page);
							var alt = document.createElement("div");
							alt.setAttribute("style", "position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
							alt.innerHTML = "Data Updated Successfully! ";
							
							// $.get('/getView?v=userlistNEW',function(data){
							// $('#contentpage').empty();                          
							// $('#contentpage').append(data.html);
							// });   
							window.location.href = '/userlistNEW';             
							// window.location.href = '/home';
						// table.draw();

						},
						error: function(data) {
							console.log('Error:', data);
							$('#saveBtn').html('Save Changes');
							alert('cannot leave field empty');
						}
					});
				});


				$('body').on('click', '.deleteNEW', function() {
					var guestHouse_id = $(this).data('id');
					$.get("{{ route('newHRList.index') }}" + '/' + guestHouse_id + '/edit', function(data) {
						$('#modelUserHeading').html("Do you want to delete user?");
						$('#deleteNEWbtn').val("edit-book");
						$('#userModel').modal('show');
						$('#id').val(data.id);		//#id is from modal form and data.id is from modal(fillable) database
					})
				});
				$('#deleteNEWbtn').click(function(e) {
					e.preventDefault();
					$(this).html('Yes');
					$.ajax({
						data: $('#Form').serialize(),
						url: "{{ route('deleteuserNEW') }}",
						type: "POST",
						dataType: 'json',
						success: function(data) {
							$('#Form').trigger("reset");
							$('#userModel').modal('hide');
							table.draw();  // Reload DataTable
							window.onload = callajaxOnPageLoad(page);
							var alt = document.createElement("div");
							alt.setAttribute("style", "position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
							alt.innerHTML = "Data Updated Successfully! ";
							
							document.body.appendChild(alt);
							// $.get('/getView?v=userlistNEW',function(data){
							// $('#contentpage').empty();                          
							// $('#contentpage').append(data.html);
							// });
							window.location.href = '/userlistNEW';  
							// table.draw(); 
						},
						error: function(data) {
							console.log('Error:', data);
							$('#deleteNEWbtn').html('Save Changes');
						}
					});
				});		

 			});

	document.getElementById('backButton').addEventListener('click', function() {
    window.location.href = '/home';
});

</script>		
						
