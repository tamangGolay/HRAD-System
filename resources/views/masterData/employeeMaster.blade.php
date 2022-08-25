
<style>
.chgpsswd2{
    font-family: "Times New Roman", Times, serif;
    font-size: 25px;
  }
  .textfont{
	font-family: Arial, Helvetica, sans-serif; 
	font-size: 15px;
  } 
</style> 
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="chgpsswd2 card-header bg-green text-center">
					
                        <b>Employee Master</b>
                     </div>
				<div class="card-body">
				<form method="POST" action="user" onsubmit="return pwdMatching();"> @csrf
					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
					<div class="form-group row">
						<label for="emp_id" class="col-md-4 col-form-label text-md-right">{{ __('Employee Number:') }}</label>
						<div class="col-md-4">
							<input  id="emp_id" type="number" placeholder="Employee Number" onKeyPress="if(this.value.length==8) return false;"
							 class="form-control @error('EmpId') is-invalid @enderror" name="EmpId" value="{{ old('EmpId') }}"
							  required autocomplete="EmpId" onFocusOut="getEmployeeDetails(this.value);"> 
						</div> 
						<span id="info" class="text-danger text-md-right"></span>
						<div class="col-sm-2"> 
							<span id="empid" class="text-danger"></span>
						 </div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name:') }}</label>
						<div class="col-md-4">
							<input id="EmpName" type="text"  autocomplete="off" placeholder="Name" 
							class="form-control @error('EmpName') is-invalid @enderror" name="EmpName"
							 value="{{ old('EmpName') }}" required autocomplete="EmpName"> 
						</div>
					</div>
 
					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Blood Group:') }}</label>
						<div class="col-md-4">
							<input id="BloodGroup" type="text" autocomplete="off" placeholder="A+/O+" 
							class="form-control" name="BloodGroup" required> 
						</div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('CID Number:') }}</label>
						<div class="col-md-4">
							<input id="cidNo" type="number" autocomplete="off" placeholder="cid" class="form-control"
							 name="cidNo" required>
						</div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Date Of Birth:') }}</label>
						<div class="col-md-4">
							<input id="dob" type="date" autocomplete="off" placeholder="DOB" class="form-control"
							 name="dob" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="gender">{{ __('Select Gender:') }}</label>
						<div class="col-sm-4">
						<select name="gender" id="gender" class="form-control" required> 
							<option value=" ">Select Gender</option> 
							<option value="Male">Male</option>
							<option value="Female">Female</option> 
						</select> 
						</div>
					</div>
					

					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Appoinment Date:') }}</label>
						<div class="col-md-4">
							<input id="appointmentDate" type="date" autocomplete="off" placeholder="eg: 1/1/2000" class="form-control"
							 name="appointmentDate" required>
						</div>
					</div>

					<div class="form-group row"> 
						<label class="col-md-4 col-form-label text-md-right" for="grade">&nbsp;&nbsp;&nbsp;Grade:</label>
							<div class="col-sm-10 col-md-6 col-lg-4">
								<select name="gradeId" id="gradeId" value="" class="form-control" required>
												<option value="">Select Grade</option>
												@foreach($gg as $gg)

												<option value="{{$gg->id}}">{{$gg->grade}}</option>
											@endforeach
								</select>
								<!-- <input type="text" class="form-control" name="grade" id="grade" placeholder="grade" autocomplete="off" readonly required>                   -->
							</div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Basic Pay:') }}</label>
						<div class="col-md-4">
							<input id="basicPay" type="number" autocomplete="off" placeholder="eg:30,000" class="form-control"
							 name="basicPay" required>
						</div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Employee Status:') }}</label>
						<div class="col-md-4">
							<input id="empStatus" type="text" autocomplete="off" placeholder="Active" class="form-control"
							 name="empStatus" required>
						</div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Last Date of Promotion:') }}</label>
						<div class="col-md-4">
							<input id="lastDop" type="date" autocomplete="off" placeholder="1/1/2000" class="form-control"
							 name="lastDop" required>
						</div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Mobile No:') }}</label>
						<div class="col-md-4">
							<input id="mobileNo" type="number" autocomplete="off" placeholder="eg: 17777777" class="form-control"
							 name="mobileNo" required>
						</div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Email id:') }}</label>
						<div class="col-md-4">
							<input id="emailId" type="text" autocomplete="off" placeholder="eg: yourname@bpc.bt" class="form-control"
							 name="emailId" required>
						</div>
					</div>
					<div class="form-group row">
					<label class="col-md-4 col-form-label text-md-right" for="grade">&nbsp;&nbsp;&nbsp;Place:</label>
						<div class="col-md-4">
						<select name="placeId" id="placeId" value="" class="form-control" required>
												<option value="">Select Place</option>
												@foreach($pp as $pp1)

												<option value="{{$pp1->placeId}}">{{$pp1->Address}}</option>
											@endforeach
								</select>
						</div>
					</div>

					<div class="form-group row"> 
						<label class="col-md-4 col-form-label text-md-right" for="designation">&nbsp;&nbsp;&nbsp;Designation:</label>
							<div class="col-sm-10 col-md-6 col-lg-4">
                <!-- <input type="text" class="form-control" name="designation" id="designation" placeholder="designation" autocomplete="off" readonly required>                   -->
							<select name="designationId" id="designationId" value="" class="form-control" required>
                                             <option value="">Select designation</option>
                                             @foreach($dg as $dg)

                                             <option value="{{$dg->id}}">{{$dg->desisNameLong}}</option>
										@endforeach
							</select>   
							</div>
            		</div>

					<div class="form-group row"> 
						<label class="col-md-4 col-form-label text-md-right" for="grade">&nbsp;&nbsp;&nbsp;Office:</label>
							<div class="col-sm-10 col-md-6 col-lg-4">
								<select name="office" id="office" value="" class="form-control" required>
												<option value="">Select Office</option>
												@foreach($ff as $ff)

												<option value="{{$ff->id}}">{{$ff->longOfficeName}}</option>
											@endforeach
								</select>
							</div>
					</div>

					<div class="form-group row">
                        <label for="bankname" class="col-md-4 col-form-label text-md-right">Bank name</label>
                        <div class="col-sm-10 col-md-6 col-lg-4">

                            <!-- <input type="text" class="form-control" id="gewogName" name="gewogName" value=""  required> -->
                            <select name="bankName" id="bankName" value="" class="form-control" required>
                                             <option value="">Select Bank name</option>
                                             @foreach($bk as $bk)

                                             <option value="{{$bk->id}}">{{$bk->bankName}}</option>
										@endforeach
							</select>
                        </div>
                    </div>



					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Bank account no:') }}</label>
						<div class="col-md-4">
							<input id="accountNumber" type="text" autocomplete="off" placeholder="eg: 200102384" class="form-control"
							 name="accountNumber" required>
						</div>
					</div>

					<div class="form-group row"> 
						<label class="col-md-4 col-form-label text-md-right" for="resignationtype">&nbsp;&nbsp;&nbsp;Resignation Type:</label>
							<div class="col-sm-10 col-md-6 col-lg-4">
							<select name="resignationTypeId" id="resignationTypeId" value="" class="form-control" required>
                                             <option value="">Select Resignation Type</option>
                                             @foreach($rg as $rg)

                                             <option value="{{$rg->id}}">{{$rg->resignationType}}</option>
										@endforeach
							</select>

							<!-- <input type="text" class="form-control" name="resignationtype" id="resignationtype" placeholder="resignationtype" autocomplete="off" readonly required>                   -->
						</div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Resignation Date:') }}</label>
						<div class="col-md-4">
							<input id="resignationDate" type="date" autocomplete="off" placeholder="eg: 1/1/2000" class="form-control"
							 name="resignationDate" required>
						</div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Employment Type:') }}</label>
						<div class="col-md-4">
							<input id="employmentType" type="text" autocomplete="off" placeholder="eg: regular/contract" class="form-control"
							 name="employmentType" required>
						</div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Increment Cycle:') }}</label>
						<div class="col-md-4">
							<input id="incrementCycle" type="text" autocomplete="off" placeholder="eg: Jan/July" class="form-control"
							 name="incrementCycle" required>
						</div>
					</div>



					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Role:') }}</label>
						<div class="col-md-4">
						<select class="form-control" name="role" id="role" required> @foreach($roles as $role)
								<option value="{{$role->id}}" 
								@if($role->name == 'Super Admin' || $role->name == 'Admin') disabled @endif>
								{{$role->name}}</option> 
								@endforeach </select>
						</div>
					</div>
					


					<!-- <div class="form-group row mb-0"> -->
					<div class="form-group row mb-0"> 
					<!--?php
							$connect = new PDO("mysql:host=localhost;dbname=hradsystem", "root", "");
							function fill_unit_select_box($connect)
							{ 
							$output = '';
							$query = "SELECT qualificationName,id FROM qualificationmaster ORDER BY qualificationName ASC";
							$statement = $connect->prepare($query);
							$statement->execute();
							$result = $statement->fetchAll();
							foreach($result as $row)
							{
							$output .= '<option value="'.$row["id"].'">'.$row["qualificationName"].'</option>';
							}
							return $output;
							}

							?-->

								<form method="post" id="insert_form">
								<!-- <span id="error"></span> -->
								<!-- <table align="right" class="table" id="item_table">
								<div class="col-lg-5">

								<label for="name" class="col-lg-10 col-form-label text-md-right">Choose Qualifications:</label>
								<span class="fas fa-plus btn-success btn-sm add"></span>
								
								</table> -->
								<div align="center" class="col-lg-12">
								<input type="submit" name="submit" class="btn btn-outline-success col-lg-2" value="Insert" />
								</div>
								</div>
								</div>

							</form>
							</body>
							</html>
						</div> 
					
						<!-- <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12 ">
							<button type="submit" class="btn btn-outline-success btn-save" id="bsubmit">{{ __('Create User') }}</button>
						</div> -->
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	document.getElementById('contenthead').innerHTML = '<strong></strong>';
});

function getEmployeeDetails(val) {
	//pulling records using cid from checkin table 
	var csrftoken = document.getElementById('tokenid').value;
	$.get('/getValues?source=useradd&info=' + val + '&token=' + csrftoken, function(data) {
		console.log(data);
		// document.getElementById('EmpId').value = '';
		// document.getElementById('EmpName').value = '';
		// document.getElementById('BloodGroup').value = '';
		// document.getElementById('cidNo').value = '';
		// document.getElementById('dob').value = '';
		// document.getElementById('gender').value = '';
		// document.getElementById('appointmentDate').value = '';
		// document.getElementById('basicPay').value = '';
		// document.getElementById('empStatus').value = '';
		// document.getElementById('lastDop').value = '';
		// document.getElementById('mobileNo').value = '';
		// document.getElementById('emailId').value = '';
		// document.getElementById('accountNumber').value = '';
		// document.getElementById('resignationDate').value = '';
		// document.getElementById('employmentType').value = '';
		// document.getElementById('incrementCycle').value = '';
		// document.getElementById('empid').innerHTML = '';
		$.each(data, function(index, Employee) {
			if(Employee.empId != null) {
				document.getElementById('empid').innerHTML = 'Already a user!!!';
				document.getElementById('emp_id').value = '';
			}
		})
	});
}

function pwdMatching() {
	var pwd = document.getElementById('password').value;
	var pwdConfirm = document.getElementById('password_confirm').value;
	if(pwd.length > 0 && pwdConfirm.length > 0) {
		if(pwd !== pwdConfirm) {
			document.getElementById('password').style = "border-color:red;";
			document.getElementById('password_confirm').style = "border-color:red;";
			alert("Passwords do not match.");
			return false;
		} else {
			document.getElementById('password').style = "";
			document.getElementById('password_confirm').style = "";
			return true;
		}
	}
}
</script>
<script>
function myFunction() {
	var x = document.getElementById("password");
	var passStatus = document.getElementById('pass-status1');
	if(x.type === "password") {
		x.type = "text";
		passStatus.className = 'fas fa-eye';
	} else {
		x.type = "password";
		passStatus.className = 'fas fa-eye-slash';
	}
}

function myFunction1() {
	var x = document.getElementById("password_confirm");
	var passStatus = document.getElementById('pass-status');
	if(x.type === "password") {
		x.type = "text";
		passStatus.className = 'fas fa-eye';
	} else {
		x.type = "password";
		passStatus.className = 'fas fa-eye-slash';
	}
}
</script>
<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
		});
		</script>


