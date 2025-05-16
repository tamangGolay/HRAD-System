<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header small-box bg-green d-flex justify-content-center">
				<div class="card-title">
					<h5>
                    <b>Add Conference User</b>
                </h5> </div>
			</div>
			<div class="card-body">
				<form method="POST" action="registerconferenceuser" onsubmit="return pwdMatching();"> @csrf
					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
					<div class="form-group row">
						<label for="emp_id" class="col-md-4 col-form-label text-md-right">{{ __('Employee Number:') }}</label>
						<div class="col-md-4">
							<input id="emp_id" type="number" placeholder="Employee Number" class="form-control @error('emp_id') is-invalid @enderror" name="emp_id" value="{{ old('emp_id') }}" required autocomplete="cid" onFocusOut="getEmployeeDetails(this.value);"> </div>
						<div class="col-sm-2"> <span id="empid" class="text-danger"></span> </div> <span id="info" class="text-danger text-md-right"></span> </div>
					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name:') }}</label>
						<div class="col-md-4">
							<input id="nameid" type="text" placeholder="Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name"> </div>
					</div>
					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Designation:') }}</label>
						<div class="col-md-4">
							<input id="designation" type="text" placeholder="Designation" class="form-control @error('designation') is-invalid @enderror" name="designation" value="{{ old('designation') }}" required autocomplete="name"> </div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="wing">{{ __('Wing:') }}</label>
						<div class="col-sm-4">
							<select name="wing" id="wing" class="form-control" required> @foreach($wings as $wing)
								<option value="{{$wing->id}}">{{$wing->Wing_Name}}</option> @endforeach </select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label text-md-right" for="department">{{ __('Department:') }}</label>
						<div class="col-sm-4">
							<select name="department" id="department" class="form-control" required> @foreach($departments as $department)
								<option value="{{$department->id}}">{{$department->Department_Name}}</option> @endforeach </select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="division">{{ __('Division:') }}</label>
						<div class="col-sm-4">
							<select name="division" id="division" class="form-control" required> @foreach($divisions as $division)
								<option value="{{$division->id}}">{{$division->Division_Name}}</option> @endforeach </select>
						</div>
					</div>
					<div class="form-group row">
						<label for="cid" class="col-md-4 col-form-label text-md-right">{{ __('Mobile Number:') }}</label>
						<div class="col-md-4">
							<input id="number" type="text" placeholder="Contact Number" class="form-control @error('number') is-invalid @enderror" name="number" value="{{ old('number') }}" required autocomplete="number" autofocus> </div> <span id="info" class="text-danger text-md-right"></span> </div>
					<div class="form-group row mb-0">
						<div class="col text-center col-form-label col-md-center col-sm-2 col-md-12 col-lg-12">
							<button type="submit" class="btn btn-outline-success btn-save" id="bsubmit">{{ __('Create User') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	document.getElementById('contenthead').innerHTML = '<strong>Create New User</strong>';
	$("#department").on('change', function(e) {
		//console.log(e);
		var id = e.target.value;
		var csrftoken = document.getElementById('tokenid').value;
		$.get('/getValues?source=division&info=' + id + '&token=' + csrftoken, function(data) {
			console.log(data);
			$('#division').empty();
			$.each(data, function(index, gewogname) {
				$('#division').append('<option value="' + divname.id + '">' + divname.Division_Name + '</option>');
			})
		});
	});
});

function getEmployeeDetails(val) {
	//pulling records using cid from checkin table 
	var csrftoken = document.getElementById('tokenid').value;
	$.get('/getValues?source=conference_useradd&info=' + val + '&token=' + csrftoken, function(data) {
		console.log(data);
		document.getElementById('empid').innerHTML = '';
		document.getElementById('nameid').value = '';
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