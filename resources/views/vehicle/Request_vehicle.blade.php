<style>

.textfont{
	font-family: Arial, Helvetica, sans-serif; 
	font-size: 15px;
  }

</style>

<link href="{{asset('css/bose.css')}}" rel="stylesheet"> 

<div class="row">
	<div class="col">
	
		<div class="card card-outline">
			<div class="rvheading card-header bg-green  d-flex justify-content-center"> <strong>Vehicle Requisition Form</strong> </div>
			<!--/card-header-->
			<div class="textfont card-body">
				<form method="POST" id="vehicleRequestForm" action="{{ route('Request_vehicle') }}" enctype="multipart/form-data" accept-charset="UTF-8"> 
					@csrf
					<input type="hidden" class="form-control" value="{{ Auth::user()->empName }}" name="name" id="name" placeholder="Employ ID">
					<input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="emp_id" id="emp_id" placeholder="Employ ID">
					<input type="hidden" class="form-control" value="{{ Auth::user()->office }}" name="office" id="office" placeholder="Employ ID">
					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
					<input type="hidden" class="form-control air-datepicker" id="date_of_requisition" name="date_of_requisition" autocomplete="off" required readonly>
					
					<div class="form-group row">
						<label class="col-md-4 col-form-label text-md-right">&nbsp;&nbsp;&nbsp;Email ID:<span style="color: red;">*</span></label>
							<div class="col-sm-10 col-md-6 col-lg-4">							
								<input type="text" class="form-control" value="{{ Auth::user()->emailId }}" name="email" id="email" placeholder="Email ID" required>		
							</div>
							<div class="col-sm-4">
								<span class="text-info">*Please ensure the emailId is correct and not empty!</span>
							</div>								
					</div>	
					
					<div class="form-group row">
						<label class="col-md-4 col-form-label text-md-right">&nbsp;&nbsp;&nbsp;Office Name:<span style="color: red;">*</span></label>
							<div class="col-sm-10 col-md-6 col-lg-4">							
								<input type="text" class="form-control"
									value="{{ $officenameAuthUser->officeDetails ?? '' }}"
									name="officename" id="officename"
									placeholder="office name" required readonly>
							</div>

							<div class="col-sm-4">
								<span class="text-info">*Please ensure that your office name is correct!</span>
							</div>
														
					</div>	
										
					<div class="form-group row">
						<label class="col-md-4 col-form-label text-md-right">&nbsp;&nbsp;&nbsp;Start Date:<span style="color: red;">*</span></label>
						<div class="col-sm-10 col-md-6 col-lg-4">
							
						<input type="datetime-local" class="form-control" name="start_date" autocomplete="off" id="start_date" onfocusout="myFunction()" required> 
		
					</div>
					<div class="col-sm-2">
						<span id="backdate" class="text-danger"></span>
					</div>

					</div>

					<div class="form-group row">
						<label class="col-md-4 col-form-label text-md-right" for="dateid">&nbsp;&nbsp;&nbsp;End Date:<span style="color: red;">*</span></label>
						<div class="col-sm-10 col-md-6 col-lg-4">
							<input type="date" class="form-control" name="end_date" autocomplete="off" id="end_date" onfocusout="myFunction()" required>
						 </div>
					
					<div class="col-sm-2">
                    <span id="backenddate" class="text-danger"></span>
            
			</div>
       </div>
	 
					<div class="form-group row">
						<label class="col-md-4 col-form-label text-md-right" for="purpose">&nbsp;&nbsp;&nbsp;Purpose:<span style="color: red;">*</span></label>
						<div class="col-sm-10 col-md-6 col-lg-4">
							<textarea class="form-control" name="purpose" id="purpose" placeholder="Purpose of visit" required></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 col-form-label text-md-right" for="places to visit">&nbsp;&nbsp;&nbsp;Places to visit:<span style="color: red;">*</span></label>
						<div class="col-sm-10 col-md-6 col-lg-4">
							<textarea class="form-control" name="places to visit" id="places to visit" placeholder="Chumey, Bumthang" required></textarea>
						</div>
					</div>
						
	<div class="form-group row">
    <label class="col-md-7 col-form-label text-md-right" for="purpose"><i>&nbsp;&nbsp;&nbsp;Can you drive your own vehicle if the office vehicle is unavailable?:&nbsp;&nbsp;&nbsp;<span style="color: red;">*</span></i></label>
      
        
          <label class="radio-inline">
            <input type="radio" id="Yes" value="Yes" name="role" required><b>Yes</b>
          </label>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    
    
        <label class="radio-inline">
          <input type="radio" id="No" value="No" name="role" required><b>No</b>
        </label>       
       
    </div>
					
					<div class="form-group row mb-0">
						<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12 ">
							<button type="submit" id="book" class="btn nSuccess btn-lg">Book Now</button>
						</div>
					</div>
				</form>
				<div>
					<!--/card-body-->
				</div>
			</div>
		</div>

		<script src="{{URL::asset('/admin-lte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
		<script src="{{URL::asset('/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
		<script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
		<script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script> 

		
		
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<strong></strong>';
		});
		</script>
		<script>
		var today = new Date();
		var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
		document.getElementById("date_of_requisition").value = date;
		</script>

<script type="text/javascript">

function myFunction(val)
 {

   document.getElementById('backdate').innerHTML = ''; 
//  document.getElementById('end').innerHTML = ''; 
 document.getElementById('backenddate').innerHTML = '';  

 var user_year0=document.getElementById('start_date').value[0];
  var user_year1=document.getElementById('start_date').value[1];
  var user_year2=document.getElementById('start_date').value[2];
  var user_year3=document.getElementById('start_date').value[3];
 var user_year=user_year0+user_year1+user_year2+user_year3;


 var user_month0=document.getElementById('start_date').value[5];
 var user_month1=document.getElementById('start_date').value[6];
  var user_month=user_month0+user_month1;



  var user_date0=document.getElementById('start_date').value[8];
  var user_date1=document.getElementById('start_date').value[9];
  var user_date=user_date0+user_date1;


  var user_eyear0=document.getElementById('end_date').value[0];
  var user_eyear1=document.getElementById('end_date').value[1];
  var user_eyear2=document.getElementById('end_date').value[2];
  var user_eyear3=document.getElementById('end_date').value[3];
  var user_eyear=user_eyear0+user_eyear1+user_eyear2+user_eyear3;


  var user_emonth0=document.getElementById('end_date').value[5];
  var user_emonth1=document.getElementById('end_date').value[6];
  var user_emonth=user_emonth0+user_emonth1;



  var user_edate0=document.getElementById('end_date').value[8];
  var user_edate1=document.getElementById('end_date').value[9];
  var user_edate=user_edate0+user_edate1;


var sys_year = "{{ date('Y') }}";
var sys_month = "{{ date('m') }}";
var sys_date = "{{ date('d') }}";

  if( (user_eyear <= user_year) && (user_emonth <= user_month) && (user_edate < user_date) ||
	  (user_eyear <= user_year) && (user_emonth <= user_month) && (user_edate < user_date) 
	 || (user_month > user_emonth) && (user_eyear == user_year) ){

	 document.getElementById('backenddate').innerHTML = 'Invalid Date!!!';
	 document.getElementById('end_date').value='';
  }
  }
</script>

	<script>
		$(function() {
			$("#vehiclerecord").DataTable({
				"dom": 'Blfrtip',
				"responsive": true,
				"lengthChange": true,
				"searching": true,
				"ordering": false,
				"info": false,
				"autoWidth": false,
				"paging": true,
				"retrieve":true,
				buttons: []

			 });
		});

			$('form').submit(function () {
    // Bail out if the form contains validation errors
    if ($.validator && !$(this).valid()) return;

    var form = $(this);
    $(this).find('input[type="submit"], button[type="submit"]').each(function (index) {
        // Create a disabled clone of the submit button
        $(this).clone(false).removeAttr('id').prop('disabled', true).insertBefore($(this));

        // Hide the actual submit button and move it to the beginning of the form
        $(this).hide();
        form.prepend($(this));
    });
	});

$(document).ready(function() {

document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;</i></a></strong>';

});

</script>

