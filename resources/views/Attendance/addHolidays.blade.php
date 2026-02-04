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

 
<div class="container">
    <a class="btn success" href="javascript:void(0)" id="manageHoliday">Add Holiday&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>

                <th>No</th>
                <th>Holiday Date</th>
                <th>Holiday Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="modal fade" id="holidayModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   <input type="hidden" name="id" id="holiday_id">

                    <div class="form-group">
                        <label for="name" class="col-lg-12 col-sm-12 control-label">Holiday Date</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="date" class="form-control" id="holidayDate" name="holidayDate" placeholder="eg: CEO" value="" maxlength="50" required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Holiday Name</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="holidayName" name="holidayName"  placeholder="eg: Blessed rainy Day" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                     <label class="col-lg-12 col-sm-12 control-label">Status</label>
                     <div class="col-lg-12 col-sm-12">
                        <select id="status" name="status" class="form-control" required>
                            <option value="active">Active</option>
                             <option value="inactive">Inactive</option>
                         </select>
                     </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="holidayButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="designationmodal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="designationHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="designationDeleteButton" value="create">Yes</button>
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
    <script type="text/javascript">
  
    //Loading the contents of the Datatable from here
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('addholidays.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'holiday_date', name: 'holiday_date'},
            {data: 'holiday_name', name: 'holiday_name'},
            // {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageHoliday').click(function () {
        $('#holidayButton').val("create-room");
        $('#holiday_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new Holiday");
        $('#holidayModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var holiday_id = $(this).data('id');
     
      $.get("{{ route('addholidays.index') }}" +'/' + holiday_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Holiday details");
          $('#holidayButton').val("edit-room");
          $('#holidayModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#holiday_id').val(data.id);
          $('#holidayDate').val(data.holiday_date); //input id,database
          $('#holidayName').val(data.holiday_name);
         $('#status').val(data.status);
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#holidayButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Saving...');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('addholidays.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#holidayModel').modal('hide');
              table.draw();
              window.onload = callajaxOnPageLoad(page);
             var alt = document.createElement("div");
             alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
             alt.innerHTML = "Data Updated Successfully! ";
             setTimeout(function(){
              alt.parentNode.removeChild(alt);
             },4500);
            document.body.appendChild(alt);                 
       
            $.get('/getView?v=designationmaster',function(data){
        
        $('#contentpage').empty();                          
        $('#contentpage').append(data.html);
        }); 
            // window.location.href = '/home';
        table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#holidayButton').html('Save Changes');
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


