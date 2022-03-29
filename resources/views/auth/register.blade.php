<!DOCTYPE html>
<html lang="en">
<head>

<style>
.reg{
	color:#ffffff;
}
.left{
	margin-left:35%;

}

</style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BPC Online System</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/admin-lte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/admin-lte/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition register-page">



<div class="register-box">
  <div class="register-logo">
   
  </div>


  @if(session()->has('success'))
            <div class="alert alert-success">
              {{ session()->get('success') }}
            </div>
@endif

  <div class="card">
    <div class="card-body register-card-body">
      <h4 class="login-box-msg">Register</h4>

      <form action="registerUser" method="post">
	  @csrf

        

<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">

	
        <div class="input-group mb-3">
          <input type="number" class="form-control" onKeyPress="if(this.value.length==8) return false; 
                    
                    
                    if( isNaN(String.fromCharCode(event.keyCode))) return false;" name="emp_id" id="emp_id" placeholder="Employee Number" 
					
					onKeyup="

				if(this.value.length==8)
				getEmployeeDetails(this.value)
		
				;"
					required>



					
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>

		  <div class="col-12">
                    <span id="empid" class="text-danger"></span>
        	</div>
		</div>

	
        <!-- <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" placeholder="Name" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

          <input type="hidden" class="form-control" name="firstTimeLogin" value="0" placeholder="firstTimeLogin">
       -->


		
		<!-- <div class="input-group mb-3">
          <input type="number"  class="form-control" id="contactNumber" 

		  onFocusOut="second(this.value)"
		  
		  onKeyPress="if(this.value.length==8) return false;

	
	
 
		  			
                    
                    
                    if( isNaN(String.fromCharCode(event.keyCode))) return false;" 
					
					
					name="contactNumber"  placeholder = "Mobile Number"
					
					onKeyup="

			

				if(this.value[0] != 1 || this.value[0] != 7)
				contacterror(this.value)
				
			
				if(this.value[0] == 1  || this.value[0] == 7 || this.value[0] == null)
				contact(this.value)
				;"
					required>

          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>

		  <div class="col-12">
                    <span id="cnumber" class="text-danger"></span>
        	</div>
        </div>

		<div class="input-group mb-3">
          <input type="text" class="form-control" name="designation" placeholder="Designation" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>


		<div class="input-group mb-3">
			<select class="form-control" name="dzongkhag"  id="dzongkhag" required>
							<option value="">Select Dzongkhag</option>
							@foreach($dzongkhag as $dzongkhags)
								<option name="dzongkhag" value="{{$dzongkhags->id}}">{{$dzongkhags->Dzongkhag_Name}}</option>
							@endforeach
			</select>          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>


		


		<div class="input-group mb-3">
		<select name="grade" id="grade" class="form-control" required>
		<option value=" ">Select Grade</option> 

				 @foreach($grade as $grade)

				<option value="{{$grade->id}}">
				@if($grade->id < 20)

				{{$grade->grade}}</option> 
				@endif
				@endforeach 
		</select>          
				<div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>


		<div class="input-group mb-3">
		<select name="gender" id="gender" class="form-control" required> 
				<option value=" ">Select Gender</option> 
				<option value="Male">Male</option>
				<option value="Female">Female</option> 


				
		</select>          
				<div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

		<div class="input-group mb-3">
		<select name="orgunit" id="orgunit" class="form-control" required>
		<option value=" ">Select Wing/Dept/Div </option>
		 @foreach($orgunit as $orgunit)
				<option value="{{$orgunit->id}}">{{$orgunit->description}}</option> @endforeach </select>          
				<div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
		<input type="hidden" value="0" class="form-control"  name="conferenceuser" placeholder="conferenceuser" required>


		<input type="hidden" value="62" class="form-control"  name="role" placeholder="role" required>
		<input type="hidden" value="1" class="form-control"  name="create" placeholder="create" required>

        <!-- <div class="input-group mb-3">
			<select class="form-control" name="role" id="role" required> @foreach($roles as $role)
				<option value="{{$role->id}}">{{$role->name}}</option> @endforeach </select>          
				<div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div> -->

		<!-- <div class="input-group mb-3">
				<input id="new_password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required>
			<div class="input-group-append"> <span class="input-group-text"> <i id="pass-status1" class="fas fa-eye-slash my-1 mx-1" onclick="myFunction()"></i> </span> </div>
			@error('password') <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span> @enderror 
			</div>
			

		

			<div class="input-group mb-3">
			<input id="new_confirm_password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required onFocusout="pwdMatching();">
			<div class="input-group-append"> <span class="input-group-text"> <i id="pass-status" class="fas fa-eye-slash my-1 mx-1" onclick="myFunction1()"></i> </span> </div>
			@error('password') <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span> @enderror 
			</div> -->
			

			<div class="input-group mb-3">
				<input id="email" type="email" placeholder="BPC Email" class="form-control" name="email" onFocusout="emailbpc();" required ">
			<div class="input-group-append"> <span class="input-group-text"> <i class="fas fa-envelope" ></i> </span> </div>
                                        
            </div> @error('password') <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span> @enderror 
			</div> 

		



			<div class="row">
							<div class="col-8">
							<div class="checkbox">
                                    
									  <label>

								
                                      </label>

                                  </div>
								
							</div>

						
							<div class="col-4">
								<button type="submit" class="btn btn-success mb-3"> {{ __('Register') }} </button>
							</div>
						</div>


		

		
		
		
			
		

			<!-- <div class="input-group mb-3 col-lg-6 text-center">
				<button type="submit" class="btn btn-success btn-block">Register</button>

      
     		 </div>

			  <div class="input-group mb-3 col-lg-6 text-center">
			  <a href="http://127.0.0.1:8000/login" class="btn btn-success">Login</a>

      
     		 </div> -->

          <!-- /.col -->
         
          <!-- /.col -->
        </div>
      </form>
	  

      

    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{asset('/admin-lte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/admin-lte/dist/js/adminlte.min.js')}}"></script>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	// document.getElementById('contenthead').innerHTML = '<strong></strong>';
});

function nima(val)
	{

		document.getElementById('empid').innerHTML = 'Check your employee number';
	}

function success(val)
	{

		document.getElementById('empid').innerHTML = '';
	}

	

	function contacterror(val)
	{

		document.getElementById('cnumber').innerHTML = 'Check your mobile number';
	}

	function contact(val)
	{

		document.getElementById('cnumber').innerHTML = '';
	}

	function getlength(val)
	{

		

		document.getElementById('contactNumber').innerHTML= 'Check your mobile number';

	}

	function second(){

		var value = document.getElementById('contactNumber').value[1];
		var v = document.getElementById('contactNumber').value[0];

		if((v == '1' && value == '6' )|| value == '7'){
		  

			document.getElementById('cnumber').innerHTML = '';  

		}  

		else{

		document.getElementById('cnumber').innerHTML = 'Check your mobile number';  
			                                               
		 document.getElementById('contactNumber').value = '';

		}

	}





function getEmployeeDetails(val) {
	//pulling records using cid from checkin table 
	var csrftoken = document.getElementById('tokenid').value;
	$.get('/getValues?source=useraddregister&info=' + val + '&token=' + csrftoken, function(data) {
		console.log(data);

		$.each(data, function(index, Employee) {
			if(Employee.emp_id != null) {
				// console.log(Employee.email);


				if(Employee.email === 'e'){
			
					document.getElementById('empid').innerHTML = ' '; 
				}

				else{

					document.getElementById('empid').innerHTML = 'Already a user!!!';
					document.getElementById('emp_id').value = '';

		        }



			}

			else {
				document.getElementById('empid').innerHTML = 'Not BPC Employee';
				document.getElementById('emp_id').value = '';

                }
		})
	});
}

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



function emailbpc() {
	var email = document.getElementById('email').value;
		if(email.indexOf('@bpc.bt') > 0) {

			document.getElementById('email').style = "";
			return true;
		
		}
		
		 else {
			document.getElementById('email').style = "border-color:red;";
			
			alert("Please enter bpc email.");
			return false;
			
			}
	
}
</script>
<script>
function myFunction() {
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

function myFunction1() {
	var x = document.getElementById("new_confirm_password");
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

