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
    <a class="btn success" href="javascript:void(0)" id="manageUnit">Add new Unit&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table">
    @csrf
        <thead>
            <tr>

                <th>id</th>
                <th>Unit short name</th>
                <th>Unit Long name</th>
                <th>Unit Head</th>
                <!-- <th>Division reports to department</th>
                <th>Division reports to service</th>
                <th>Division reports to Employe</th> --> 
                <th>action</th>
                
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


                   <input type="hidden" name="id" id="unit_id">

                    <div class="form-group">
                        <label for="name" class="col-sm-2  col-lg-8 control-label">Short Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="unitNameShort" name="unitNameShort" placeholder="Enter unit short name" value="" maxlength="50" required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2  col-lg-8 control-label">Long Name</label>
                        <div class="col-sm-12">
                            <input type="text" id="unitNameLong" name="unitNameLong"  placeholder="Enter unit long name" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Unit Head</label>
                        <div class="col-sm-12">
                            <input type="text" id="unitHead" name="unitHead"  placeholder="Enter unit head" class="form-control" required>
                        </div>
                    </div>
                    
                   <!-- <div class="form-group">
                        <label class="col-sm-2 control-label">Unit Reports to Sub div</label>
                        <div class="col-sm-12">
                            <input type="text" id="unitReportsToSubDivision" name="unitReportsToSubDivision"  placeholder="unit reports to subdiv" class="form-control" required>
                        </div>
                    </div>  

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Unit Reports to Div</label>
                        <div class="col-sm-12">
                            <input type="text" id="unitReportsToDivision" name="unitReportsToDivision"  placeholder="unit reports to Div" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Unit Reports to Department</label>
                        <div class="col-sm-12">
                            <input type="text" id="unitReportsToDepartment" name="unitReportsToDepartment"  placeholder="unit reports to Dept" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Unit Reports to Service</label>
                        <div class="col-sm-12">
                            <input type="text" id="unitReportsToService" name="unitReportsToService"  placeholder="unit reports to Service" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Unit Reports to Company</label>
                        <div class="col-sm-12">
                            <input type="text" id="unitReportsToCompany" name="unitReportsToCompany"  placeholder="unit reports to Company" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Unit Reports to Emp</label>
                        <div class="col-sm-12">
                            <input type="text" id="unitReportsToEmp" name="unitReportsToEmp"  placeholder="unit reports to Emp" class="form-control" required>
                        </div>
                    </div>   -->

      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit"  class="btn btn-primary" id="unitButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="unitModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="unitHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="unitDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('unit.index') }}",
        columns: [
            {data: 'id', name:'id'},
            {data: 'unitNameShort', name: 'unitNameShort'},
            {data: 'unitNameLong', name: 'unitNameLong'},
            {data: 'unitHead', name: 'unitHead'},
            // {data: 'unitReportsToSubDivision', name: 'unitReportsToSubDivision'},
            // {data: 'unitReportsToDivision', name: 'unitReportsToDivision'},
            // {data: 'unitReportsToDepartment', name: 'unitReportsToDepartment'},
            // {data: 'unitReportsToService', name: 'unitReportsToService'},
            // {data: 'unitReportsToCompany', name: 'unitReportsToCompany'},
            // {data: 'unitReportsToEmp', name: 'unitReportsToEmp'},           
            {data: 'action', name: 'action'}
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageUnit').click(function () {       //manange vehicle
        $('#unitButton').val("create-room");       
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new Unit");   // model heading
        $('#ajaxModel').modal('show');  

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var unit_id = $(this).data('id');
     
      $.get("{{ route('unit.index') }}" +'/' + unit_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Unit details");
          $('#unitButton').val("edit-unit");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#unit_id').val(data.id);
          $('#unitNameShort').val(data.unitNameShort); //input id,database
          $('#unitNameLong').val(data.unitNameLong);
          $('#unitHead').val(data.unitHead);
        //  $('#unitReportsToSubDivision').val(data.unitReportsToSubDivision);
        //  $('#unitReportsToDivision').val(data.unitReportsToDivision);
        //  $('#unitReportsToDepartment').val(data.unitReportsToDepartment);
        //  $('#unitReportsToService').val(data.unitReportsToService);
        //  $('#unitReportsToCompany').val(data.unitReportsToCompany);
        //  $('#unitReportsToEmp').val(data.unitReportsToEmp);

      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#unitButton').click(function (e) {  //after clicking save changes
       
        e.preventDefault();
        $(this).html('Save');

        

        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('unit.store') }}",    // unit-route
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
              $('#unitButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteUnit', function () {
      var unit_id = $(this).data('id');
     
      $.get("{{ route('unit.index') }}" +'/' + unit_id +'/edit', function (data) {
          $('#unitHeading').html("Do you want to delete this unit?");
          $('#unitDeleteButton').val("edit-unit");
          $('#unitModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#unit_id').val(data.id);
          $('#unitNameShort').val(data.unitNameShort); //input id,database
          $('#unitNameLong').val(data.unitNameLong);
          $('#unitHead').val(data.unitHead);
        //  $('#unitReportsToSubDivision').val(data.unitReportsToSubDivision);
        //  $('#unitReportsToDivision').val(data.unitReportsToDivision);
        //  $('#unitReportsToDepartment').val(data.unitReportsToDepartment);
        //  $('#unitReportsToService').val(data.unitReportsToService);
        //  $('#unitReportsToCompany').val(data.unitReportsToCompany);
        //  $('#unitReportsToEmp').val(data.unitReportsToEmp);
      })
   });
   
  // after clicking yes in delete
    $('#unitDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyUnit') }}",
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
              $('#unitDeleteButton').html('Save Changes');
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


