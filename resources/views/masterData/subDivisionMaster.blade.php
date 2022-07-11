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
    <a class="btn success" href="javascript:void(0)" id="manageSubDivision">Add new  SUb Division&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table">
    @csrf
        <thead>
            <tr>

                <th>id</th>
                <th>Short name</th>
                <th>Long name</th>
                <th>Sub Division Head</th>
                <th>Reports to Division</th>
                <th>Reports to Department</th>
                <th>Reports to Service</th>
                <th>Reports to Company</th>
                <th>Reports to  Employe</th>
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
                
                   <input type="hidden" name="id" id="subdivision_id">

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Short_Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="subDivnameShort" name="subDivnameShort" placeholder="Enter short name" value="" maxlength="50" required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2  control-label">Long_Name</label>
                        <div class="col-sm-12">
                            <input type="text" id="subDivnameLong" name="subDivnameLong"  placeholder="Enter your long name" class="form-control" required>
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Sub Division Head</label>
                        <div class="col-sm-12">
                            <!-- <input type="text" id="subDivhead" name="subDivhead"  placeholder="Enter your sub division head" class="form-control" required> -->
                        <select name="subDivhead" id="subDivhead" value="" class="form-control" required>

                                             <option value="">select your division head</option>
                                             @foreach($employeemas as $employeemas)

                                             <option value="{{$employeemas->id}}">{{$employeemas->empName}}</option>
										@endforeach
							</select>        
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8  control-label">Sub Div Reports to Div</label>
                        <div class="col-sm-12">
                            <!-- <input type="text" id="subDivreportsTodivision" name="subDivreportsTodivision"  placeholder="" class="form-control" required> -->
                            <select name="subDivreportsTodivision" id="subDivreportsTodivision" value="" class="form-control" required>

                                             <option value="">Select Division </option>
                                             @foreach($subdiv as $subdiv)

                                             <option value="{{$subdiv->id}}">{{$subdiv->divNameLong}}</option>
										@endforeach
							</select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8  control-label">Sub Div Reports to Dept</label>
                        <div class="col-sm-12">
                            <input type="text" id="subDivreportsTodepartment" name="subDivreportsTodepartment"  placeholder="" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2  col-lg-8 control-label">Sub Div Reports to service</label>
                        <div class="col-sm-12">
                            <input type="text" id="subDivreportsToservice" name="subDivreportsToservice"  placeholder="" class="form-control" required>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8  control-label">Sub Div Reports to Company</label>
                        <div class="col-sm-12">
                            <input type="text" id="subDivreportsTocompany" name="subDivreportsTocompany"  placeholder="" class="form-control" required>
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-sm-2 col-lg-8  control-label">Sub Div Reports to employee</label>
                        <div class="col-sm-12">
                            <input type="text" id="subDivreportsToEmp" name="subDivreportsToEmp"  placeholder="" class="form-control" required>
                        </div>
                    </div>

      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit"  class="btn btn-primary" id="subdivisionButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="subDivisionModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="subdivisionHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="subdivisionDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('subdivision.index') }}",
        columns: [

            {data: 'id', name:'id'},
            {data: 'subDivnameShort', name: 'subDivnameShort'},
            {data: 'subDivnameLong', name: 'subDivnameLong'},
            {data: 'empName', name: 'subDivhead'},
            {data: 'divNameLong', name: 'subDivreportsTodivision'},
            {data: 'subDivreportsTodepartment', name: 'subDivreportsTodepartment'},
            {data: 'subDivreportsToservice', name: 'subDivreportsToservice'},
            {data: 'subDivreportsTocompany', name: 'subDivreportsTocompany'},
            {data: 'subDivreportsToEmp', name: 'subDivreportsToEmp'},
            {data: 'action', name: 'action'}
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageSubDivision').click(function () {    //manange vehicle
        $('#subdivisionButton').val("create-room");       
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add Sub new Division");   // model heading
        $('#ajaxModel').modal('show');  

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var subdivision_id = $(this).data('id');
       // protected $fillable = ['id','subDivnameShort','subDivnameLong','subDivhead','subDivreportsTodivision','subDivreportsTodepartment','subDivreportsToservice','subDivreportsTocompany','subDivreportsToEmp',status'];

      $.get("{{ route('subdivision.index') }}" +'/' + subdivision_id +'/edit', function (data) {
          $('#modelHeading').html("Edit division details");
          $('#subdivisionButton').val("edit-division");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#subdivision_id').val(data.id);
          $('#subDivnameShort').val(data.subDivnameShort); //input id,database
          $('#subDivnameLong').val(data.subDivnameLong);
          $('#subDivhead').val(data.empName);
          $('#subDivreportsTodivision').val(data.divNameLong);
          $('#subDivreportsTodepartment').val(data.subDivreportsTodepartment);
          $('#subDivreportsToservice').val(data.subDivreportsToservice);
          $('#subDivreportsTocompany').val(data.subDivreportsTocompany);
          $('#subDivreportsToEmp').val(data.subDivreportsToEmp);
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#subdivisionButton').click(function (e) {  //after clicking save changes
       
        e.preventDefault();
        $(this).html('Save');

        

        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('subdivision.store') }}",    // grade-route
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
              $('#subdivisionButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteSubDivision', function () {
      var subdivision_id = $(this).data('id');
     
      $.get("{{ route('subdivision.index') }}" +'/' + subdivision_id +'/edit', function (data) {
          $('#subdivisionHeading').html("Do you want to delete the divison?");
          $('#subdivisionDeleteButton').val("edit-division");
          $('#subDivisionModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#subdivision_id').val(data.id);
          $('#subDivnameShort').val(data.subDivnameShort); //input id,database
          $('#subDivnameLong').val(data.subDivnameLong);
          $('#subDivhead').val(data.empName);
          $('#subDivreportsTodivision').val(data.divNameLong);
          $('#subDivreportsTodepartment').val(data.subDivreportsTodepartment);
          $('#subDivreportsToservice').val(data.subDivreportsToservice);
          $('#subDivreportsTocompany').val(data.subDivreportsTocompany);
          $('#subDivreportsToEmp').val(data.subDivreportsToEmp);
      })
   });
   
  // after clicking yes in delete
    $('#subdivisionDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroySubDivision') }}",
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
              $('#subdivisionDeleteButton').html('Save Changes');
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


