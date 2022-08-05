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
</style>



<link href="{{asset('css/bose.css')}}" rel="stylesheet">
<!-- called in bose.css -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->

 
<div class="container">
    <a class="btn success" href="javascript:void(0)" id="manageEmpQuali">Add new qualification&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>                 
                <th>Sl.No</th> 
                <th>Personal No.</th>
                <th>Qualification Name</th>      
                <th width=90px>Year Completed</th>           
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


                   <input type="hidden" name="id" id="eqid">  
                    
                    
                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Personal Number</label>
                        <div class="col-sm-12">                            

                            <select name="personalNo" id="personalNo" class="form-control" value="" required>
                                             <option value="">Select Personal No</option>
                                             @foreach($pno as $pno)
                                             <option value="{{$pno->id}}">{{$pno->empId}}</option>
										@endforeach
							</select>
                        </div>
                    </div>
     
                    
                    
                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Qualification Name</label>
                        <div class="col-sm-12">
                            

                            <select name="qualificationId" id="qualificationId" class="form-control" value="" required>
                                             <option value="">Select Qualification</option>
                                             @foreach($qualification as $qualification)
                                             <option value="{{$qualification->id}}">{{$qualification->qualificationName}}</option>
										@endforeach
							</select>
                        </div>
                    </div>
                    

                     <div class="form-group">

                        <label for="name" class="col-sm-2 col-lg-8 control-label">Year Completed</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="yearCompleted" name="yearCompleted" placeholder="Year completion" value="" maxlength="50" required>
                        </div>
                    </div>                     
      
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="employeeQualiButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="employeeQualiModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="employeeQualiHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">

                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="employeeQualiDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('employeeQualification.index') }}",     // initial data in data table
        columns: [
            {data: 'id', name: 'id'},
            {data: 'empId', name: 'users.empId'},
            {data: 'qualificationName', name: 'qualificationmaster.qualificationName'},
            {data: 'yearCompleted', name: 'yearCompleted'},           
            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageEmpQuali').click(function () {
        $('#employeeQualiButton').val("create-room");
        // $('#vehicle_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new employee qualification");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var eqid = $(this).data('id');
     
      $.get("{{ route('employeeQualification.index') }}" +'/' + eqid +'/edit', function (data) {
          $('#modelHeading').html("Edit qualification details");
          $('#employeeQualiButton').val("edit-empqualification");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#eqid').val(data.id);
          $('#personalNo').val(data.personalNo);
          $('#qualificationId').val(data.qualificationId);   //input id,database 
          $('#yearCompleted').val(data.yearCompleted);        
         
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#employeeQualiButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Saving...');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('employeeQualification.store') }}",
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
            $.get('/getView?v=employeequalificationmaster',function(data){
        
        $('#contentpage').empty();                          
        $('#contentpage').append(data.html);
        });  
        
            // window.location.href = '/home';
            table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#employeeQualiButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteEmpQualification', function () {
      var eqid = $(this).data('id');
     
      $.get("{{ route('employeeQualification.index') }}" +'/' + eqid +'/edit', function (data) {
          $('#employeeQualiHeading').html("Do you want to delete this emp qualification?");
          $('#employeeQualiDeleteButton').val("edit-empqualification");
          $('#employeeQualiModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#eqid').val(data.id);
          $('#personalNo').val(data.personalNo);
          $('#qualificationId').val(data.qualificationId); //input id,database
          $('#yearCompleted').val(data.yearCompleted);  
          
      })
   });
   
  // after clicking yes in delete
    $('#employeeQualiDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Deleting...');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyEmpQualification') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#employeeQualiModel').modal('hide');
              table.draw();
              window.onload = callajaxOnPageLoad(page);
        var alt = document.createElement("div");
             alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
             alt.innerHTML = "Data Updated Successfully! ";
             setTimeout(function(){
              alt.parentNode.removeChild(alt);
             },4500);
            document.body.appendChild(alt);
            document.body.appendChild(alt);              
            $.get('/getView?v=employeequalificationmaster',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
             }); 			
             table.draw();           
       

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#employeeQualiDeleteButton').html('Save Changes');
          }
      });
    });
    
  
     
</script>

<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
		});
		</script>


