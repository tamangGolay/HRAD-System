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

 
    <div class="card-header bg-green">
        <div class="col text-center">
          <h5>
                <b>Qualification Master </b>
              </h5>
			</div>
		
      </div><br>

<div class="container">
    <a class="btn success" href="javascript:void(0)" id="manageQuali">Add new qualification&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>
                 
                <th>Id</th> 
                <th width=250px>Qualification Name</th>
                <th>Qualification Level</th>
                <th>Qualification Field</th> 
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


                   <input type="hidden" name="id" id="qid">

                   <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Qualification Name</label>
                        <div class="col-sm-12">
                            <input type="text" id="qualificationName" name="qualificationName"  placeholder="Qualification Name" class="form-control" required>
                        </div>
                    </div>

                    
                    
                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Qualification Level</label>
                        <div class="col-sm-12">                            

                            <select name="qualificationLevelId" id="qualificationLevelId" class="form-control" value="" required>
                                             <option value="">Select Qualification Name</option>
                                             @foreach($qualificationlevel as $qualificationlevel)
                                             <option value="{{$qualificationlevel->id}}">{{$qualificationlevel->qualiLevelName}}</option>
										@endforeach
							</select>
                        </div>
                    </div> 

                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Qualification Field</label>
                        <div class="col-sm-12">                            

                            <select name="qualificationField" id="qualificationField" class="form-control" value="" required>
                                             <option value="">Select Qualification Field</option>
                                             @foreach($qmaster as $qmaster)
                                             <option value="{{$qmaster->id}}">{{$qmaster->fieldName}}</option>
										@endforeach
							</select>
                        </div>
                    </div>

                    
     
                    <!-- <div class="form-group">
                        <label class="col-sm-2 col-lg-8  control-label">Qualification Field</label>
                        <div class="col-sm-12">
                            <input type="text" id="qualificationField" name="qualificationField"  placeholder="Qualification Field" class="form-control" required>
                        </div>
                    </div>  -->

                    
      
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="qualificationButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="qualificationModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="qualiHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">

                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="qualiDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('qualification.index') }}",     // initial data in data table
        columns: [
            {data: 'id', name: 'id'},
            {data: 'qualificationName', name: 'qualificationName'},
            {data: 'qualiLevelName', name: 'qualilevelmaster.qualiLevelName',searchable: true}, 
            {data: 'fieldName', name: 'fieldmaster.fieldName'},
            {data: 'action', name: 'action', orderable: false, searchable: true},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageQuali').click(function () {
        $('#qualificationButton').val("create-room");
        // $('#vehicle_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new qualification");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var qid = $(this).data('id');
     
      $.get("{{ route('qualification.index') }}" +'/' + qid +'/edit', function (data) {
          $('#modelHeading').html("Edit qualification details");
          $('#qualificationButton').val("edit-qualification");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#qid').val(data.id);
          $('#qualificationName').val(data.qualificationName);
          $('#qualificationLevelId').val(data.qualificationLevelId);          
          $('#qualificationField').val(data.qualificationField);               //input id,database
          
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#qualificationButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Saving...');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('qualification.store') }}",
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
       
            document.body.appendChild(alt);
            $.get('/getView?v=qualilevelmaster',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
            });
            // window.location.href = '/home';
            table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#qualificationButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteQualification', function () {
      var qid = $(this).data('id');
     
      $.get("{{ route('qualification.index') }}" +'/' + qid +'/edit', function (data) {
          $('#qualiHeading').html("Do you want to delete this qualification?");
          $('#qualiDeleteButton').val("edit-qualification");
          $('#qualificationModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#qid').val(data.id);
          $('#qualificationName').val(data.qualificationName);   //input id,database
          $('#qualificationLevelId').val(data.qualificationLevelId);          
          $('#qualificationField').val(data.qualificationField);   
      })
   });
   
  // after clicking yes in delete
    $('#qualiDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Deleting...');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyQualification') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#qualificationModel').modal('hide');
              table.draw();
              window.onload = callajaxOnPageLoad(page);
        var alt = document.createElement("div");
             alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
             alt.innerHTML = "Data Updated Successfully! ";
             setTimeout(function(){
              alt.parentNode.removeChild(alt);
             },4500);
            document.body.appendChild(alt);
            $.get('/getView?v=qualilevelmaster',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
            });
            // window.location.href = '/home';
			table.draw();    
       

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#qualiDeleteButton').html('Save Changes');
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


