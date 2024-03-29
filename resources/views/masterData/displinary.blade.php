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
    <a class="btn success" href="javascript:void(0)" id="manageDisplinary">Add new Disciplinary&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>
                 
                <th>Sl.No</th> 
                <th>Personal No</th>
                <th>Increment date</th>
                <th>Case</th> 
                <th>Action Taken</th> 
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

                        <label for="name" class="col-sm-2 col-lg-8 control-label">Personal No</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="personalNo" name="personalNo" placeholder="Personal No." value="" maxlength="50" required>
                        </div>
                    </div>     
     
                    

                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Increment Date</label>
                        <div class="col-sm-12">
                            <input type="date" id="issueDate" name="issueDate"  placeholder="Increment date" class="form-control" required>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Case</label>
                        <div class="col-sm-12">
                            <input type="text" id="case" name="case"  placeholder="case" class="form-control" required>
                        </div>
                    </div> -->

                    <div class="form-group">
						<label class="col-md-2 col-lg-8 control-label" for="Case">&nbsp;&nbsp;&nbsp;Case</label>
						<div class="col-md-12 ">
						<textarea input type="text" id="case" placeholder="Case" rows="14" class="form-control" name="case" autocomplete="off"  required> 
                         </textarea></div>
					</div> 

                    <div class="form-group">
						<label class="col-md-2 col-lg-8 control-label " for="Case">&nbsp;&nbsp;Action taken</label>
						<div class="col-md-12 ">
						<textarea input type="text" id="actionTaken" placeholder="Action Taken" rows="14" class="form-control" name="actionTaken" autocomplete="off" id="actionTaken" required> 
                         </textarea></div>
					</div>

                    <!-- <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Action taken</label>
                        <div class="col-sm-12">
                            <input type="text" id="actionTaken" name="actionTaken"  placeholder="Action taken" class="form-control" required>
                        </div>
                    </div> -->
      
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="displinaryButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="displinaryModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="displinaryHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="displinaryDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('displinary.index') }}",     // initial data in data table
        columns: [
            {data: 'id', name: 'id'},
            {data: 'empId', name: 'users.empId'},
            {data: 'issueDate', name: 'issueDate'},
            {data: 'case', name: 'case'},
            {data: 'actionTaken', name: 'actionTaken'},
            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageDisplinary').click(function () {
        $('#displinaryButton').val("create-room");
        // $('#vehicle_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new displinary");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var qid = $(this).data('id');
     
      $.get("{{ route('displinary.index') }}" +'/' + qid +'/edit', function (data) {
          $('#modelHeading').html("Edit displinary details");
          $('#displinaryButton').val("edit-displinary");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#qid').val(data.id);
          $('#personalNo').val(data.personalNo);
          $('#issueDate').val(data.issueDate);
          $('#case').val(data.case); //input id,database
          $('#actionTaken').val(data.actionTaken);
          
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#displinaryButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Saving...');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('displinary.store') }}",
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

         $.get('/getView?v=displinaryhistorymaster',function(data){        
           $('#contentpage').empty();                          
           $('#contentpage').append(data.html);
            });
        
            // window.location.href = '/home';
            table.draw();    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#displinaryButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteDisplinary', function () {
      var qid = $(this).data('id');
     
      $.get("{{ route('displinary.index') }}" +'/' + qid +'/edit', function (data) {
          $('#displinaryHeading').html("Do you want to delete this displinary action?");
          $('#displinaryDeleteButton').val("edit-displinary");
          $('#displinaryModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#qid').val(data.id);
          $('#personalNo').val(data.personalNo);
          $('#issueDate').val(data.issueDate);
          $('#case').val(data.case); //input id,database
          $('#actionTaken').val(data.actionTaken);
      })
   });
   
  // after clicking yes in delete
    $('#displinaryDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Deleting...');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyDisplinary') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#displinaryModel').modal('hide');
              table.draw();
              window.onload = callajaxOnPageLoad(page);
        var alt = document.createElement("div");
             alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
             alt.innerHTML = "Data Updated Successfully! ";
             setTimeout(function(){
              alt.parentNode.removeChild(alt);
             },4500);
            document.body.appendChild(alt);

        //*to redirect page to same page again

        $.get('/getView?v=displinaryhistorymaster',function(data){        
        $('#contentpage').empty();                          
        $('#contentpage').append(data.html);
         });
            // window.location.href = '/home';
			table.draw();  
         
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#displinaryDeleteButton').html('Save Changes');
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


