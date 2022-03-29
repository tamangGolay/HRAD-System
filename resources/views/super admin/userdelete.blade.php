@if(session()->has('message'))
<div class="alert alert-danger"> {{ session()->get('message') }} </div> @endif @if(session()->has('success'))
<div class="alert alert-success"> {{ session()->get('success') }} </div> @endif
<div class="container">
	<div class="row ">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header bg-green d-flex justify-content-center">
					<h5>
                        <b>User Delete</b>
                    </h5> </div>
				<div class="card-body">
					<form method="POST" action="deleteuser"> @csrf @foreach ($errors->all() as $error)
						<p class="text-danger">{{ $error }}</p> @endforeach
						<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
						<div class="form-group row">
							<label for="emp_id" class="col-md-4 col-form-label text-md-right">Employee Number</label>
							<div class="col-sm-10 col-md-6 col-lg-5">
								<input id="emp_id" type="number" placeholder="Employee Number" class="form-control" name="emp_id" onFocusOut="getEmployeeDetails(this.value)" required> </div>
							<div class="col-sm-2"> <span id="empid" class="text-danger"></span> </div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 col-form-control text-md-right" for="contact_number">&nbsp;&nbsp;&nbsp;Contact number:</label>
							<div class="col-sm-10 col-md-6 col-lg-5">
								<input type="number" class="form-control" name="contact_number" id="contact_number" placeholder="Contact Number" required> </div>
						</div>
						<div class="form-group row mb-0">
							<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
								<button type="submit" class="btn btn-outline-success" onclick="message()"> Delete Conference User </button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	document.getElementById('contenthead').innerHTML = '<strong>User Delete</strong>';
});

function message() {
	var pwd = document.getElementById('emp_id').value;
	if(pwd.length > 0) {
		var proceed = confirm("Are you sure you want to continue?");
		if(proceed) {
			return true;
		} else {
			return false;
		}
	}
}

function getEmployeeDetails(val) {
	//pulling records using cid from checkin table 
	var csrftoken = document.getElementById('tokenid').value;
	$.get('/getValues?source=userdelete&info=' + val + '&token=' + csrftoken, function(data) {
		console.log(data);
		document.getElementById('empid').innerHTML = '';
		$.each(data, function(index, Employee) {
			if(Employee.emp_id != null) {} else {
				document.getElementById('empid').innerHTML = 'Not a registered user!!!';
				document.getElementById('emp_id').value = '';
			}
		})
	});
}
</script>