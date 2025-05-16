<style>
.size{
	width:200px;
}
</style>
<div class="row ">
	<div class="col">
		<div class="card">
			<div class="card-header bg-green">
				<div class="col text-center">
					<h5>
                <b>Vehicle Review by MTO</b>
              </h5> </div>
			</div>
			<!--/card-header-->
			<form method="POST" action="/MTOapprove" enctype="multipart/form-data" accept-charset="UTF-8" onsubmit="return check()"> @csrf
				<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
				<div class="card-body table-responsive p-0">

						
					<table id="example2" class="table table-hover table-striped table-bordered">
						<thead>
					
							<tr class="text-nowrap">
								<th>Booking No</th>
								<th>Emp Id</th>
								<th>Office Name</th>
								<th>Name</th>
								<th>Contact Number</th>
								<th>Date of Requisition</th>
								<th>Start Date</th>
								<th>End Date</th>								
								<th>Purpose</th>
								<th>Places to Visit</th>
								<th>Supervisor</th>
								<th>Personal car</th>
								<th size="25" class="text-center"> 
								
								
								<div >
							<select style="width:200px;" id="vehicle" name="vehicle[]" class="form-control col-form-label " >
								<option  name="" value="" ><b>Assign & Approve</b></option>
								 @foreach($details as $vehicles)
								<option value="{{$vehicles->id}}"     
								@if ($vehicles->vehicle_name == "N/A") disabled @endif >
									{{$vehicles->vehicle_name}}
								</option> 
								@endforeach 
							 </select>
						</div>
								</th>
								<th >Reject</th>
							
							</tr>
						</thead>
						<tbody> @foreach($mtoReview as $rv)
							<tr>
								<td> {{$rv->id}} </td>
								<td> {{$rv->emp_id}} </td>
								<td> {{$rv->officeDetails}} </td>
								<td> {{$rv->vname}} </td>
								<td> {{$rv->mobileNo}} </td>
								<td> {{$rv->dateOfRequisition}} </td>
					
								<td class="text-nowrap">
   									 {{ \Carbon\Carbon::parse($rv->start_date)->format('Y-m-d') }}<br>
   									 {{ \Carbon\Carbon::parse($rv->start_date)->format('h:i A') }}
								</td>


								<td class="text-nowrap"> {{$rv->end_date}} </td>
						
								<td> {{$rv->purpose}} </td>
								<td> {{$rv->placesToVisit}} </td>
								<td> {{$rv->empName}} ({{$rv->desisNameLong}}) </td>
								<td> {{$rv->personalvehicle}} </td>

								
								
						<td align="center">
						<button type="submit" name="idl[]" id="idl" value="{{$rv->id}}" class="btn btn-outline-success text-center text-dark" > Approve</button>
								
						
							
					</form>

					</td>



					<td align="center">
					<form method="POST" action="/MTOreject" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
					<input type="hidden" name="vehiclename" id="vehiclename" value="5">

					
					
			<button type="submit" name="idl[]" id="idl" onclick="return confirm('Do you want to reject?')" value="{{$rv->id}}" class="btn btn-outline-danger text-center text-dark">Reject</button>
			<br>
			<br>
		<div>
		<textarea name="reason" id="reason" placeholder="reason for rejection" required></textarea>
		</div>
					
					
					
				</form>
			</td>
			</tr> @endforeach </tbody>
			</table>
			<div class="float-right"> {{$mtoReview->links()}} </div>
			<div>
				<!--/card-body-->
			</div>
			</div>
</div></div>

			<!-- Scripts -->
<script src="{{ asset('assets/js/jquery-3.5.1.slim.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#contenthead').html('<strong><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;</i></a></strong>');
    });
</script>

<!-- jQuery Validation -->
<script src="{{ asset('/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<!-- Export buttons -->
<script src="{{ asset('/admin-lte/datatables/nima.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/vfs_fonts.js') }}"></script>

	
			<script>
			$(function() {
				$("#example2").DataTable({
					"dom": 'Bfrtip',
					"responsive": true,
					"lengthChange": true,
					"searching": true,
					"ordering": false,
					"info": true,
					"autoWidth":false,
					"paging": true,
					"retrieve":true,
					
					buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5']
				});
			});
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$('body').on('click', '.edit', function() {
				var vehicleId = $(this).data('id'); //pull vehicle request id    
				$.get("{{ route('a_b.store') }}" + '/' + vehicleId + '/edit', function(data) { //pass vehicleid means requestid here
					$('#modelHeading').html("Edit Meeting Room");
					$('#ajaxModel').modal('show'); //post data as $request in vehiclecontroller using ajaxcontroller
					$('#id').val(data.id);
					$('#vehicle').val(data.vehicleId); //here its vehicle id only
					$('#end_date').val(data.end_date); //pulling data on modal is not handled here
				})
			});
			$('#saveBtn').click(function(e) {
				e.preventDefault();
				$(this).html('Save');
				$.ajax({
					data: $('#Form').serialize(),
					url: "{{ route('a_b.store') }}",
					type: "POST",
					dataType: 'json',
					success: function(data) {
						$('#Form').trigger("reset");
						$('#ajaxModel').modal('hide');
						//   table.draw();
						window.onload = callajaxOnPageLoad(page);
						var alt = document.createElement("div");
						alt.setAttribute("style", "position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
						alt.innerHTML = "Data Updated Successfully! ";
						setTimeout(function() {
							alt.parentNode.removeChild(alt);
						}, 4500);
						document.body.appendChild(alt);
						window.onload.href = '/home';
						table.draw();
					},
					error: function(data) {
						console.log('Error:', data);
						$('#saveBtn').html('Save Changes');
					}
				});
			});

			</script>
		

	<script>

function check() {
	// var vehicle = document.getElementById('vehicle').value;

	// console.log(vehicle);
	if(document.getElementById('vehicle').value === '') {
		    document.getElementById('vehicle').style = "border-color:red;width:200px";

			alert("Please assign vehicle");
			return false;
	}
		
		
	else {
		document.getElementById('vehicle').style = "width:200px";


		return true;
	}
	
}

$("#vehicle").on('change',function(e){
	document.getElementById('vehicle').style = "border-color:#ced4da;width:200px";

        
    });

	</script>
