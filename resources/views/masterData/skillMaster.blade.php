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
    <a class="btn success" href="javascript:void(0)" id="manageSkillmaster">Add New Skills&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table">
    @csrf
        <thead>
            <tr>
                <th>No</th>
                <th>Skill Name</th> 
                <th>Skill Sub Category Id</th>
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

                   <input type="hidden" name="id" id="skillmaster_id">
                    <div class="form-group">
                        <label for="name" class="col-lg-12 col-sm-12 control-label">Skill Name</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" class="form-control" id="skillName" name="skillName" placeholder="eg: Development" value="" maxlength="50" required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label"> Sub Skill Category</label>
                        <div class="col-lg-12 col-sm-12">
                            <select class="col-lg-12 col-sm-12 form-control" name="subCatId" id="subCatId" value="" required>
                                             <option value="">Select Skills Category</option>
                                             @foreach($skilm as $skilm)
                                             <option value="{{$skilm->id}}">{{$skilm->subCatName}}</option>
										@endforeach
							</select>  
                        
                        <!-- <input type="text" id="subCatId" name="subCatId"  placeholder="eg: 12" class="form-control" required> -->
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="skillmasterButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="skillmasterModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="skillmasterHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="skillmasterDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('skillmaster.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'skillName', name: 'skillName'},
            {data: 'subCatName', name: 'subCatId'},
            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageSkillmaster').click(function () {
        $('#skillmasterButton').val("create-room");
        $('#skillmaster_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new Skills");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var skillmaster_id = $(this).data('id');
     
      $.get("{{ route('skillmaster.index') }}" +'/' + skillmaster_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Skill details");
          $('#skillmasterButton').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#skillmaster_id').val(data.id);
          $('#skillName').val(data.skillName); //input id,database
          $('#subCatId').val(data.subCatId);
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#skillmasterButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Saving...');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('skillmaster.store') }}",
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
       //to redirect page to same page 

       $.get('/getView?v=skillmaster',function(data){        
           $('#contentpage').empty();                          
           $('#contentpage').append(data.html);
            });
        
            // window.location.href = '/home';
        table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#skillmasterButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteSkillmaster', function () {
      var skillmaster_id = $(this).data('id');
     
      $.get("{{ route('skillmaster.index') }}" +'/' + skillmaster_id +'/edit', function (data) {
          $('#skillmasterHeading').html("Do you want to delete it?");
          $('#skillmasterDeleteButton').val("edit-room");
          $('#skillmasterModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#skillmaster_id').val(data.id);
          $('#skillName').val(data.skillName); //input id,database
          $('#subCatId').val(data.subCatId);
      })
   });
   
  // after clicking yes in delete
    $('#skillmasterDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Deleting...');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyskillmaster') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#skillmasterModel').modal('hide');
              table.draw();
              window.onload = callajaxOnPageLoad(page);
        var alt = document.createElement("div");
             alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
             alt.innerHTML = "Data Updated Successfully! ";
             setTimeout(function(){
              alt.parentNode.removeChild(alt);
             },4500);
            document.body.appendChild(alt);

            //to redirect page to same page 

       $.get('/getView?v=skillmaster',function(data){        
           $('#contentpage').empty();                          
           $('#contentpage').append(data.html);
            });
            
            // window.location.href = '/home';
			table.draw();                          
          },
          error: function (data) {
              console.log('Error:', data);
              $('#skillmasterDeleteButton').html('Save Changes');
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


