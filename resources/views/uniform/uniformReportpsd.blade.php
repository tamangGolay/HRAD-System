<style>
.w-25 {
	white-space: nowrap;
}

#saveBtn {
	width: 120px;
}

a {
	color: black !important;
	text-decoration: none;
}

.btn-primary {
	color: #fff !important;
	background-color: #007bff;
	border-color: #007bff;
}

.success {
	color: #fff !important;
	background-color: #28a745;
	border-color: #28a745;
}

.danger {
	color: #fff !important;
	background-color: #dc3545;
	;
	border-color: #28a745;
}

/* .thw {
	white-space: nowrap;
} */

.fat{
	width: 14%;

}


.card-nima {
    margin-bottom: .75rem;
}

.card-nima {
    float: center;
    font-size: 1.1rem;
    font-weight: 400;
    margin: 0;
}
.card-nima {
    margin-bottom: .75rem;
}

.custom-filter-button {
        background-color: #007bff; 
        color: #fff !important;
        border-color: ##33FF4F;
		border-radius:5px;
		width:150px;
		
    }

    .custom-filter-button:hover {
        background-color: #0056b3; /* Change the background color on hover */
        border-color: #0056b3;
    }

    .button-text {
        margin-right: 5px;
    }


</style>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<div class="row">
	<div class="col">
		<div class="card">
		<div class="chgpsswd2 card-header bg-green text-center">
				<div class="card-nima">
					
              <h5>All Emp Uniform Report</h5>
             </div>
			</div>


			<div class="modal fade" id="yearFilterModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Filter by Year</h4>
            </div>
            <div class="modal-body">
                <form id="yearFilterForm" name="yearFilterForm" class="form-horizontal">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-4 text-md-right" for="filterYear">{{ __('Select Year:') }}</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="filterYear" id="filterYear" required>
                                <option value="">Select Year</option>
                                <!-- Add options dynamically based on available years -->
								@foreach($data12->unique('year') as $data2)
                                    <option value="{{$data2->year}}">{{$data2->year}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                        <button type="submit" class="btn btn-outline-primary">Apply Filter</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

			<div class="card-body table-responsive">
				<table id="example3" class="table table-hover table-striped table-bordered" width="100%">
					<thead>
						<tr class="thw">
						       <th>Sl.No</th>
								<th>Emp Id</th>
								<th>Name</th>
								<th>Designation</th>
                                
								<th>Office Name</th> 								
								<th>Pant Size</th>
								<th>Shirt Size</th>
								<th>Jacket Size</th>
								<th>Shoe Size</th>
                                <th> Gumboot Size</th>
                                <th> Raincoat Size</th>		
								<th> Year</th>			
								<!-- <th> Action </th> -->
						</tr>
					</thead>
					<tbody> @foreach($data12 as $rv)
						<tr>
						<td> {{$loop->iteration}}</td>
								<td> {{$rv->empId}} </td>
								<td> {{$rv->empName}} </td>
								<td> {{$rv->desisNameLong}} </td>
                                <td> {{$rv->officeDetails}} </td>	
                                <td> {{$rv->pantSizeName}} </td>
								<td> {{$rv->shirtSizeName}} </td>
								<td> {{$rv->jacket}} </td>
                                <td> {{$rv->euShoeSize}} </td>
								<td> {{$rv->eUSize}}  </td>
								<td> {{$rv->sizeName}}  </td>
								<td> {{$rv->year}}  </td>
						
							<!-- <td>
							<a href="javascript:void(0)" data-toggle="tooltip"   data-id="{{$rv->id}}" data-original-title="Edit" class="edit mt-1 ml-2 btn btn-success btn edit"> <i class="fa fa-edit" style="color:white"></i></a>
							<a href="javascript:void(0)" data-toggle="tooltip" id="" data-id="{{$rv->id}}" id="delete" data-original-title="Delete" class="btn mt-7 ml-2 danger btn delete"> <i class="fa fa-window-close" style="color:white"></i></a>	</button>
					</td> -->
					
						</tr> @endforeach </tbody>
				</table>
			</div>
			<div class="float-right"> {{$data12->links()}} </div>
			<div>
				<!--/card-body-->
			</div>
		</div>
	</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="modelHeading"></h4> </div>
						<div class="modal-body">
							<form id="Form" name="Form" class="form-horizontal"> @csrf
								<input type="hidden" id="token" value="{{ csrf_token() }}">

								<input type="hidden" value="<?php echo $data12[0]->id;?>" name="id" id="id" >
						

								<div class="form-group row">
									<label class="col-sm-4 text-md-right" for="emp_id">{{ __('Employee Number:') }}</label>
									<div class="col-sm-6">
									<select class="form-control" name="emp_id" id="emp_id" required> 
							   <option value="">Select EmpId</option>	
							  @foreach($usersU as $usersU)
								<option value="{{$usersU->empId}}"> {{$usersU->empId}}
								</option>
								@endforeach </select>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-4 text-md-right" for="office">{{ __('Office:') }}</label>
									<div class="col-sm-6">
							<select class="form-control" name="officeId" id="officeId" required> 
							<option value="">Select Office</option>	
							@foreach($office as $office)
								<option value="{{$office->id}}"> {{$office->officeDetails}}
								</option>
								@endforeach </select>
									</div>
								</div>		
								
								<div class="form-group row">
                                    <label class="col-sm-4 text-md-right" for="designationID">{{ __('Designation:') }}</label>
                                    <div class="col-sm-6">
                            <select class="form-control" name="designationID" id="designationID" required> 
                            <option value="">Select Designation</option>    
                            @foreach($designation as $designation)
                                <option value="{{$designation->id}}"> {{$designation->desisNameLong}}
                                </option>
                                @endforeach </select>
                                    </div>
                                </div>



								<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="pant">{{ __('Pant:') }}</label>
						<div class="col-sm-6">

							<select class="form-control" name="pant" id="pant" required> 
							<option value="">Select pant Size</option>	
								@foreach($pant as $pant)
                            <option value="{{$pant->id}}"
                                @if ($pant->pantSizeName == '---For New Employee---') disabled @endif>
                             
                            {{$pant->pantSizeName}}</option>
				
                            @endforeach
							</select>

						</div>
					</div>


					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="shirt">{{ __('Shirt:') }}</label>
						<div class="col-sm-6">

							<select class="form-control" name="shirt" id="shirt" required> 
							<option value="">Select Shirt Size</option>	
								@foreach($shirt as $shirt)
                            <option value="{{$shirt->id}}"
                                @if ($shirt->shirtSizeName == '---For New Employee---') disabled @endif>
                             
                            {{$shirt->shirtSizeName}}</option>
				
                            @endforeach
							
							</select>
						</div>
					</div>


					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="jacket">{{ __('Jacket:') }}</label>
						<div class="col-sm-6">

							<select class="form-control" name="jacket" id="jacket" required> 
							<option value="">Select jacket Size</option>	
							@foreach($jacket as $jacket)
								<option value="{{$jacket->id}}" > {{$jacket->sizeName}}
								</option>
								@endforeach </select>
						</div>
					</div>
								
					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="shoe">{{ __('Shoe:') }}</label>
						<div class="col-sm-6">

							<select class="form-control" name="shoe" id="shoe" required> 
							<option value="">Select shoe Size</option>	
							@foreach($shoe as $shoe)
								<option value="{{$shoe->id}}" > {{$shoe->euShoeSize}}
								</option>
								@endforeach </select>
						</div>
					</div>
								
					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="gumboot">{{ __('Gumboot:') }}</label>
						<div class="col-sm-6">

							<select class="form-control" name="gumboot" id="gumboot" required> 
							<option value="">Select gumbbot Size</option>	
							@foreach($gumboot as $gumboot)
								<option value="{{$gumboot->id}}" > {{$gumboot->eUSize}}
								</option>
								@endforeach </select>
						</div>
					</div>


					<div class="form-group row">
						<label class="col-sm-4 text-md-right" for="raincoat">{{ __('Raincoat:') }}</label>
						<div class="col-sm-6">

							<select class="form-control" name="raincoat" id="raincoat" required> 
							<option value="">Select shoe Size</option>	
							@foreach($raincoat as $raincoat)
								<option value="{{$raincoat->id}}" > {{$raincoat->sizeName}}
								</option>
								@endforeach </select>
						</div>
</div>	
															
					<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
									<button type="submit" class="btn btn-outline-success" id="uniformT" value="create">Save changes </button>
									<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>      

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>


			<div class="modal fade" id="userModel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="modelUserHeading"></h4> </div>
						<div class="modal-body">
							<form id="Form" name="Form" class="form-horizontal"> @csrf
								<input type="hidden" id="token" value="{{ csrf_token() }}">


									<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
									<button type="submit" class="btn btn-outline-success" id="saveUserBtn" value="create">Yes</button>
									<button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div> 

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>   -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
			<!-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> -->
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
			<!-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> -->
			<script type="text/javascript">	

			$(function() {
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});	
	
				$('body').on('click', '.edit', function() {
					var guestHouse_id = $(this).data('id');
					$.get("{{ route('uniform.store') }}" + '/' + guestHouse_id + '/edit', function(data) {
						$('#modelHeading').html("Edit uniform size");
						$('#uniformT').val("edit-book");
						$('#ajaxModel').modal('show');
						$('#id').val(data.id);//#id is from modal form(id) and data.id is from modal(fillable) database
						$('#emp_id').val(data.empId); //input id,database
						$('#officeId').val(data.officeId);
						$('#designationID').val(data.designationID);
						$('#pant').val(data.pant);
						$('#shirt').val(data.shirt);
						$('#jacket').val(data.jacket);
						$('#shoe').val(data.shoe);
						$('#gumboot').val(data.gumboot);
						$('#raincoat').val(data.raincoat);

					})
				});
				$('#uniformT').click(function(e) {
					e.preventDefault();
					$(this).html('Saving...');
					$.ajax({
						data: $('#Form').serialize(),
						url: "{{ route('uniform.store') }}",
						type: "POST",
						dataType: 'json',
						success: function(data) {

							$('#Form').trigger("reset");
							$('#ajaxModel').modal('hide');
						    // table.draw();
							window.onload = callajaxOnPageLoad(page);
							var alt = document.createElement("div");
							alt.setAttribute("style", "position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
							alt.innerHTML = "Data Updated Successfully! ";
							setTimeout(function() {
								alt.parentNode.removeChild(alt);
							}, 4500);
							document.body.appendChild(alt);
							
							
							window.location.href='/home';						
							table.draw();
						},
						error: function(data) {
							console.log('Error:', data);
							$('#uniformT').html('Save Changes');
							//alert(data);
							window.location.href='/home';						
							table.draw();   //save changes issue: use this 
						}
					});
				});

				$('body').on('click', '.delete', function() {
					var guestHouse_id = $(this).data('id');
					$.get("{{ route('uniform.store') }}" + '/' + guestHouse_id + '/edit', function(data) {
						$('#modelUserHeading').html("Do you want to delete?");
						$('#saveUserBtn').val("edit-book");
						$('#userModel').modal('show');
						$('#id').val(data.id);//#id is from modal form and data.id is from modal(fillable) database
					})
				});
				$('#saveUserBtn').click(function(e) {
					e.preventDefault();
					$(this).html('Yes');
					$.ajax({
						data: $('#Form').serialize(),
						url: "{{ route('deleteuniform') }}",
						type: "POST",
						dataType: 'json',
						success: function(data) {
							$('#Form').trigger("reset");
							$('#userModel').modal('hide');
							//   table.draw();
							window.onload = callajaxOnPageLoad(page);
							var alt = document.createElement("div");
							alt.setAttribute("style", "position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
							alt.innerHTML = "Data Updated Successfully! ";
							setTimeout(function() {
								alt.parentNode.removeChild(alt);
							}, 4500);
							document.body.appendChild(alt);

							// $.get('/getView?v=/home', function(data) {
							// 	$('#contentpage').empty();
							// 	$('#contentpage').append(data.html);
							// });
							window.location.href='/home';
							table.draw();
						},
						error: function(data) {
							console.log('Error:', data);
							$('#saveBtn').html('Save Changes');
						}
					});
				});
			});
</script>
<script>
$(function() {
    var table = $("#example3").DataTable({
        "dom": 'Bfrtip',
        "responsive": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "paging": true,
        "retrieve": true,
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'print',
            {
				text: '<span class="button-text">Filter by Year</span>',
                className: 'custom-filter-button',
                action: function (e, dt, node, config) {
                    $('#yearFilterModal').modal('show');
                }
            }
        ]
    });

    // Additional code for handling year filtering
    $('#yearFilterForm').submit(function (e) {
        e.preventDefault();
        var selectedYear = $('#filterYear').val();
        
        table.column(11).search(selectedYear).draw();
        $('#yearFilterModal').modal('hide');
    });
});
</script>
			
<script type="text/javascript">
			$(document).ready(function() {
				document.getElementById('contenthead').innerHTML = '<strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
	});
</script>
			