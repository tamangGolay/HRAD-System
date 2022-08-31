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

.thw {
	white-space: nowrap;
}

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

</style>


			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
			<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
			<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<div class="container">
<div class="row">
	<div class="col">
		<div class="card">
		<div class="chgpsswd2 card-header bg-green text-center">
				<div class="card-nima">
					
              <b>Review Job Description</b>
             </div>
			</div>
			<div class="card-body table-responsive">
				<table id="example3" class="table table-hover table-striped table-bordered" width="100%">
					<thead>
						<tr class="thw">
							<th>Employee No</th>
							<th>Name</th>
							<th>Office</th>
							<th class="fat">Action</th>
						</tr>
					</thead>
					<tbody> @foreach($userdetails as $userdetails)
						<tr>
							<td> {{$userdetails->empId}} </td>
							<td> {{$userdetails->empName}} </td>
							
							<td> 
							 {{$userdetails->officeDetails}}
								
							</td>

							<td>
							<a href="javascript:void(0)" data-toggle="tooltip"   data-id="{{$userdetails->id}}" data-original-title="Edit" class="edit mt-1 col-lg-12 btn btn-outline-success btn edit"> <i class="fa fa-edit" ></i></a>

							</td>
						</tr> @endforeach </tbody>
				</table>
			</div>
		
			<div>
				<!--/card-body-->
			</div>
		</div>
	</div>
</div>
 
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">
				<input type="hidden" value="" name="approvedOn" id="approvedOn" required>
				<input type="hidden" class="form-control" name="createdDate" id="createdDate" >
                   <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-12 control-label">Employee Id</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="emp_id" name="emp_id" placeholder="emp_id" value="" maxlength="50" required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 col-lg-12 control-label">Employee Name</label>
                        <div class="col-sm-12">
                            <input type="text" id="empName" name="empName"  placeholder="empName" value="" class="form-control" required>
                        </div>
                    </div>
      
                    <div class="form-group">
                        <label class="col-sm-2 col-lg-12 control-label">Job Description</label>
                        <div class="col-sm-12">
                            <textarea type="text" rows="14" id="jobdescription" name="jobdescription"  placeholder="jobdescription" value="" class="form-control" required></textarea>
                        </div>
                    </div>
                	
					<input type="hidden" class="form-control" name="officeId" id="officeId" placeholder="Division" readonly required>      
				

                    
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="saveBtn" value="create">Approve
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="payModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="payHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="payDeleteButton" value="create">Yes</button>
						<button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    





</script>
<!-- jquery-validation -->
<script src="{{asset('/admin-lte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('/admin-lte/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<!-- DataTables -->
<script src="{{URL::asset('/admin-lte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<!-- Script for export file from datatable -->
<script src="{{asset('/admin-lte/datatables/nima.js')}}"></script>
<script src="{{asset('/admin-lte/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/admin-lte/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/admin-lte/datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('/admin-lte/datatables/buttons.print.min.js')}}"></script>
<!-- <script src="{{asset('/admin-lte/datatables/buttons.flash.min.js')}}"></script> -->
<script src="{{asset('/admin-lte/datatables/jszip.min.js')}}"></script>
<!-- <script src="{{asset('/admin-lte/datatables/pdfmake.min.js')}}"></script> -->
<script src="{{asset('/admin-lte/datatables/vfs_fonts.js')}}"></script>
<!-- checkin form -->
<script>
$(function() {
	$("#example3").DataTable({
		"dom": 'Bfrtip',
		"responsive": true,
		"lengthChange": true,
		"searching": true,
		"ordering": false,
		"info": true,
		"autoWidth": true,
		"paging": true,
		"retrieve":true,
		buttons: ['copyHtml5', 'excelHtml5', 'pdfHtml5']
	});
});
</script>




			
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
		$.get("{{ route('job.store') }}" + '/' + guestHouse_id + '/edit', function(data) {
			$('#modelHeading').html("Edit");
			$('#saveBtn').val("edit-book");
			$('#ajaxModel').modal('show');
			$('#id').val(data.id);//#id is from modal form and data.id is from modal(fillable) database
		
			$('#emp_id').val(data.empId);
			$('#empName').val(data.empName);
			$('#jobdescription').val(data.jobDescription);
			$('#officeId').val(data.officeId);
			$('#office').val(data.officeDetails);
		
		})
	});
	$('#saveBtn').click(function(e) {
		e.preventDefault();
		$(this).html('Save');
		$.ajax({
			data: $('#Form').serialize(),
			url: "{{ route('job.store') }}",
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
				$.get('/getView?v=jobDescriptionReview',function(data){
				$('#contentpage').empty();                          
				$('#contentpage').append(data.html);
				}); 
				
				// window.location.href = '/home';
				table.draw();
			},
			error: function(data) {
				console.log('Error:', data);
				$('#saveBtn').html('Approve');
			}
		});
	});


	$('body').on('click', '.delete', function() {
		var guestHouse_id = $(this).data('id');
		$.get("{{ route('job.store') }}" + '/' + guestHouse_id + '/edit', function(data) {
			$('#modelUserHeading').html("Do you want to delete user?");
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
			url: "{{ route('deleteuser') }}",
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
				$.get('/getView?v=jobDescriptionReview',function(data){
				$('#contentpage').empty();                          
				$('#contentpage').append(data.html);
				}); 
				table.draw();
			},
			error: function(data) {
				console.log('Error:', data);
				$('#saveBtn').html('Approve');
			}
		});
	});
});
</script>
<!-- jquery-validation -->
<script src="{{asset('/admin-lte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('/admin-lte/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<!-- DataTables -->
<script src="{{URL::asset('/admin-lte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<!-- Script for export file from datatable -->
<script src="{{asset('/admin-lte/datatables/nima.js')}}"></script>
<script src="{{asset('/admin-lte/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/admin-lte/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/admin-lte/datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('/admin-lte/datatables/buttons.print.min.js')}}"></script>
<script src="{{asset('/admin-lte/datatables/jszip.min.js')}}"></script>
<!-- <script src="{{asset('/admin-lte/datatables/pdfmake.min.js')}}"></script> -->
<script src="{{asset('/admin-lte/datatables/vfs_fonts.js')}}"></script>
<!-- checkin form -->
<script>
$(document).ready(function() {
	$('#myTable').DataTable({
		dom: "Bfrtip",
		"pagingType": "simple_numbers",
		"Searching": true,
		"ordering": false,
		buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5']
	});
});
</script>
<script type="text/javascript">
$(document).ready(function() {
	document.getElementById('contenthead').innerHTML = '<strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
});
</script>

<script>
    var today = new Date();
	var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
	document.getElementById("createdDate").value = date;
</script>
<script>
				var today = new Date();
				var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
				document.getElementById("approvedOn").value = date;
			</script>

