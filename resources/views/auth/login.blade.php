<?php
header('X-Frame-Options: SAMEORIGIN');
?> 

<style>

@media only screen and (min-width: 1200px){
.login-boxn{
	margin: auto;
  width: 50%;
  padding: 10px;
}

input[type=text]{
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  resize: vertical;
}
.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}
.row:after {
  content: "";
  display: table;
  clear: both;
}

}
.nima{
	
	background: #fff;
    color: blue;
	margin-left: 60%;
	

}
.reg{
	color:#ffffff;

}

a:hover{
	text-decoration:none;
}


</style>
  
@extends('layouts.masterdefault') @section('title', 'Login') @section('content')
	<div class="hold-transition login-page">
		<div class="login-box login-boxn">
		@if(session()->has('success'))
            <div class="alert alert-success">
              {{ session()->get('success') }}
            </div>
		@endif
			<div class="card">
				<div class="card-body login-card-body">
					<div class="login-box-msg">{{ __('Sign in') }}</div>
					<form method="POST" action="{{ route('login') }}"> @csrf @if(session()->has('error'))
						<div class="alert alert-danger"> {{ session()->get('error') }} </div> @endif
						<div class="form-group row">
							<!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> -->
							<div class="input-group mb-3 col-75">
								<input id="emp_id" type="number" placeholder="Employee Number" class="form-control" name="empId" value="{{ old('emp_id') }}" required autocomplete="email" onKeyPress="if(this.value.length==8) return false; 
                    
                    if( isNaN(String.fromCharCode(event.keyCode))) return false;" autofocus>
								<div class="input-group-append">
									<div class="input-group-text"> </span> </div>
								</div> @error('email') <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror </div>
						</div>
						<div class="form-group row">
							<!-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> -->
							<div class="input-group ">
								<input id="password" type="password" placeholder="Password" class="form-control" name="password" required>
								<div class="input-group-append"> <span class="input-group-text"> <i id="pass-status" class="fas fa-eye-slash my-1 mx-1" onclick="myFunction()"></i> </span> </div>
								<!-- <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-lock" style="color:brown"></span>
                                        </div>
                                    </div> -->@error('password') <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror </div>
						</div>
						<a class="nima" href="{{ route('forget.password.get') }}">Forgot Password?</a>
						<!-- <div class="form-group row">
                              <div class="col-md-6 offset-md-4">
                                  <div class="checkbox">
                                      <label>
                                          <a href="{{ route('forget.password.get') }}">Reset Password</a>
                                      </label>
                                  </div>
                              </div>
                          </div> -->
						</div>
						
						<div class="row col-12 ml-4 mb-3">

						<div class="col-4 ml-1">
							<button class="btn btn-success">Login</button>

							</div>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<div class="col-4">
								<button type="submit" class="btn btn-success"><a href="{{ route('register')}}" class="reg">Register</a></button>
								
                                <!-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif -->     
								                                 
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
	function myFunction() {
		var x = document.getElementById("password");
		var passStatus = document.getElementById('pass-status');
		if(x.type === "password") {
			x.type = "text";
			passStatus.className = 'fas fa-eye';
		} else {
			x.type = "password";
			passStatus.className = 'fas fa-eye-slash';
		}
	}
	</script> @endsection