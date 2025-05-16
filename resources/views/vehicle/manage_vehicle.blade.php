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
    <a class="btn success" href="javascript:void(0)" id="manageVehicle">Add new vehicle&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table">
    @csrf
        <thead>
            <tr>
                <th>No</th>
                <th>Vehicle_Name</th>
                <th>Vehicle_no</th>
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


                   <input type="hidden" name="id" id="vehicle_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Vehicle_Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Vehicle Name (Vehicle Number)" value="" maxlength="50" required="">
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Vehicle_number</label>
                        <div class="col-sm-12">
                            <input type="text" id="number" name="number"  placeholder="Vehicle number" class="form-control">
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="vehicleButton" value="create">Save changes
		     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>  

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="vehicleModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="vehicleHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="vehicleDeleteButton" value="create">Yes</button>
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
  
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('vehicle.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'vehicle_name', name: 'name'},
            {data: 'vehicle_number', name: 'number'},
            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });
    $('#manageVehicle').click(function () {
        $('#vehicleButton').val("create-room");
        $('#vehicle_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new vehicle");
        $('#ajaxModel').modal('show');
    });
    $('body').on('click', '.edit', function () {
      var vehicle_id = $(this).data('id');
     
      $.get("{{ route('vehicle.index') }}" +'/' + vehicle_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Vehicle details");
          $('#vehicleButton').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#vehicle_id').val(data.id);
          $('#name').val(data.vehicle_name); //input id,database
          $('#number').val(data.vehicle_number);
      })
   });
    $('#vehicleButton').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('vehicle.store') }}",
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
	      $('#vehicleButton').html('Save Changes');
	      alert("Cannot leave fields empty");

          }
      });
    });

    $('body').on('click', '.deleteVehicle', function () {
      var vehicle_id = $(this).data('id');
     
      $.get("{{ route('vehicle.index') }}" +'/' + vehicle_id +'/edit', function (data) {
          $('#vehicleHeading').html("Do you want to delete the vehicle?");
          $('#vehicleDeleteButton').val("edit-room");
          $('#vehicleModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#vehicle_id').val(data.id);
          $('#name').val(data.vehicle_name); //input id,database
          $('#number').val(data.vehicle_number);
      })
   });
    $('#vehicleDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyVehicle') }}",
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
            window.location.href = '/manage_vehicle';
			table.draw();              
         },
          error: function (data) {
              console.log('Error:', data);
              $('#vehicleDeleteButton').html('Save Changes');
          }
      });
    });

     
</script>


