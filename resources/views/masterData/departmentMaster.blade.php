<style>
    
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

</style>



<link href="{{asset('css/bose.css')}}" rel="stylesheet">
<!-- called in bose.css -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->

  
<div class="container">
    <a class="btn success" href="javascript:void(0)" id="manageDepartment">Add Department&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table">
    @csrf
        <thead>
            <tr>
                <th>No</th>
                <th width=50px>Dept Short Name</th>
                <th width=180px>Department Long Name</th>
                <th width=50px>Dept Head</th>
                <th width=160px>Department Reports To Service</th>
                <th width=180px>Department Reports To Company</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
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

                   <input type="hidden" name="id" id="department_id">
                    <div class="form-group">
                        <label for="name" class="col-lg-12 col-sm-12 control-label">Department Short Name</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" class="form-control" id="deptNameShort" name="deptNameShort" placeholder="eg: ITD" value="" maxlength="50" required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Department Long name</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="deptNameLong" name="deptNameLong"  placeholder="eg: Information Technology Division" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Department Head</label>
                        <div class="col-lg-12 col-sm-12">
                        <select class="col-lg-12 col-sm-12 form-control" name="deptHead" id="deptHead" value="" required>
                                             <option value="">Select Office</option>
                                             @foreach($employeen as $employeen)
                                             <option value="{{$employeen->id}}">{{$employeen->empId}}</option>
										@endforeach
							</select>    
                        
                        <!-- <input type="text" id="deptHead" name="deptHead"  placeholder="eg: Chief Executive officer" class="form-control" required> -->
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Department Report To Service</label>
                        <div class="col-lg-12 col-sm-12">
                        <select class="col-lg-12 col-sm-12 form-control" name="deptReportsToService" id="deptReportsToService" value="" required>
                                             <option value="">Select Office</option>
                                             @foreach($servicen as $servicen)
                                             <option value="{{$servicen->id}}">{{$servicen->serNameLong}}</option>
										@endforeach
							</select>    
                        
                        <!-- <input type="text" id="deptReportsToService" name="deptReportsToService"  placeholder="eg: Chief Executive officer" class="form-control" required> -->
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Department Report To Company</label>
                        <div class="col-lg-12 col-sm-12">
                        <select class="col-lg-12 col-sm-12 form-control" name="deptReportsToCompany" id="deptReportsToCompany" value="" required>
                                             <option value="">Select Office</option>
                                             @foreach($companyn as $companyn)
                                             <option value="{{$companyn->id}}">{{$companyn->comNameLong}}</option>
										@endforeach
							</select>    
                        
                        <!-- <input type="text" id="deptReportsToCompany" name="deptReportsToCompany"  placeholder="eg: Chief Executive officer" class="form-control" required> -->
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit"  class="btn btn-primary" id="departmentButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="departmentModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="departmentHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="departmentDeleteButton" value="create">Yes</button>
						<button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>                    
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>   -->
<script type="text/javascript">
  
    //Loading the contents of the Datatable from here
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('department.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'deptNameShort', name: 'deptNameShort'},
            {data: 'deptNameLong', name: 'deptNameLong'},
            {data: 'empId', name: 'deptHead'},
            {data: 'serNameLong', name: 'deptReportsToService'},
            {data: 'comNameLong', name: 'deptReportsToCompany'},
            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageDepartment').click(function () {
        $('#departmentButton').val("create-room");
        $('#department_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new Department");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var department_id = $(this).data('id');
     
      $.get("{{ route('department.index') }}" +'/' + department_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Department details");
          $('#departmentButton').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#department_id').val(data.id);
          $('#deptNameShort').val(data.deptNameShort); //input id,database
          $('#deptNameLong').val(data.deptNameLong);
          $('#deptHead').val(data.deptHead);
          $('#deptReportsToService').val(data.deptReportsToService);
          $('#deptReportsToCompany').val(data.deptReportsToCompany);
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#departmentButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Save');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('department.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
              window.onload = callajaxOnPageLoad(page);
             var alt = document.createElement("div");
             alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
             alt.innerHTML = "Data Updated Successfully! ";
             setTimeout(function(){
              alt.parentNode.removeChild(alt);
             },4500);
            document.body.appendChild(alt);                 
       
        
            window.location.href = '/home';
        table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#departmentButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteDepartment', function () {
      var department_id = $(this).data('id');
     
      $.get("{{ route('department.index') }}" +'/' + department_id +'/edit', function (data) {
          $('#departmentHeading').html("Do you want to delete designation name?");
          $('#departmentDeleteButton').val("edit-room");
          $('#departmentModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#department_id').val(data.id);
          $('#deptNameShort').val(data.deptNameShort); //input id,database
          $('#deptNameLong').val(data.deptNameLong);
          $('#deptHead').val(data.empId);
          $('#deptReportsToService').val(data.serNameLong);
          $('#deptReportsToCompany').val(data.comNameLong);
      })
   });
   
  // after clicking yes in delete
    $('#departmentDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroydepartment') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
              window.onload = callajaxOnPageLoad(page);
        var alt = document.createElement("div");
             alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
             alt.innerHTML = "Data Updated Successfully! ";
             setTimeout(function(){
              alt.parentNode.removeChild(alt);
             },4500);
            document.body.appendChild(alt);
            window.location.href = '/home';
			table.draw();                          
          },
          error: function (data) {
              console.log('Error:', data);
              $('#departmentDeleteButton').html('Save Changes');
          }
      });
    });
    
    // $('body').on('click', '.deleteDesignation', function() {
	// 				if(confirm("Do you want to delete it?")) {
	// 					$.ajax({
	// 						dataType: 'json',
	// 						type: "POST",
	// 						url: "{{ route('destroyVehicle') }}",
	// 						data: {
	// 							'id': $(this).data('id'),
	// 							'_token': $('input[name=_token]').val()
	// 						},
	// 						success: function(data) {
	// 							window.onload = callajaxOnPageLoad(page);
	// 							var alt = document.createElement("div");
	// 							alt.setAttribute("style", "position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
	// 							alt.innerHTML = "Data Updated Successfully! ";
	// 							setTimeout(function() {
	// 								alt.parentNode.removeChild(alt);
	// 							}, 4500);
	// 							document.body.appendChild(alt);
	// 							window.location.href = '/manage_vehicle';
	// 							table.draw();
	// 						},
	// 						error: function(data) {
	// 							console.log('Error:', data);
	// 						}
	// 					});
	// 				}
	// 				if(false) {
	// 					window.close();
	// 				}
	// 	});
     
     
</script>

<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
		});
		</script>


