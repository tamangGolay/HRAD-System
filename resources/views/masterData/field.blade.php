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
    <a class="btn success" href="javascript:void(0)" id="managefield">Add new Field&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table">
    @csrf
        <thead>
            <tr>

                <th>No</th>
                <th>Field</th>
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


                   <input type="text" name="id" id="field_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-g-8 control-label">Field Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="fieldName" name="fieldName" value=""  required>
                        </div>
                    </div>
     
                   	
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit"  class="btn btn-primary" id="fieldButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="fieldModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="fieldHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="fieldDeleteButton" value="create">Yes</button>
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
        "searching": true,
		"ordering": false,
		"paging": false,
        ajax: "{{ route('field.index') }}",
        columns: [
            {data: 'id', name: 'id',orderable: false, searchable: true},
            {data: 'fieldName', name: 'fieldName', orderable: false, searchable: true},
            {data: 'action', name: 'action', orderable: true, searchable: false},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#managefield').click(function () {
        $('#fieldButton').val("create-room");
        $('#field_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new Field");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.editfield', function () {
      var field_id = $(this).data('id');
     
      $.get("{{ route('field.index') }}" +'/' + field_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Field details");
          $('#fieldButton').val("edit-field");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#field_id').val(data.id);
          $('#fieldName').val(data.fieldName); //input id,database
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#fieldButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Save');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('field.store') }}",
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
              $('#fieldButton').html('Save Changes');
              alert(data);
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteField', function () {
      var field_id = $(this).data('id');
     
      $.get("{{ route('field.index') }}" +'/' + field_id +'/edit', function (data) {
          $('#fieldHeading').html("Do you want to delete this Field?");
          $('#fieldDeleteButton').val("edit-field");
          $('#fieldModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#field_id').val(data.id);
          $('#fieldName').val(data.fieldName); //input id,database
      })
   });
   
  // after clicking yes in delete
    $('#fieldDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyField') }}",
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
              $('#fieldDeleteButton').html('Save Changes');
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


