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
    <a class="btn success" href="javascript:void(0)" id="manageCompany">Add Company Name&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table">
    @csrf
        <thead>
            <tr>

                <th>No</th>
                <th>Company Short Name</th>
                <th>COmpany Long Name</th>
                <th>to Long Name</th>
                <th width="300px">Action</th>
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


                   <input type="hidden" name="id" id="companyId">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Company short Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="comNameShort" name="comNameShort" placeholder="eg: CEO" value="" maxlength="50" required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Company Long name</label>
                        <div class="col-sm-12">
                            <input type="text" id="comNameLong" name="comNameLong"  placeholder="eg: Chief Executive officer" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">To Long name</label>
                        <div class="col-sm-12">
                            <input type="text" id="comReportsTo" name="comReportsTo"  placeholder="eg: Chief Executive officer" class="form-control" required>
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit"  class="btn btn-primary" id="companyButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="companyModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="companyHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="companyDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('company.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'comNameShort', name: 'comNameShort'},
            {data: 'comNameLong', name: 'comNameLong'},
            {data: 'comReportsTo', name: 'comReportsTo'},
            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageCompany').click(function () {
        $('#companyButton').val("create-room");
        $('#companyId').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new Company");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var companyId = $(this).data('id');
     
      $.get("{{ route('company.index') }}" +'/' + companyId +'/edit', function (data) {
          $('#modelHeading').html("Edit Company details");
          $('#companyButton').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#companyId').val(data.id);
          $('#comNameShort').val(data.comNameShort); //input id,database
          $('#comNameLong').val(data.comNameLong);
          $('#comReportsTo').val(data.comReportsTo);
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#companyButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Save');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('company.store') }}",
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
              $('#companyButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteCompany', function () {
      var companyId = $(this).data('id');
     
      $.get("{{ route('company.index') }}" +'/' + companyId +'/edit', function (data) {
          $('#companyHeading').html("Do you want to delete company name?");
          $('#companyDeleteButton').val("edit-room");
          $('#companyModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#companyId').val(data.id);
          $('#comNameShort').val(data.comNameShort); //input id,database
          $('#comNameLong').val(data.comNameLong);
          $('#comReportsTo').val(data.comReportsTo);
      })
   });
   
  // after clicking yes in delete
    $('#companyDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroycompany') }}",
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
              $('#companyDeleteButton').html('Save Changes');
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


