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
    <div class="card-header bg-green" style="margin-bottom: 5px;">
				<div class="col text-center">
				<h5>
                <b>Committe List</b>
              </h5> </div>
	</div>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>
                <th>No</th>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>email</th>
                <th>Role</th>
                <th width="300px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="modal fade" id="adduserModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">

                   <input type="hidden" name="id" id="user_id">

                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">Employee Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="empName" name="empName" value="" readonly required>
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">Employee Id</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="emp_id" name="emp_id" value=""  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="emailId" name="emailId" value=""  required>
                        </div>
                    </div>

                    <div class="form-group row">
						<label class="col-sm-2 col-lg-8 text-md-left" for="role Type">{{ __('Role Type:') }}</label>
						<div class="col-sm-12">
						<select name="memberType" id="memberType" class="form-control" required> 
							<option value=" ">Select Member Role </option> 
							<option value="Member Secretary">Member Secretary</option>
							<option value="Member 1">Member 1</option> 
                            <option value="Member 2">Member 2</option>
                            <option value="Chairperson">Chairperson</option>
						</select> 
						</div>
					</div>
      
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit" class="btn btn-outline-success" id="addButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="userModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="jobHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">  
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="userDeleteButton" value="create">Yes</button>
						<button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>                   
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
        "searching": true,
		"ordering": false,
		//"paging": true,
        ajax: "{{ route('managecommitte.index') }}",
        columns: [
            // {data: 'id', name: 'id',orderable: false, searchable: true},
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, 
          render: function (data, type, row, meta) {
              return meta.row + 1;
             }
            },
            {data: 'empName', name: 'empName', orderable: false, searchable: true},
            {data: 'empId', name: 'empId', orderable: false, searchable: true},
            {data: 'emailId', name: 'emailId', orderable: false, searchable: true},
			{data: 'memberType', name: 'memberType', orderable: false, searchable: true},
            {data: 'action', name: 'action', orderable: true, searchable: false},
        ]
    });

    
  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var user_id = $(this).data('id');
     
      $.get("{{ route('managecommitte.index') }}" +'/' + user_id +'/edit', function (data) {
          $('#modelHeading').html("Edit user details");
          $('#addButton').val("edit-room");
          $('#adduserModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
         $('#user_id').val(data.id);
         $('#empName').val(data.user.empName);
         $('#emp_id').val(data.memberEID);
         $('#emailId').val(data.emailId);
         $('#memberType').val(data.memberType);
    
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#addButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Save');        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('managecommitte.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#adduserModel').modal('hide');
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
              $('#addButton').html('Save Changes');
              alert(data);
                
          }
      });
    });    
</script>

<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<strong></strong>';
		});

		</script>



