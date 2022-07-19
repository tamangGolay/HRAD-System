<style>

.textfont{
	font-family: Arial, Helvetica, sans-serif; 
	font-size: 15px;
  }

</style>

<link href="{{asset('css/bose.css')}}" rel="stylesheet"> 
 <!-- css property called in bose.css -->

<!-- Stored in resources/views/pages/dispatch.blade.php -->
<div class="row">
	<div class="col">
	
		<div class="card card-outline">
			<div class="rvheading card-header bg-green  d-flex justify-content-center"> <strong>Welfare Refund</strong> </div>
			<!--/card-header-->
			<div class="textfont card-body">
				<form method="POST" action="{{ route('Request_vehicle') }}" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
					<input type="hidden" class="form-control" value="{{ Auth::user()->name }}" name="name" id="name" placeholder="Employ ID">
					
					<input type="hidden" class="form-control" value="{{ Auth::user()->emp_id }}" name="emp_id" id="emp_id" placeholder="Employ ID">
					
					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
					<input type="hidden" class="form-control air-datepicker" id="date_of_requisition" name="date_of_requisition" autocomplete="off" required readonly>
					<!-- <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right">&nbsp;&nbsp;&nbsp;Date of requistion:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                </div>
            </div> -->

					<div class="form-group row">
						<label class="col-md-4 col-form-label text-md-right">&nbsp;&nbsp;&nbsp;Employee Id:</label>
						<div class="col-sm-10 col-md-6 col-lg-4">
							
					<input type="text" class="form-control" name="empId" autocomplete="off" id="empId" required> 
				
				</div> 	</div>	

					
					 
					<div class="form-group row">
						<label class="col-md-4 col-form-label text-md-right" for="purpose">&nbsp;&nbsp;&nbsp;Date:</label>
						<div class="col-sm-10 col-md-6 col-lg-4">
						<input type="date" class="form-control" name="date" autocomplete="off" id="date" required> 
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-4 col-form-label text-md-right" for="purpose">&nbsp;&nbsp;&nbsp;Amount:</label>
						<div class="col-sm-10 col-md-6 col-lg-4">
						<input type="number" class="form-control" name="amount" autocomplete="off" id="amount" required> 
						</div>
					</div>				
						
	
					
					<div class="form-group row mb-0">
						<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12 ">
							<button type="submit"  id="book" class="btn nSuccess btn-lg">Submit</button>
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





<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
		});
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
		</script>