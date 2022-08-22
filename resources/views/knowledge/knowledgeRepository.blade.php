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
    <!-- <a class="btn success" href="javascript:void(0)" id="manageknowledge">Add new knowledge&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a> -->
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>
			<th>Sl No</th>

							<th>Name</th>
							<!-- <th>Contact Number</th> -->
							<th>Problem</th>
							<th>Solution</th>
							<th>Office</th>
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

                <!-- <div class="form-group"> -->
                        <!-- <label for="name" class="col-sm-2 control-label">knowledgeId</label> -->
                        <!-- <div class="col-sm-12"> -->
                        <input type="hidden" class="form-control" name="id" id="knowledge_id">
                        <!-- <input type="text" class="form-control" id="knowledgeName" name="knowledgeName" value=""  required> -->

                        <!-- </div> -->
                    <!-- </div> -->

					<div class="form-group row">
									<label class="col-sm-4 text-md-right" for="empId">{{ __('EmpId:') }}</label>
									<div class="col-sm-8">
									<input type="text"  class="form-control" value="" name="empId" id="empId" required readonly> 

									</div>
								</div>

					<div class="form-group row">
									<label class="col-sm-4 text-md-right" for="emp_id">{{ __('Name:') }}</label>
									<div class="col-sm-8">
									<input type="text"  class="form-control" value="" name="empName" id="empName" required readonly> 

									</div>
								</div>

					<div class="form-group row">
									<label class="col-sm-4 text-md-right" for="emp_id">{{ __('Office:') }}</label>
									<div class="col-sm-8">
									<select name="officeDetails" id="officeDetails" value="" class="form-control" required readonly>
                                             <option value="">Select officeDetails</option>
                                             @foreach($userList as $officeDetails)

                                             <option value="{{$officeDetails->id}}">{{$officeDetails->officeDetails}}</option>
										@endforeach
							</select>
									</div>
								</div>
								

								<!-- <div class="form-group row">
									<label class="col-sm-4 text-md-right" for="emp_id">{{ __('Office:') }}</label>
									<div class="col-sm-8">
									<input type="text" class="form-control" value="" name="officeName" id="officeName" required readonly> 
									<input type="text" class="form-control" value="" name="office" id="office" required readonly> 

									</div>
								</div> -->


						
							

								<div class="form-group row">
									<label class="col-sm-4 text-md-right" for="problem">{{ __('Problem:') }}</label>
									<div class="col-sm-8">
									<textarea type="text" rows="14" class="form-control" value="" name="problem" id="problem" required readonly> 
                         			</textarea></div>
								</div>

								<div class="form-group row">
									<label class="col-sm-4 text-md-right" for="solution">{{ __('Solution:') }}</label>
									<div class="col-sm-8">
									<textarea type="text" rows="14" class="form-control" value="" name="solution" id="solution" required readonly> 
                         			</textarea></div>

									<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
									<!-- <button type="submit" class="btn btn-outline-success" id="saveBtn" value="create">Save changes </button> -->
									<!-- <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>       -->

								</div>
     
                   
								
      
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="knowledgeModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="knowledgeHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="knowledgeDeleteButton" value="create">Yes</button>
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
        "searching": true,
		"ordering": true,
		"paging": true,
        ajax: "{{ route('knowledge.index') }}",
        columns: [
            {data: 'id', name: 'id',orderable: true, searchable: true},
            {data: 'empName', name: 'empName', orderable: false, searchable: true},
			// {data: 'mobileNo', name: 'mobileNo', orderable: true, searchable: true},
			 {data: 'problem', name: 'problem', orderable: false, searchable: true},
            {data: 'solution', name: 'solution', orderable: true, searchable: true},
			{data: 'officeDetails', name: 'officeDetails', orderable: true, searchable: true},

            {data: 'action', name: 'action', orderable: true, searchable: false},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageknowledge').click(function () {
        $('#knowledgeButton').val("create-room");
        $('#knowledge_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new knowledge");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.editknowledge', function () {
      var knowledge_id = $(this).data('id');
     
      $.get("{{ route('knowledge.index') }}" +'/' + knowledge_id +'/edit', function (data) {
          $('#modelHeading').html("Knowledge details");
          $('#knowledgeButton').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#knowledge_id').val(data.id);
		  $('#empName').val(data.empName); //input id,database
		  $('#empId').val(data.createdBy); //input id,database
		  $('#office').val(data.Address); //input id,database
          $('#problem').val(data.problem); //input id,database
         $('#solution').val(data.solution);//keeping input name and dB field name same so that the search will not give error
		 $('#officeDetails').val(data.id); //input id,database

	  })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#knowledgeButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Saving...');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('knowledge.store') }}",
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
       
        
            // window.location.href = '/home'
            document.body.appendChild(alt);
            $.get('/getView?v=knowledgeRepository',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
            });
        table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#knowledgeButton').html('Save Changes');
              alert("Please choose both the fields");
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteknowledge', function () {
      var knowledge_id = $(this).data('id');
     
      $.get("{{ route('knowledge.index') }}" +'/' + knowledge_id +'/edit', function (data) {
          $('#knowledgeHeading').html("Do you want to delete the knowledge?");
          $('#knowledgeDeleteButton').val("edit-room");
          $('#knowledgeModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#knowledge_id').val(data.id);
          $('#knowledgeClass').val(data.knowledgeClass); //input id,database
            $('#knowledgeName').val(data.knowledgeName); //input id,database
          $('#dzongkhagId').val(data.dzongkhagId);
      })
   });
   
  
    
   
     
     
</script>

<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
		});
		</script>


