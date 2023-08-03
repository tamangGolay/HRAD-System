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
    <!-- <a class="btn success" href="javascript:void(0)" id="manageipv6">Add new ipv6&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a> -->
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>

                <th>No</th>
                <th>Ipv6 address</th>
                <th>Server Name</th>
                <th>Internal Address</th>
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

                   <input type="hidden" name="id" id="v6allocation_id">


                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">ipv6 Address</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="v6allocation" name="v6allocation" value=""  required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">server Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="serverName" name="serverName" value=""  required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">internal Address</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="internalAddress" name="internalAddress" value=""  required>
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit" class="btn btn-outline-success" id="ipv6Button" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="v6Model" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="bankHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="ipvDeleteButton" value="create">Yes</button>
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
		//"paging": true,
        ajax: "{{ route('v6allocation.index') }}",
        columns: [
            {data: 'id', name: 'id',orderable: false, searchable: true},
            {data: 'ipV6Address', name: 'ipV6Address', orderable: false, searchable: true},
            {data: 'serverName', name: 'serverName', orderable: false, searchable: true},
            {data: 'internalAddress', name: 'internalAddress', orderable: false, searchable: true},
            {data: 'action', name: 'action', orderable: true, searchable: false},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageipv6').click(function () {
        $('#ipv6Button').val("create-room");
        $('#v6allocation_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new ipv6");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.editipv6', function () {
      var v6allocation_id = $(this).data('id');
     
      $.get("{{ route('v6allocation.index') }}" +'/' + v6allocation_id +'/edit', function (data) {
          $('#modelHeading').html("Edit bank details");
          $('#ipv6Button').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#v6allocation_id').val(data.id);
          $('#v6allocation').val(data.ipV6Address); //input id,database
          $('#serverName').val(data.serverName); //input id,database
          $('#internalAddress').val(data.internalAddress);
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#ipv6Button').click(function (e) {
       
        e.preventDefault();
        $(this).html('Save');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('v6allocation.store') }}",
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
              $('#ipv6Button').html('Save Changes');
              alert(data);
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteipv6', function () {
      var v6allocation_id = $(this).data('id');
     
      $.get("{{ route('bank.index') }}" +'/' + v6allocation_id +'/edit', function (data) {
          $('#bankHeading').html("Do you want to delete the ipv6?");
          $('#ipvDeleteButton').val("edit-room");
          $('#v6Model').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#v6allocation_id').val(data.id);
          $('#v6allocation').val(data.ipV6Address); //input id,database
          $('#serverName').val(data.serverName); //input id,database
          $('#internalAddress').val(data.internalAddress);
      })
   });
   
  // after clicking yes in delete
    $('#ipvDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyipv6') }}",
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
              $('#ipvDeleteButton').html('Save Changes');
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


