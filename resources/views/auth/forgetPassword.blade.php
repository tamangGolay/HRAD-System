@extends('layout')

@section('content')

<style>
	.forgot-page {
		min-height: 100vh;
		display: flex;
		align-items: center;
		justify-content: center;
		overflow: hidden;
		padding: 2rem 1rem;
		background: #f4f6f9;
		perspective: 1000px;
	}

	.forgot-wrapper {
		width: 100%;
		max-width: 430px;
		animation: forgotCardEnter .45s ease-out both;
	}

	.forgot-card {
		background: #fff;
		border-radius: 8px;
		box-shadow: 0 1rem 2.5rem rgba(0, 0, 0, .12);
		overflow: hidden;
		border: 0;
		margin-bottom: 0;
		transition: box-shadow .25s ease, transform .25s ease;
	}

	.forgot-card:hover {
		box-shadow: 0 1.25rem 3rem rgba(0, 0, 0, .16);
		transform: translateY(-4px);
	}

	.forgot-card::before {
		background: #28a745;
		content: "";
		display: block;
		height: 4px;
	}

	.forgot-header {
		color: #212529;
		text-align: center;
		padding: 2rem 2rem 1rem;
		background: #fff;
	}

	.forgot-logo {
		align-items: center;
		background: #fff;
		border-radius: 8px;
		display: inline-flex;
		min-height: 88px;
		justify-content: center;
		margin-bottom: 1rem;
		padding: .55rem;
		width: 88px;
	}

	.forgot-logo img {
		border-radius: 0 !important;
		display: block;
		height: auto;
		max-width: 66px;
	}

	.forgot-header h4 {
		margin-bottom: .25rem;
		font-weight: 600;
	}

	.forgot-header p {
		margin-bottom: 0;
		font-size: .92rem;
		color: #6c757d;
	}

	.forgot-body {
		padding: 0 2rem 2rem;
	}

	.forgot-info {
		background: #fff;
		border: 1px solid rgba(40, 167, 69, .18);
		border-left: 5px solid #28a745;
		border-radius: 8px;
		padding: .9rem 1rem;
		font-size: .9rem;
		color: #2f5135;
		margin-bottom: 1.4rem;
		box-shadow: 0 .45rem 1rem rgba(0, 0, 0, .05);
	}

	.forgot-card .form-group {
		margin-bottom: 1.1rem;
	}

	.forgot-card label {
		font-weight: 600;
		font-size: .92rem;
	}

	.forgot-card .form-control {
		height: 46px;
		border-radius: 8px;
		transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
	}

	.forgot-card .form-control:focus {
		border-color: #28a745;
		box-shadow: 0 .45rem 1rem rgba(0, 0, 0, .08);
		transform: translateY(-1px);
	}

	#email[readonly] {
		background-color: #fff !important;
		opacity: 1;
		color: #495057;
	}

	.forgot-actions {
		display: flex;
		flex-direction: column;
		gap: .8rem;
		margin-top: 1.25rem;
	}

	.forgot-actions .btn {
		border-radius: 8px;
		padding: .65rem;
		font-weight: 600;
		transition: box-shadow .2s ease, transform .2s ease;
	}

	.forgot-actions .btn:hover,
	.forgot-actions .btn:focus {
		box-shadow: 0 .55rem 1rem rgba(0, 0, 0, .12);
		transform: translateY(-2px);
	}

	.back-login {
		text-align: center;
		font-size: .9rem;
		font-weight: 500;
		color: blue;
		text-decoration: none;
		display: inline-block;
		margin-top: .25rem;
	}

	.back-login:hover {
		text-decoration: none;
		color: #0056b3;
	}

	.forgot-alert {
		border-radius: 8px;
		font-weight: 500;
	}

	@keyframes forgotCardEnter {
		from {
			opacity: 0;
			transform: translateY(18px) scale(.98);
		}

		to {
			opacity: 1;
			transform: translateY(0) scale(1);
		}
	}

	@media only screen and (max-width: 575.98px) {
		.forgot-page {
			align-items: flex-start;
			padding-top: 3rem;
		}

		.forgot-header {
			padding: 1.5rem 1.5rem 1rem;
		}

		.forgot-body {
			padding: 0 1.5rem 1.5rem;
		}
	}
</style>

<div class="forgot-page">
	<div class="forgot-wrapper">
		<div class="forgot-card">

			<div class="forgot-header">
				<div class="forgot-logo">
					<img src="{{ asset('assets/images/logo-1.png') }}" alt="BPC logo">
				</div>
				<h4>Reset Password</h4>
				<p>Enter your employee ID to receive password reset link.</p>
			</div>

			<div class="forgot-body">

				@if (Session::has('message'))
					<div class="alert alert-success forgot-alert" role="alert">
						{{ Session::get('message') }}
					</div>
				@endif

				<form action="{{ route('forget.password.post') }}" method="POST">
					@csrf

					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token() }}">

					<div class="forgot-info">
						<i class="fas fa-info-circle"></i>
						Your registered email will appear automatically after entering a valid Employee ID.
					</div>

					<div class="form-group">
						<label for="empid">Employee ID</label>
						<input
							type="text"
							inputmode="numeric"
							class="form-control"
							name="empid"
							id="empid"
							placeholder="Enter Employee ID"
							required
							autofocus
							onKeyPress="if(this.value.length==8) return false; if(isNaN(String.fromCharCode(event.keyCode))) return false;"
							onKeyup="if(this.value.length==8) getEmployeeDetails(this.value);"
						>
					</div>

					<div class="form-group">
						<label for="email">Registered Email Address</label>
						<input
							type="text"
							id="email"
							class="form-control"
							name="email"
							placeholder="Email will appear here"
							readonly
						>

						@if ($errors->has('email'))
							<span class="text-danger">
								{{ $errors->first('email') }}
							</span>
						@endif
					</div>

					<div class="forgot-actions">
						<button type="submit" class="btn btn-success" onClick="return empty()">
							Reset Password
						</button>

						<a class="back-login" href="{{ route('login') }}">
							Back to Login
						</a>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>

@endsection

<script src="{{ asset('/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/admin-lte/dist/js/adminlte.min.js') }}"></script>

<script>
	function empty() {
		var email = document.getElementById("email").value;

		if (email == "" || email == "e") {
			alert("You are not a valid user");
			return false;
		}
	}

	function getEmployeeDetails(val) {
		var csrftoken = document.getElementById('tokenid').value;

		$.get('/getValues?source=forgetPassword&info=' + val + '&token=' + csrftoken, function(data) {
			document.getElementById('email').value = '';

			$.each(data, function(index, Employee) {
				if (Employee.emailId != null) {
					document.getElementById('email').value = Employee.emailId;
				} else {
					document.getElementById('email').value = '';
					alert('Please check your Employee ID!');
				}
			});
		});
	}
</script>