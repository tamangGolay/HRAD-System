
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
					
                        <b>Add User</b>
                     </div>
				<div class="card-body">
				<form method="POST" action="user" onsubmit="return pwdMatching();"> @csrf
					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
					<div class="form-group row">
						<label for="emp_id" class="col-md-4 col-form-label text-md-right">{{ __('Employee Number:') }}</label>
						<div class="col-md-4">
							<input id="emp_id" type="number" placeholder="Employee Number" onKeyPress="if(this.value.length==8) return false;" class="form-control @error('emp_id') is-invalid @enderror" name="emp_id" value="{{ old('emp_id') }}" required autocomplete="emp_id" onFocusOut="getEmployeeDetails(this.value);"> </div> <span id="info" class="text-danger text-md-right"></span>
						<div class="col-sm-2"> <span id="empid" class="text-danger"></span> </div>
					</div>
					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name:') }}</label>
						<div class="col-md-4">
							<input id="nameid" type="text" autocomplete="off" placeholder="Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name"> </div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number:') }}</label>
						<div class="col-md-4">
							<input id="contact_number" type="number" autocomplete="off" placeholder="Contact Number" class="form-control" name="contact_number" required> </div>
					</div>

					<div class="form-group row">
						<label for="designation" class="col-md-4 col-form-label text-md-right">{{ __('Designation:') }}</label>
						<div class="col-md-4">
							<input id="designation" type="text" autocomplete="off" placeholder="Designation" class="form-control" name="designation" required> </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="orgunit">{{ __('Wing/Dept/Div:') }}</label>
						<div class="col-sm-4">
							<select name="orgunit" id="orgunit" class="form-control" required> @foreach($orgunit as $orgunit)
								<option value="{{$orgunit->id}}">{{$orgunit->description}}</option> @endforeach </select>
						</div>
					</div>


					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="orgunit">{{ __('Grade:') }}</label>
						<div class="col-sm-4">
						<select name="grade" id="grade" class="form-control" required>
				<option value=" ">Select Grade</option> 

					@foreach($grade as $grade)

					<option value="{{$grade->id}}">
					@if($grade->id < 20)

					{{$grade->grade}}</option> 
					@endif
					@endforeach 
			</select> 
						</div>
					</div>




			


					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="orgunit">{{ __('Select Gender:') }}</label>
						<div class="col-sm-4">
						<select name="gender" id="gender" class="form-control" required> 
							<option value=" ">Select Gender</option> 
							<option value="Male">Male</option>
							<option value="Female">Female</option> 
						</select> 
						</div>
					</div>


					
					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="dzongkhag">{{ __('Select Gender:') }}</label>
						<div class="col-sm-4">
						<select  class="form-control" name="dzongkhag"  id="dzongkhag" required>
							<option value="">Select Dzongkhag</option>
							@foreach($dzongkhag as $dzongkhags)
								<option name="dzongkhag" value="{{$dzongkhags->id}}">{{$dzongkhags->Dzongkhag_Name}}</option>
							@endforeach
						</select>
						</div>
					</div>



					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="role">{{ __('Role:') }}</label>
						<div class="col-sm-4">
							<select class="form-control" name="role" id="role" required> @foreach($roles as $role)
								<option value="{{$role->id}}">{{$role->name}}</option> @endforeach </select>
						</div>
					</div>
					<div class="form-group row">
						<label for="conferenceuser" class="col-md-4 col-form-label text-md-right">{{ __('Conference User:') }}</label>
						<div class="col-md-4">
							<div class="input-group ">
								<input type="text" class="form-control" name="conferenceuser" autocomplete="off" placeholder=" 1 = Conference User or 0 = other employee" required />
								<div class="input-group-append"> </div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="password" class="col-md-4 col-form-label text-md-right">Password:</label>
						<div class="col-md-4">
							<div class="input-group ">
								<input id="password" type="password" autocomplete="off" class="form-control @error('password') is-invalid @enderror" name="password" required />
								<div class="input-group-append"> <span class="input-group-text"> <i id="pass-status1" class="fas fa-eye-slash my-1 mx-1" onclick="myFunction()"></i> </span> </div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="password_confirm" class="col-md-4 col-form-label text-md-right">Confirm Password:</label>
						<div class="col-md-4">
							<div class="input-group">
								<input id="password_confirm" type="password" autocomplete="off" class="form-control" name="password_confirmation" required onFocusout="pwdMatching();">
								<div class="input-group-append"> <span class="input-group-text"> <i id="pass-status" class="fas fa-eye-slash my-1 mx-1" onclick="myFunction1()"></i> </span> </div>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="orgunit">{{ __('BPC Email:') }}</label>
						<div class="col-sm-4">

						<div class="input-group">
								<input id="email" type="email" autocomplete="off" class="form-control" name="email" required>
								<div class="input-group-append"> </div>
							</div>
					
						</div>
					</div>

					<div class="form-group row mb-0">
						<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12 ">
							<button type="submit" class="btn btn-outline-success btn-save" id="bsubmit">{{ __('Create User') }}</button>
						</div>
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
		document.getElementById('nameid').value = '';
		document.getElementById('empid').innerHTML = '';
		$.each(data, function(index, Employee) {
			if(Employee.emp_id != null) {
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