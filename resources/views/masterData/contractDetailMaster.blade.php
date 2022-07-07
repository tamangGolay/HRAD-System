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
    <a class="btn success" href="javascript:void(0)" id="manageContractDetail">Add new Contract Details &nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table">
    @csrf
        <thead>
            <tr>
                <th>id</th>
                <th>Personal Number</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Term Number</th>
                <th width="300px">action</th> 
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


                   <input type="hidden" name="id" id="contractdetail_id">

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Personal_Number</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="personalNo" name="personalNo" placeholder="Enter your Personal Number" value="" maxlength="50" required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Start_Date</label>
                        <div class="col-sm-12">
                            <input type="text" id="startDate" name="startDate"  placeholder="Enter start date" class="form-control" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label">End_Date</label>
                        <div class="col-sm-12">
                            <input type="text" id="endDate" name="endDate"  placeholder="Enter end date" class="form-control" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label">Term_Number</label>
                        <div class="col-sm-12">
                            <input type="text" id="termNo" name="termNo"  placeholder="Enter your term number" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit"  class="btn btn-primary" id="contractdetailButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="contractdetailModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="contractdetailHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="contractDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('contractdetail.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'personalNo', name: 'personalNo'},
            {data: 'startDate', name: 'startDate'},
            {data: 'endDate', name: 'endDate'},
            {data: 'termNo', name: 'termNo'},
            {data: 'action', name: 'action'}
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageContractDetail').click(function () {    //manange contract detail
        $('#contractdetailButton').val("create-room");
        $('#contractdetail_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new Contract Detail");   // model heading
        $('#ajaxModel').modal('show');  

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var contractdetail_id = $(this).data('id');
     
      $.get("{{ route('contractdetail.index') }}" +'/' + contractdetail_id +'/edit', function (data) {
          $('#modelHeading').html("Edit contract details");
          $('#contractdetailButton').val("edit-contractdetail");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#contractdetail_id').val(data.id);
          $('#personalNo').val(data.personalNo); //input id,database
          $('#startDate').val(data.startDate);
          $('#endDate').val(data.endDate);
          $('#termNo').val(data.termNo);

      })
   });


//   After clicking save changes in Add and Edit it will trigger here

    $('#contractdetailButton').click(function (e) {  //after clicking save changes
       
        e.preventDefault();
        $(this).html('Save');

    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('contractdetail.store') }}",    // grade-route
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
              $('#contractdetailButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });


  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteContractdetail', function () {
      var contractdetail_id = $(this).data('id');
     
      $.get("{{ route('contractdetail.index') }}" +'/' + contractdetail_id +'/edit', function (data) {
          $('#contractdetailHeading').html("Do you want to delete the Contract Detail?");
          $('#contractDeleteButton').val("edit-contractdetail");
          $('#contractdetailModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#contractdetail_id').val(data.id);
          $('#personalNo').val(data.personalNo); //input id,database
          $('#startDate').val(data.startDate);
          $('#endDate').val(data.endDate);
          $('#termNo').val(data.termNo);
      })
   });
   
  // after clicking yes in delete
    $('#contractDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyContractDetail') }}",
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
              $('#contractDeleteButton').html('Save Changes');
          }
      });
    });
    
    // $('body').on('click', '.deleteVehicle', function() {
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


