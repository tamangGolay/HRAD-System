<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header bg-green">Change Password</div>
				<div class="card-body">
					<form method="POST" action="changepassword"> @csrf @foreach ($errors->all() as $error)
						<p class="text-danger">{{ $error }}</p> @endforeach
						<div class="form-group row">
							<div class="alert alert-danger">
								<p>Current Password is Incorrect</p>
							</div>
							<label for="password" class="col-md-4 col-form-label text-md-right">Current Password</label>
							<div class="col-md-6">
								<div class="input-group">
									<input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
									<div class="input-group-append"> <span class="input-group-text"> <i id="pass-status1" class="fas fa-eye-slash my-1 mx-1" onclick="myFunction1()"></i> </span> </div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
							<div class="col-md-6">
								<div class="input-group">
									<input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
									<div class="input-group-append"> <span class="input-group-text"> <i id="pass-status2" class="fas fa-eye-slash my-1 mx-1" onclick="myFunction2()"></i> </span> </div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">New Confirm Password</label>
							<div class="col-md-6">
								<div class="input-group">
									<input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" onFocusout="pwdMatching();" autocomplete="current-password">
									<div class="input-group-append"> <span class="input-group-text"> <i id="pass-status3" class="fas fa-eye-slash my-1 mx-1" onclick="myFunction3()"></i> </span> </div>
								</div>
							</div>
						</div>
						<div class="form-group row mb-0">
							<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
								<button type="submit" class="btn btn-outline-success"> Update Password </button>
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
	document.getElementById('contenthead').innerHTML = '<strong>Change Password</strong>';
});

function myFunction1() {
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

function myFunction2() {
	var x = document.getElementById("new_password");
	var passStatus = document.getElementById('pass-status2');
	if(x.type === "password") {
		x.type = "text";
		passStatus.className = 'fas fa-eye';
	} else {
		x.type = "password";
		passStatus.className = 'fas fa-eye-slash';
	}
}

function myFunction3() {
	var x = document.getElementById("new_confirm_password");
	var passStatus = document.getElementById('pass-status3');
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
</script>