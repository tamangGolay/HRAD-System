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
    <a class="btn success" href="javascript:void(0)" id="manageDivision">Add new Division&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table">
    @csrf
        <thead>
            <tr>

                <th>id</th>
                <th>Division short name</th>
                <th>Division Long name</th>
                <th>Division Dzo Name</th>
                 <th>Division Head</th>
                 <th>Dept Dzo name</th>
                 <th>Service Dzo name</th>
         <!--  <th>Division reports to department</th>
                <th>Division reports to service</th> -->                
                <th >Action</th>

                
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


                   <input type="hidden" name="id" id="division_id">

                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">Division Short Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="divNameShort" name="divNameShort" placeholder="Enter short name" value="" maxlength="50" required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Division Long Name</label>
                        <div class="col-sm-12">
                            <input type="text" id="divNameLong" name="divNameLong"  placeholder="Enter your long name" class="form-control" required>
                        </div>
                    </div> 

                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Division Dzongkhag Name</label>
                        <div class="col-sm-12">
                            <input type="text" id="divDzoId" name="divDzoId"  placeholder="Enter your div dzo name" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Division Head</label>
                        <div class="col-sm-12">
                            <input type="text" id="divHead" name="divHead"  placeholder="Enter your div head" class="form-control" required>
                        </div>
                    </div>

                    

                <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Division Reports to Dept</label>
                        <div class="col-sm-12">
                            <input type="text" id="divReportsToDepartment" name="divReportsToDepartment"  placeholder="to dept" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Dept Dzongkhag Name</label>
                        <div class="col-sm-12">
                            <input type="text" id="deptDzoId" name="deptDzoId"  placeholder="Enter your dept dzo name" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Division Reports to Services</label>
                        <div class="col-sm-12">
                            <input type="text" id="divReportsToService" name="divReportsToService"  placeholder="to service" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Service Dzongkhag Name</label>
                        <div class="col-sm-12">
                            <input type="text" id="serviceDzoId" name="serviceDzoId"  placeholder="Enter your dept dzo name" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Division Reports to Company</label>
                        <div class="col-sm-12">
                            <input type="text" id="divReportsToCompany" name="divReportsToCompany"  placeholder="to company" class="form-control" required>
                        </div>
                    </div>

                                      
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="divisionButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="divisionModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="divisionHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="divisionDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('division.index') }}",
        columns: [
            {data: 'id', name:'id'},
            {data: 'divNameShort', name: 'divNameShort'},
            {data: 'divNameLong', name: 'divNameLong'},
            {data: 'Dzongkhag_Name', name: 'divDzoId'},
            {data: 'empId', name: 'divHead'},
            {data: 'C', name: 'deptDzoId'},
            {data: 'D', name: 'serviceDzoId'},
            // {data: 'divReportsToDepartment', name: 'reportDept'},
            // {data: 'divReportsToService', name: 'reportService'},
            // {data: 'divReportsToEmp', name: 'reportEmp'},
            {data: 'action', name: 'action'}
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageDivision').click(function () {    //manange vehicle
        $('#divisionButton').val("create-room");       
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new Division");   // model heading
        $('#ajaxModel').modal('show');  

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var division_id = $(this).data('id');
     
      $.get("{{ route('division.index') }}" +'/' + division_id +'/edit', function (data) {
          $('#modelHeading').html("Edit division details");
          $('#divisionButton').val("edit-division");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#division_id').val(data.id);
          $('#divNameShort').val(data.divNameShort); //input id,database
          $('#divNameLong').val(data.divNameLong);
          $('#divDzoId').val(data.Dzongkhag_Name);
          $('#divHead').val(data.empId);
          $('#divReportsToDepartment').val(data.divReportsToDepartment);
          $('#deptDzoId').val(data.Dzongkhag_Name);
          $('#divReportsToService').val(data.divReportsToService);
          $('#serviceDzoId').val(data.Dzongkhag_Name);
          $('#divReportsToCompany').val(data.divReportsToCompany);
          
      })
   })

//   After clicking save changes in Add and Edit it will trigger here

    $('#divisionButton').click(function (e) {  //after clicking save changes
       
        e.preventDefault();
        $(this).html('Save');

        

        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('division.store') }}",    // grade-route
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
              $('#divisionButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteDivision', function () {
      var division_id = $(this).data('id');
     
      $.get("{{ route('division.index') }}" +'/' + division_id +'/edit', function (data) {
          $('#divisionHeading').html("Do you want to delete the divison?");
          $('#divisionDeleteButton').val("edit-division");
          $('#divisionModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#division_id').val(data.id);
          $('#divNameShort').val(data.divNameShort); //input id,database
          $('#divNameLong').val(data.divNameLong);
          $('#divDzoId').val(data.Dzongkhag_Name);
          $('#divHead').val(data.empId);
          $('#divReportsToDepartment').val(data.divReportsToDepartment);
          $('#deptDzoId').val(data.Dzongkhag_Name);
          $('#divReportsToService').val(data.divReportsToService);
          $('#serviceDzoId').val(data.Dzongkhag_Name);
          $('#divReportsToCompany').val(data.divReportsToCompany);

      })
   });
   
  // after clicking yes in delete
    $('#divisionDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyDivision') }}",
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
              $('#divisionDeleteButton').html('Save Changes');
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


