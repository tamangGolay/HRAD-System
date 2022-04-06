
@if(session()->has('message'))
<div class="alert alert-danger"> {{ session()->get('message') }} </div> @endif @if(session()->has('success'))
<div class="alert alert-success"> {{ session()->get('success') }} </div> @endif
<div class="container">
	<div class="row ">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header bg-green text-center">
					<h5>
                        <b>Reset Password</b>
                    </h5> </div>
				<div class="card-body">
					<form method="POST" action="resetpassword"> @csrf
						<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}"> @foreach ($errors->all() as $error)
						<p class="text-danger">{{ $error }}</p> @endforeach
						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">Employee Number</label>
							<div class="col-md-6">
								<input id="emp_id" type="number" class="form-control" name="emp_id" onFocusOut="getEmployeeDetails(this.value);" required> </div>
							<div class="col-sm-2"> <span id="empid" class="text-danger"></span> </div>
						</div>
						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
							<div class="col-md-6">
								<div class="input-group">
									<input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
									<div class="input-group-append"> <span class="input-group-text"> <i id="pass-status1" class="fas fa-eye-slash my-1 mx-1" onclick="myFunction1()"></i> </span> </div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">New Confirm Password</label>
							<div class="col-md-6">
								<div class="input-group">
									<input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" onFocusout="pwdMatching();" autocomplete="current-password">
									<div class="input-group-append"> <span class="input-group-text"> <i id="pass-status2" class="fas fa-eye-slash my-1 mx-1" onclick="myFunction2()"></i> </span> </div>
								</div>
							</div>
						</div>
						<div class="form-group row mb-0">
							<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
								<button type="submit" class="btn btn-outline-success"> Reset Password </button>
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

function myFunction1() {
	var x = document.getElementById("new_password");
	var passStatus = document.getElementById('pass-status1');
	if(x.type === "password") {
		x.type = "text";
		passStatus.className = 'fas fa-eye';
	} else {
		x.type = "password";
		passStatus.className = 'fas fa-eye-slash';
	}
}

function myFunction2() {
	var x = document.getElementById("new_confirm_password");
	var passStatus = document.getElementById('pass-status2');
	if(x.type === "password") {
		x.type = "text";
		passStatus.className = 'fas fa-eye';
	} else {
		x.type = "password";
		passStatus.className = 'fas fa-eye-slash';
	}
}

function pwdMatching() {
	var pwd = document.getElementById('new_password').value;
	var pwdConfirm = document.getElementById('new_confirm_password').value;
	if(pwd.length > 0 && pwdConfirm.length > 0) {
		if(pwd !== pwdConfirm) {
			document.getElementById('new_password').style = "border-color:red;";
			document.getElementById('new_confirm_password').style = "border-color:red;";
			alert("Passwords do not match.");
			return false;
		} else {
			document.getElementById('new_password').style = "";
			document.getElementById('new_confirm_password').style = "";
			return true;
		}
	}
}

function getEmployeeDetails(val) {
	//pulling records using cid from checkin table 
	var csrftoken = document.getElementById('tokenid').value;
	$.get('/getValues?source=useradd&info=' + val + '&token=' + csrftoken, function(data) {
		document.getElementById('empid').innerHTML = '';
		$.each(data, function(index, Employee) {
			if(Employee.emp_id != null) {} else {
				document.getElementById('empid').innerHTML = 'Not a user!!!';
				document.getElementById('emp_id').value = '';
			}
		})
	});
}
</script>

<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
		});
		</script>
