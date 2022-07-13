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
    <a class="btn success" href="javascript:void(0)" id="manageSubstation">Add new Substation&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table">
    @csrf
        <thead>
            <tr>

                <th>id</th>
                <th>Short name</th>
                <th>Long name</th>
                <th>Substation Head</th>
                <th>Service Report to Unit</th>
                <th>Service Report to Sub Division</th>
                <th>Service Report to Division</th>
                <th>Service Report to Department</th>
                <th>Service Report to Service</th>
                <th>Service Report to Company</th>
                <th>Service Report to Emp</th> 
                <th >action</th>

                
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


                   <input type="hidden" name="id" id="substation_id">

                   <div class="form-group">
                        <label for="name" class="col-sm-12 col-lg-12 control-label">Short Name</label>
                        <div class="col-sm-12 col-lg-12">
                            <input type="text" class="form-control" id="ssNameShort" name="ssNameShort" placeholder="Enter short name" value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-12 col-lg-12 control-label">Long Name</label>
                        <div class="col-sm-12 col-lg-12">
                            <input type="text" id="ssNameLong" name="ssNameLong"  placeholder="Enter your long name" class="form-control" required>
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-sm-12 col-lg-12 control-label">Substation Head</label>
                        <div class="col-sm-12 col-lg-12">
                            <input type="text" id="ssHead" name="ssHead"  placeholder="" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-12 col-lg-12 control-label">Substation Reports To Unit</label>
                        <div class="col-sm-12 col-lg-12">
                            <input type="text" id="ssReportsToUnit" name="ssReportsToUnit"  placeholder="" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12 col-lg-12 control-label">Substation Reports To Sub_Division</label>
                        <div class="col-sm-12 col-lg-12">
                            <input type="text" id="ssReportsToSubDivision" name="ssReportsToSubDivision"  placeholder="" class="form-control" required>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-12 col-lg-12 control-label">Substation Reports To Division</label>
                        <div class="col-sm-12 col-lg-12">
                            <input type="text" id="ssReportsToDivision" name="ssReportsToDivision"  placeholder="" class="form-control" required>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-12 col-lg-12 control-label">Substation Reports To Department</label>
                        <div class="col-sm-12 col-lg-12">
                            <input type="text" id="ssReportsToDepartment" name="ssReportsToDepartment"  placeholder="" class="form-control" required>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-12 col-lg-12 control-label">Substation Reports To Service</label>
                        <div class="col-sm-12 col-lg-12">
                            <input type="text" id="ssReportsToService" name="ssReportsToService"  placeholder="" class="form-control" required>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-12 col-lg-12 control-label">Substation Reports To Company</label>
                        <div class="col-sm-12 col-lg-12">
                            <input type="text" id="ssReportsToCompany" name="ssReportsToCompany"  placeholder="" class="form-control" required>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-12 col-lg-12 control-label">Substation_Reports_to_Employee</label>
                        <div class="col-sm-12 col-lg-12">
                            <input type="text" id="ssReportsToEmp" name="ssReportsToEmp"  placeholder="" class="form-control" required>
                        </div>
                    </div> 

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit"  class="btn btn-primary" id="substationButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="substationModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="substationHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="substationDeleteButton" value="create">Yes</button>
						<button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>                     </button>
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
        ajax: "{{ route('substation.index') }}",
        columns: [
            {data: 'id', name:'id'},
            {data: 'ssNameShort', name: 'ssNameShort'},
            {data: 'ssNameLong', name: 'ssNameLong'},
            {data: 'ssHead', name: 'ssHead'},
            {data: 'ssReportsToUnit', name: 'ssReportsToUnit'},
            {data: 'ssReportsToSubDivision', name: 'ssReportsToSubDivision'},
            {data: 'ssReportsToDivision', name: 'ssReportsToDivision'},
            {data: 'ssReportsToDepartment', name: 'ssReportsToDepartment'},
            {data: 'ssReportsToService', name: 'ssReportsToService'},
            {data: 'ssReportsToCompany', name: 'ssReportsToCompany'},
            {data: 'ssReportsToEmp', name: 'ssReportsToEmp'},
            {data: 'action', name: 'action'}
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageSubstation').click(function () {    //manange vehicle
        $('#substationButton').val("create-room");       
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new Substation");   // model heading
        $('#ajaxModel').modal('show');  

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var substation_id = $(this).data('id');
     
      $.get("{{ route('substation.index') }}" +'/' + substation_id +'/edit', function (data) {
          $('#modelHeading').html("Edit division details");
          $('#substationButton').val("edit-division");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#substation_id').val(data.id);
          $('#ssNameShort').val(data.ssNameShort); //input id,database
          $('#ssNameLong').val(data.ssNameLong);
          $('#ssHead').val(data.ssHead);
          $('#ssReportsToUnit').val(data.ssReportsToUnit);
          $('#ssReportsToSubDivision').val(data.ssReportsToSubDivision);
          $('#ssReportsToDivision').val(data.ssReportsToDivision);
          $('#ssReportsToDepartment').val(data.ssReportsToDepartment);
          $('#ssReportsToService').val(data.ssReportsToService);
          $('#ssReportsToCompany').val(data.ssReportsToCompany);
          $('#ssReportsToEmp').val(data.ssReportsToEmp);
          
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#substationButton').click(function (e) {  //after clicking save changes
       
        e.preventDefault();
        $(this).html('Save');

        

        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('substation.store') }}",    // grade-route
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
              $('#substationButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteSubstation', function () {
      var substation_id = $(this).data('id');
     
      $.get("{{ route('substation.index') }}" +'/' + substation_id +'/edit', function (data) {
          $('#substationHeading').html("Do you want to delete the divison?");
          $('#substationDeleteButton').val("edit-division");
          $('#substationModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#substation_id').val(data.id);
          $('#ssNameShort').val(data.ssNameShort); //input id,database
          $('#ssNameLong').val(data.ssNameLong);
          $('#ssHead').val(data.ssHead);
          $('#ssReportsToUnit').val(data.ssReportsToUnit);
          $('#ssReportsToSubDivision').val(data.ssReportsToSubDivision);
          $('#ssReportsToDivision').val(data.ssReportsToDivision);
          $('#ssReportsToDepartment').val(data.ssReportsToDepartment);
          $('#ssReportsToService').val(data.ssReportsToService);
          $('#ssReportsToCompany').val(data.ssReportsToCompany);
          $('#ssReportsToEmp').val(data.ssReportsToEmp);

      })
   });
   
  // after clicking yes in delete
    $('#substationDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroySubstation') }}",
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
              $('#substationDeleteButton').html('Save Changes');
          }
      });
    });
    
    // $('body').on('click', '.deleteVehicle', function() {
	// 				if(confirm("Do you want to delete it?")) {
	// 					$.ajax({
	// 						dataType: 'json',
	// 						type: "POST",
	// 						url: "{{ route('destroyDivision') }}",
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


