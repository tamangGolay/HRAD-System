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
		transition:
			border-color .2s ease,
			box-shadow .2s ease,
			transform .2s ease;
	}

	.forgot-card .form-control:focus {
		border-color: #28a745;
		box-shadow: 0 .45rem 1rem rgba(0, 0, 0, .08);
		transform: translateY(-1px);
	}


	/* ==============================
	   PASSWORD EYE TOGGLE
	   ============================== */

	.password-wrapper {
		position: relative;
		width: 100%;
	}

	.password-wrapper .form-control {
		padding-right: 50px;
	}

	.password-toggle {
		position: absolute;
		right: 15px;
		top: 50%;
		transform: translateY(-50%);
		display: flex;
		align-items: center;
		justify-content: center;
		width: 28px;
		height: 28px;
		padding: 0;
		margin: 0;
		border: none;
		background: transparent;
		color: #6c757d;
		cursor: pointer;
		z-index: 10;
	}

	.password-toggle:hover {
		color: #28a745;
	}

	.password-toggle:focus {
		outline: none;
		box-shadow: none;
	}

	.password-toggle svg {
		width: 20px;
		height: 20px;
		display: block;
		pointer-events: none;
	}


	/* ==============================
	   ACTION BUTTONS
	   ============================== */

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
		transition:
			box-shadow .2s ease,
			transform .2s ease;
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


	/* ==============================
	   SUCCESS SECTION
	   ============================== */

	.success-box {
		text-align: center;
		padding-top: .5rem;
	}

	/*
	 * No circular background.
	 * Only the green tick is displayed.
	 */
	.success-icon {
		color: #28a745;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: .5rem auto 1.1rem;
	}

	.success-icon svg {
		width: 46px;
		height: 46px;
		display: block;
	}

	.success-box h5 {
		font-weight: 600;
		color: #212529;
		margin-bottom: .7rem;
	}

	.success-box p {
		color: #6c757d;
		font-size: .92rem;
		margin-bottom: 1.4rem;
	}


	/* ==============================
	   ANIMATION
	   ============================== */

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


	/* ==============================
	   MOBILE
	   ============================== */

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


			<!-- ==========================================
			     HEADER
			     ========================================== -->

			<div class="forgot-header">

				<div class="forgot-logo">

					<img
						src="{{ asset('assets/images/logo-1.png') }}"
						alt="BPC logo"
					>

				</div>


				<h4>
					Reset Password
				</h4>


				<!--
					Show this instruction only before
					the password has been successfully reset.
				-->

				@if(!session('success'))

					<p>
						Enter and confirm your new password below.
					</p>

				@endif

			</div>


			<!-- ==========================================
			     BODY
			     ========================================== -->

			<div class="forgot-body">


				<!-- ==========================================
				     SUCCESS STATE
				     ========================================== -->

				@if(session('success'))


					<div class="success-box">


						<!-- SUCCESS TICK -->

						<div class="success-icon">

							<svg
								xmlns="http://www.w3.org/2000/svg"
								fill="none"
								viewBox="0 0 24 24"
								stroke="currentColor"
								stroke-width="2.5"
							>

								<path
									stroke-linecap="round"
									stroke-linejoin="round"
									d="M5 13l4 4L19 7"
								/>

							</svg>

						</div>


						<!-- SUCCESS TITLE -->

						<h5>
							Password Changed Successfully
						</h5>


						<!-- SUCCESS DESCRIPTION -->

						<p>
							You can now log in using your new password.
						</p>


						<!-- BACK TO LOGIN -->

						<div class="forgot-actions">

							<a
								href="{{ url('/login') }}"
								class="btn btn-success"
							>
								Back to Login
							</a>

						</div>


					</div>


				@else


					<!-- ==========================================
					     INFORMATION
					     ========================================== -->

					<div class="forgot-info">

						Please enter your new password and confirm it
						before resetting your password.

					</div>


					<!-- ==========================================
					     RESET PASSWORD FORM
					     ========================================== -->

					<form
						action="{{ route('reset.password.post') }}"
						method="POST"
					>


						@csrf


						<!-- EXISTING TOKEN -->

						<input
							type="hidden"
							name="token"
							value="{{ $token }}"
						>


						<!-- EXISTING ENCRYPTED EMPLOYEE ID -->

						<input
							type="hidden"
							id="empid"
							name="empid"
							required
							readonly
						>


						<!-- ==========================================
						     NEW PASSWORD
						     ========================================== -->

						<div class="form-group">


							<label for="password">
								New Password
							</label>


							<div class="password-wrapper">


								<input
									type="password"
									id="password"
									class="form-control"
									name="password"
									placeholder="Enter New Password"
									required
									autofocus
								>


								<button
									type="button"
									class="password-toggle"
									onclick="togglePassword('password', this)"
									aria-label="Show password"
									title="Show password"
								>


									<!-- EYE OPEN -->

									<svg
										class="eye-open"
										xmlns="http://www.w3.org/2000/svg"
										fill="none"
										viewBox="0 0 24 24"
										stroke="currentColor"
										stroke-width="2"
									>

										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z"
										/>

										<circle
											cx="12"
											cy="12"
											r="2.75"
										/>

									</svg>


									<!-- EYE CLOSED -->

									<svg
										class="eye-closed"
										xmlns="http://www.w3.org/2000/svg"
										fill="none"
										viewBox="0 0 24 24"
										stroke="currentColor"
										stroke-width="2"
										style="display:none;"
									>

										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											d="M3 3l18 18"
										/>

										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											d="M10.6 5.4A10.8 10.8 0 0112 5.25C18 5.25 21.75 12 21.75 12a17.7 17.7 0 01-3.1 3.9"
										/>

										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											d="M6.2 6.2C3.7 8 2.25 12 2.25 12S6 18.75 12 18.75c1.5 0 2.85-.42 4.05-1.05"
										/>

									</svg>


								</button>


							</div>


							@if ($errors->has('password'))

								<span class="text-danger">
									{{ $errors->first('password') }}
								</span>

							@endif


						</div>


						<!-- ==========================================
						     CONFIRM NEW PASSWORD
						     ========================================== -->

						<div class="form-group">


							<label for="password-confirm">
								Confirm New Password
							</label>


							<div class="password-wrapper">


								<input
									type="password"
									id="password-confirm"
									class="form-control"
									name="password_confirmation"
									placeholder="Confirm New Password"
									required
								>


								<button
									type="button"
									class="password-toggle"
									onclick="togglePassword('password-confirm', this)"
									aria-label="Show password"
									title="Show password"
								>


									<!-- EYE OPEN -->

									<svg
										class="eye-open"
										xmlns="http://www.w3.org/2000/svg"
										fill="none"
										viewBox="0 0 24 24"
										stroke="currentColor"
										stroke-width="2"
									>

										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z"
										/>

										<circle
											cx="12"
											cy="12"
											r="2.75"
										/>

									</svg>


									<!-- EYE CLOSED -->

									<svg
										class="eye-closed"
										xmlns="http://www.w3.org/2000/svg"
										fill="none"
										viewBox="0 0 24 24"
										stroke="currentColor"
										stroke-width="2"
										style="display:none;"
									>

										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											d="M3 3l18 18"
										/>

										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											d="M10.6 5.4A10.8 10.8 0 0112 5.25C18 5.25 21.75 12 21.75 12a17.7 17.7 0 01-3.1 3.9"
										/>

										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											d="M6.2 6.2C3.7 8 2.25 12 2.25 12S6 18.75 12 18.75c1.5 0 2.85-.42 4.05-1.05"
										/>

									</svg>


								</button>


							</div>


							@if ($errors->has('password_confirmation'))

								<span class="text-danger">
									{{ $errors->first('password_confirmation') }}
								</span>

							@endif


						</div>


						<!-- ==========================================
						     ACTIONS
						     ========================================== -->

						<div class="forgot-actions">


							<button
								type="submit"
								class="btn btn-success"
							>
								Reset Password
							</button>


							<a
								class="back-login"
								href="{{ route('login') }}"
							>
								Back to Login
							</a>


						</div>


					</form>


				@endif


			</div>

		</div>

	</div>

</div>


@endsection


<!-- jQuery -->
<script src="{{ asset('/admin-lte/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- AdminLTE -->
<script src="{{ asset('/admin-lte/dist/js/adminlte.min.js') }}"></script>


@if(!session('success'))

<script>

	/*
	|--------------------------------------------------------------------------
	| EXISTING EMPLOYEE ID LOGIC
	|--------------------------------------------------------------------------
	*/

	$(window).on('load', function() {

		fetchId();

	});


	function fetchId() {

		let bb = window.location.href;

		let empId = bb.substring(bb.lastIndexOf('/') + 1);

		document.getElementById('empid').value = empId;

	}


	/*
	|--------------------------------------------------------------------------
	| PASSWORD VISIBILITY TOGGLE
	|--------------------------------------------------------------------------
	*/

	function togglePassword(inputId, button) {

		let input = document.getElementById(inputId);

		let eyeOpen = button.querySelector('.eye-open');

		let eyeClosed = button.querySelector('.eye-closed');


		if (input.type === 'password') {

			input.type = 'text';

			eyeOpen.style.display = 'none';

			eyeClosed.style.display = 'block';

			button.setAttribute('aria-label', 'Hide password');

			button.setAttribute('title', 'Hide password');

		} else {

			input.type = 'password';

			eyeOpen.style.display = 'block';

			eyeClosed.style.display = 'none';

			button.setAttribute('aria-label', 'Show password');

			button.setAttribute('title', 'Show password');

		}

	}

</script>

@endif