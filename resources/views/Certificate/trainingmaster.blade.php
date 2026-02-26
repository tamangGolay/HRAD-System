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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

<div class="container">
    <a class="btn success" href="javascript:void(0)" id="manageTraining">Add new Training&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>

                <th>Training ID</th>
                <th>Training Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Institute</th>
                <th>Place</th>
                 <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="modal fade" id="trainingMasterModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="trainingmasterHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   <input type="hidden" name="trainingId" id="training_id">

                    <div class="form-group">
                        <label for="name" class="col-lg-12 col-sm-12 control-label">Training Name</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" class="form-control" id="trainingName" name="trainingName" placeholder="eg: Ariba Training" value="" maxlength="50" required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Start Date</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="date" id="startDate" name="startDate"   class="form-control" required>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">End Date</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="date" id="endDate" name="endDate"   class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-lg-12 col-sm-12 control-label">Institute</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" class="form-control" id="institute" name="institute"  value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-lg-12 col-sm-12 control-label">Place</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" class="form-control" id="place" name="place"  value="" maxlength="50" required>
                        </div>
                    </div>

                     <div class="form-group">
                        <label for="name" class="col-lg-12 col-sm-12 control-label">Signer1 Name</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" class="form-control" id="signer1Name" name="signer1Name"  value="" maxlength="50" required>
                        </div>
                    </div>

                     <div class="form-group">
                        <label for="name" class="col-lg-12 col-sm-12 control-label">Signer1 Designation</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" class="form-control" id="signer1Designation" name="signer1Designation"  value="" maxlength="50" required>
                        </div>
                    </div>

                     <div class="form-group">
                        <label for="name" class="col-lg-12 col-sm-12 control-label">Signer2 Name</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" class="form-control" id="signer2Name" name="signer2Name"  value="" maxlength="50" required>
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label for="name" class="col-lg-12 col-sm-12 control-label">Signer2 Designation</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" class="form-control" id="signer2Designation" name="signer2Designation"  value="" maxlength="50" required>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="trainingButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteTrainingmodal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="designationHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="deleteForm" name="deleteForm" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">
                  <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="trainingDeleteButton" value="create">Yes</button>
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
<script type="text/javascript">
  
    //Loading the contents of the Datatable from here
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('trainingmaster.index') }}",
        columns: [
            {data: 'trainingId', name: 'trainingId'},
            {data: 'trainingName', name: 'trainingName'},
            {data: 'startDate', name: 'startDate'},
            {data: 'endDate', name: 'endDate'},
            {data: 'institute', name: 'institute'},
            {data: 'place', name: 'place'},
            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageTraining').click(function () {
        $('#trainingButton').val("create-room");
        $('#training_id').val('');
        $('#Form').trigger("reset");
        $('#trainingmasterHeading').html("Add new Training");
        $('#trainingMasterModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
        var training_id = $(this).attr('data-trainingId'); 
     
      $.get("{{ route('trainingmaster.index') }}" +'/' + training_id +'/edit', function (data) {
          $('#trainingmasterHeading').html("Edit Training details");
          $('#trainingButton').val("edit-room");
          $('#trainingMasterModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
        $('#training_id').val(data.trainingId); // hidden input
          $('#trainingName').val(data.trainingName); //input id,database
          $('#startDate').val(data.startDate);
          $('#endDate').val(data.endDate); //input id,database
          $('#institute').val(data.institute);
          $('#place').val(data.place);
          $('#signer1Name').val(data.signer1Name); //input id,database
          $('#signer1Designation').val(data.signer1Designation);
          $('#signer2Name').val(data.signer2Name); //input id,database
          $('#signer2Designation').val(data.signer2Designation);
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#trainingButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Saving...');
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('trainingmaster.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#trainingMasterModel').modal('hide');
              table.draw();
              window.onload = callajaxOnPageLoad(page);
             var alt = document.createElement("div");
             alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
             alt.innerHTML = "Data Updated Successfully! ";
             setTimeout(function(){
              alt.parentNode.removeChild(alt);
             },4500);
            document.body.appendChild(alt);                 
       
            $.get('/getView?v=trainingmaster',function(data){
        
        $('#contentpage').empty();                          
        $('#contentpage').append(data.html);
        }); 
            // window.location.href = '/home';
        table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#trainingButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
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


