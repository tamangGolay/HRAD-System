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
    <a class="btn success" href="javascript:void(0)" id="manageGrade">Add new Post &nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>
                <th>id</th>
                <th>short Name</th>
                <th>long Name</th>
                <th>Position Specific Allowance</th>
                <th>Contract Allowance</th>
                <th>Communication Allowance</th>
                <th>Type</th>
                <th width="200px">action</th>

                
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


                   <input type="hidden" name="id" id="post_id">

                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">Short Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="shortName" name="shortName" placeholder="Enter short name" value="" maxlength="50" required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Long Name</label>
                        <div class="col-sm-12">
                            <input type="text" id="longName" name="longName"  placeholder="" class="form-control" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Position Specific Allowance</label>
                        <div class="col-sm-12">
                            <input type="text" id="positionSpecificAllowance" name="positionSpecificAllowance"  placeholder="" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Contract Allowance</label>
                        <div class="col-sm-12">
                            <input type="text" id="contractAllowance" name="contractAllowance"  placeholder="" class="form-control" required>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Communication Allowance</label>
                        <div class="col-sm-12">
                            <input type="text" id="communicationAllowance" name="communicationAllowance"  placeholder="" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Type</label>
                        <div class="col-sm-12">
                            <input type="text" id="type" name="type"  placeholder="" class="form-control" required>
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit"  class="btn btn-primary" id="postButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="gradeModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="postHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="gradeDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('postmaster.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'shortName', name: 'shortName'},
            {data: 'longName', name: 'longName'},
            {data: 'positionSpecificAllowance', name: 'positionSpecificAllowance'},
            {data: 'contractAllowance', name: 'contractAllowance'},
            {data: 'communicationAllowance', name: 'communicationAllowance'},
            {data: 'type', name: 'type'},
            {data: 'action', name: 'action'}
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageGrade').click(function () {    //manange vehicle
        $('#postButton').val("create-room");
        $('#post_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new post master");   // model heading
        $('#ajaxModel').modal('show');  

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var post_id = $(this).data('id');
     
      $.get("{{ route('postmaster.index') }}" +'/' + post_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Post details");
          $('#postButton').val("edit-grade");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#post_id').val(data.id);
          $('#shortName').val(data.shortName); //input id,database
          $('#longName').val(data.longName);
          $('#positionSpecificAllowance').val(data.positionSpecificAllowance);
          $('#contractAllowance').val(data.contractAllowance);
          $('#communicationAllowance').val(data.communicationAllowance);
          $('#type').val(data.type);
          
      })
   });


//   After clicking save changes in Add and Edit it will trigger here

    $('#postButton').click(function (e) {  //after clicking save changes
       
        e.preventDefault();
        $(this).html('Save');

        

        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('postmaster.store') }}",    // grade-route
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
            $.get('/getView?v=postmaster',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
            });
        
            // window.location.href = '/home';
        table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#postButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });


  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteGrade', function () {
      var post_id = $(this).data('id');
     
      $.get("{{ route('postmaster.index') }}" +'/' + post_id +'/edit', function (data) {
          $('#postHeading').html("Do you want to delete the post master?");
          $('#gradeDeleteButton').val("edit-grade");
          $('#gradeModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#post_id').val(data.id);
          $('#shortName').val(data.shortName); //input id,database
          $('#longName').val(data.longName);
          $('#positionSpecificAllowance').val(data.positionSpecificAllowance);
          $('#contractAllowance').val(data.contractAllowance);
          $('#communicationAllowance').val(data.communicationAllowance);
          $('#type').val(data.type);
      })
   });
   
  // after clicking yes in delete
    $('#gradeDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyPostMaster') }}",
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
            $.get('/getView?v=postmaster',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
            });
            // window.location.href = '/home';
			table.draw();                 
       
       

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#gradeDeleteButton').html('Save Changes');
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


