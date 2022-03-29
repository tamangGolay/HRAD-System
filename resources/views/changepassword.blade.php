<!-- Stored in resources/views/pages/dispatch.blade.php -->@extends('layouts.masterstartpage') @section('pagehead')
<!-- c_booking -->
<style>
.chgpsswd{

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
				<div class="chgpsswd card-header bg-green text-center">
                     <p>Change Password</p>
                    </div>
				<div class="card-body">
					<form method="POST" action="changepasswordstart"> @csrf
						<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}"> @foreach ($errors->all() as $error)
						<p class="text-danger">{{ $error }}</p> @endforeach
						<div class="textfont form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">Current Password</label>
							<div class="col-md-6">
								<div class="input-group">
									<input type="password" class="form-control" id="current_password" name="current_password" onFocusOut="pwdcurrent(this.value);" autocomplete="current-password" required>
									<div class="input-group-append"> <span class="input-group-text"> <i id="pass-status1" class="fas fa-eye-slash my-1 mx-1" onclick="myFunction1()"></i> </span> </div>
								</div>
							</div>
							<div class="col"> <span id="currentpasswd" class="text-danger"></span> </div>
						</div>
						<div class="textfont form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
							<div class="col-md-6">
								<div class="input-group">
									<input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password" required>
									<div class="input-group-append"> <span class="input-group-text"> <i id="pass-status2" class="fas fa-eye-slash my-1 mx-1" onclick="myFunction2()"></i> </span> </div>
								</div>
							</div>
						</div>
						<div class="textfont form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">New Confirm Password</label>
							<div class="col-md-6">
								<div class="input-group">
									<input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" onFocusout="pwdMatching();" autocomplete="current-password" required>
									<div class="input-group-append"> <span class="input-group-text"> <i id="pass-status3" class="fas fa-eye-slash my-1 mx-1" onclick="myFunction3()"></i> </span> </div>
								</div>
							</div>
						</div>
						<div class="textfont form-group row mb-0">
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
	var x = document.getElementById("current_password");
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
// function pwdMatchingnew()
//  {
//     var d = document.getElementById('new_password').value;
//     var m = document.getElementById('current_password').value;
//     if(d.length > 0 && m.length > 0)
//     {
//         if(d == m) {
//             document.getElementById('new_password').style="border-color:red;";
//             document.getElementById('new_password').value=" ";
//             document.getElementById('current_password').style="border-color:red;";
//             alert("New password cannot be current password.");
//             return false;
//         }
//         else {
//             document.getElementById('new_password').style="";
//             document.getElementById('current_password').style="";
//             return true;
//         }
//     }
// }
function pwdMatching() {
	var pwd = document.getElementById('new_password').value;
	var pwdConfirm = document.getElementById('new_confirm_password').value;
	if(pwd.length > 0 && pwdConfirm.length > 0) {
		if(pwd !== pwdConfirm) {
			document.getElementById('new_password').style = "border-color:red;";
			document.getElementById('new_confirm_password').style = "border-color:red;";
			document.getElementById('new_confirm_password').value = "";
			alert("Passwords do not match.");
			return false;
		}
		if(document.getElementById('new_password').value.length < 8 && document.getElementById('new_confirm_password').value.length < 8){

			document.getElementById('new_password').style = "border-color:red;";
			document.getElementById('new_confirm_password').style = "border-color:red;";
			document.getElementById('new_confirm_password').value = "";

			alert("Password should contain atleast 8 characters, one upper case letter, one lower case letter and a number");



			return false;

		}

		if(document.getElementById('new_password').value.search(/[A-Z]/) == -1 &&
		document.getElementById('new_confirm_password').value.search(/[A-Z]/) == -1
		 ){

			document.getElementById('new_password').style = "border-color:red;";
			document.getElementById('new_confirm_password').style = "border-color:red;";
			document.getElementById('new_confirm_password').value ="";

			alert("Password should contain atleast 8 characters, one upper case letter, one lower case letter and a number");
			
			return false;

		}

		if(document.getElementById('new_password').value.search(/[a-z]/) == -1 &&
		document.getElementById('new_confirm_password').value.search(/[a-z]/) == -1
		 ){

			document.getElementById('new_password').style = "border-color:red;";
			document.getElementById('new_confirm_password').style = "border-color:red;";
			document.getElementById('new_confirm_password').value ="";

			alert("Password should contain atleast 8 characters, one upper case letter, one lower case letter and a number");
			
			return false;

		}

		if(document.getElementById('new_password').value.search(/[0-9]/) == -1 &&
		document.getElementById('new_confirm_password').value.search(/[0-9]/) == -1
		 ){

			document.getElementById('new_password').style = "border-color:red;";
			document.getElementById('new_confirm_password').style = "border-color:red;";
			document.getElementById('new_confirm_password').value ="";

			alert("Password should contain atleast 8 characters, one upper case letter, one lower case letter and a number");
				
			return false;

		}
		 else {
			document.getElementById('new_password').style = "";
			document.getElementById('new_confirm_password').style = "";
			return true;
		}
	}
}

function pwdcurrent(val) {
	//pulling records using cid from checkin table 
	var csrftoken = document.getElementById('tokenid').value;
	$.get('/getValues?source=currentpassword&info=' + val + '&token=' + csrftoken, function(data) {
		console.log(data);
		document.getElementById('currentpasswd').innerHTML = '';
		$.each(data, function(index, Employee) {
			if(Employee.password != null) {
				document.getElementById('currentpasswd').innerHTML = '';
			} else {
				document.getElementById('currentpasswd').innerHTML = 'Current password did not match!!!';
				document.getElementById('current_password').value = '';
			}
		})
	});
}
</script> @endsection
<!-- nima -->