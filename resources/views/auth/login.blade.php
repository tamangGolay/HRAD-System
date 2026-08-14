<?php
header('X-Frame-Options: SAMEORIGIN');
?>

@extends('layouts.masterdefault')
@section('title', 'Login')
@section('content')
<style>
	.auth-login-page {
		min-height: 100vh;
		display: flex;
		align-items: center;
		justify-content: center;
		overflow: hidden;
		padding: 2rem 1rem;
		perspective: 1000px;
	}

	.auth-login-box {
		width: 100%;
		max-width: 430px;
		animation: loginCardEnter .45s ease-out both;
	}

	.auth-login-card {
		border: 0;
		border-radius: 8px;
		box-shadow: 0 1rem 2.5rem rgba(0, 0, 0, .12);
		margin-bottom: 0;
		overflow: hidden;
		transition: box-shadow .25s ease, transform .25s ease;
	}

	.auth-login-card:hover {
		box-shadow: 0 1.25rem 3rem rgba(0, 0, 0, .16);
		transform: translateY(-4px);
	}

	.auth-login-card::before {
		background: #28a745;
		content: "";
		display: block;
		height: 4px;
	}

	.auth-login-card .login-card-body {
		padding: 2rem;
	}

	.auth-login-title {
		margin-bottom: 1.5rem;
		text-align: center;
	}

	.auth-login-logo-wrap {
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

	.auth-login-logo {
		border-radius: 0 !important;
		display: block;
		height: auto;
		max-width: 66px;
	}

	.auth-toast-wrap {
		display: grid;
		gap: .75rem;
		margin-bottom: 1.1rem;
		pointer-events: none;
		width: 100%;
	}

	.auth-toast {
		align-items: flex-start;
		animation: toastEnter .35s ease-out both;
		background: #fff;
		border: 1px solid rgba(0, 0, 0, .06);
		border-radius: 8px;
		box-shadow: 0 .9rem 2.25rem rgba(0, 0, 0, .16);
		color: #343a40;
		display: flex;
		gap: .85rem;
		line-height: 1.45;
		margin-bottom: 0;
		overflow: hidden;
		padding: 1rem 1rem 1rem 1.1rem;
		pointer-events: auto;
		position: relative;
	}

	.auth-toast::before {
		bottom: 0;
		content: "";
		left: 0;
		position: absolute;
		top: 0;
		width: 5px;
	}

	.auth-toast-danger::before {
		background: #dc3545;
	}

	.auth-toast-success::before {
		background: #28a745;
	}

	.auth-toast-icon {
		align-items: center;
		border-radius: 50%;
		display: inline-flex;
		flex: 0 0 38px;
		height: 38px;
		justify-content: center;
		margin-left: .2rem;
		width: 38px;
	}

	.auth-toast-danger .auth-toast-icon {
		background: rgba(220, 53, 69, .12);
		color: #dc3545;
	}

	.auth-toast-success .auth-toast-icon {
		background: rgba(40, 167, 69, .12);
		color: #28a745;
	}

	.auth-toast-content {
		flex: 1;
		min-width: 0;
	}

	.auth-toast-title {
		color: #212529;
		display: block;
		font-size: .94rem;
		font-weight: 700;
		margin-bottom: .15rem;
	}

	.auth-toast-message {
		color: #495057;
		display: block;
		font-weight: 500;
	}

	.auth-toast-close {
		background: transparent;
		border: 0;
		border-radius: 50%;
		color: #6c757d;
		cursor: pointer;
		flex: 0 0 auto;
		font-size: 1.25rem;
		height: 30px;
		line-height: 1;
		opacity: .85;
		padding: 0;
		transition: background .2s ease, color .2s ease, opacity .2s ease, transform .2s ease;
		width: 30px;
	}

	.auth-toast-close:hover,
	.auth-toast-close:focus {
		background: rgba(0, 0, 0, .05);
		color: #212529;
		opacity: 1;
		outline: none;
		transform: scale(1.08);
	}

	.auth-toast.is-dismissing {
		opacity: 0;
		transform: translateX(24px);
		transition: opacity .2s ease, transform .2s ease;
	}

	.auth-login-title h4 {
		margin-bottom: .25rem;
		font-weight: 600;
	}

	.auth-login-card .form-group {
		margin-bottom: 1.1rem;
	}

	.auth-login-card .input-group {
		border-radius: 8px;
		transition: box-shadow .2s ease, transform .2s ease;
	}

	.auth-login-card .input-group:focus-within {
		box-shadow: 0 .45rem 1rem rgba(0, 0, 0, .08);
		transform: translateY(-1px);
	}

	.auth-login-card .form-control,
	.auth-login-card .input-group-text {
		transition: border-color .2s ease, box-shadow .2s ease;
	}

	.auth-login-actions {
	display: flex;
	justify-content: center;
	margin-top: 1.25rem;
	}

	.auth-login-actions .btn {
		width: 100%;
		max-width: 180px;
		transition: box-shadow .2s ease, transform .2s ease;
	}

	.auth-login-actions .btn-block {
		margin-top: 0;
	}

	.auth-login-actions .btn:hover,
	.auth-login-actions .btn:focus {
		box-shadow: 0 .55rem 1rem rgba(0, 0, 0, .12);
		transform: translateY(-2px);
	}

	.nima {
		background: #fff;
		color: blue;
		display: inline-block;
		margin-top: .25rem;
	}
	a:hover {
		text-decoration: none;
	}

	.password-toggle {
		cursor: pointer;
	}

	.password-toggle:focus {
		outline: none;
	}

	@keyframes loginCardEnter {
		from {
			opacity: 0;
			transform: translateY(18px) scale(.98);
		}

		to {
			opacity: 1;
			transform: translateY(0) scale(1);
		}
	}

	@keyframes toastEnter {
		from {
			opacity: 0;
			transform: translateY(-8px) scale(.98);
		}

		to {
			opacity: 1;
			transform: translateY(0) scale(1);
		}
	}

	@media (prefers-reduced-motion: reduce) {
		.auth-login-box,
		.auth-login-card,
		.auth-login-logo-wrap,
		.auth-toast,
		.auth-toast-close,
		.auth-login-card .input-group,
		.auth-login-actions .btn,
		.auth-login-card .form-control,
		.auth-login-card .input-group-text {
			animation: none;
			transition: none;
		}

		.auth-login-card:hover,
		.auth-login-logo-wrap:hover,
		.auth-login-card .input-group:focus-within,
		.auth-login-actions .btn:hover,
		.auth-login-actions .btn:focus {
			transform: none;
		}
	}

	@media only screen and (max-width: 575.98px) {
		.auth-login-page {
			align-items: flex-start;
			padding-top: 3rem;
		}

		.auth-login-card .login-card-body {
			padding: 1.5rem;
		}

		.auth-login-actions {
			grid-template-columns: 1fr;
		}
	}
</style>

<div class="auth-login-page hold-transition login-page">
	<div class="login-box auth-login-box">
		<div class="card auth-login-card">
			<div class="card-body login-card-body">
				<div class="auth-login-title">
					<div class="auth-login-logo-wrap">
						<img src="{{ asset('assets/images/logo-1.png') }}" class="auth-login-logo" alt="BPC logo">
					</div>
					<h4>{{ __('Sign in') }}</h4>
					<p class="login-box-msg mb-0">BPC Online System</p>
				</div>

				@if(session()->has('success') || session()->has('error'))
					<div class="auth-toast-wrap" aria-live="polite" aria-atomic="true">
						@if(session()->has('success'))
							<div class="auth-toast auth-toast-success" role="status">
								<span class="auth-toast-icon">
									<i class="fas fa-check"></i>
								</span>
								<span class="auth-toast-content">
									<span class="auth-toast-title">Success</span>
									<span class="auth-toast-message">{{ session()->get('success') }}</span>
								</span>
								<button type="button" class="auth-toast-close" onclick="dismissToast(this)" aria-label="Close message">&times;</button>
							</div>
						@endif

						@if(session()->has('error'))
							<div class="auth-toast auth-toast-danger" role="alert">
								<span class="auth-toast-icon">
									<i class="fas fa-exclamation-triangle"></i>
								</span>
								<span class="auth-toast-content">
									<span class="auth-toast-title">Unable to Sign In</span>
									<span class="auth-toast-message">{{ session()->get('error') }}</span>
								</span>
								<button type="button" class="auth-toast-close" onclick="dismissToast(this)" aria-label="Close message">&times;</button>
							</div>
						@endif
					</div>
				@endif

				<form method="POST" action="{{ route('login') }}">
					@csrf

					<div class="form-group">
						<label for="emp_id">{{ __('Employee Number') }}</label>
						<div class="input-group">
							<input
								id="emp_id"
								type="text"
								inputmode="numeric"				
								placeholder="Employee Number"
								class="form-control @error('empId') is-invalid @enderror"
								name="empId"
								value="{{ old('empId') }}"
								required
								autocomplete="username"
								onKeyPress="if(this.value.length==8) return false; if(isNaN(String.fromCharCode(event.keyCode))) return false;"
								autofocus
							>
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-user"></span>
								</div>
							</div>
							@error('empId')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
					</div>

					<div class="form-group mb-2">
						<label for="password">{{ __('Password') }}</label>
						<div class="input-group">
							<input
								id="password"
								type="password"
								placeholder="Password"
								class="form-control @error('password') is-invalid @enderror"
								name="password"
								required
								autocomplete="current-password"
							>
							<div class="input-group-append">
								<button type="button" class="input-group-text password-toggle" onclick="togglePassword()" aria-label="Show password">
									<i id="pass-status" class="fas fa-eye-slash my-1 mx-1"></i>
								</button>
							</div>
							@error('password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
					</div>

					<div class="text-right">
						<a class="nima" href="{{ route('forget.password.get') }}">Forgot Password?</a>
					</div>

					<div class="auth-login-actions">
						<button type="submit" class="btn btn-success btn-block">Login</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function togglePassword() {
		var passwordInput = document.getElementById('password');
		var passStatus = document.getElementById('pass-status');

		if (passwordInput.type === 'password') {
			passwordInput.type = 'text';
			passStatus.className = 'fas fa-eye';
		} else {
			passwordInput.type = 'password';
			passStatus.className = 'fas fa-eye-slash';
		}
	}

	function dismissToast(button) {
		var toast = button.closest('.auth-toast');

		if (!toast) {
			return;
		}

		toast.classList.add('is-dismissing');
		setTimeout(function () {
			toast.remove();
		}, 220);
	}
</script>
@endsection
