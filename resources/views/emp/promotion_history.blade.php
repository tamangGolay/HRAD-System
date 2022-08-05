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
    <a class="btn success" href="javascript:void(0)" id="manageVehicle">Add Promotion Details&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table">
    @csrf
        <thead>
            <tr>

                <th>Personal No.</th>
                <th>Promotion Date</th>
                <th>Grade From</th>
                <th>Grade To</th>
                <th>Next Due</th>
                <th>Remarks</th>  
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
                   <input type="hidden" name="id" id="vehicle_id">
                   
                   <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Employee No</label>
                        <div class="col-lg-12 col-sm-12">
                            <select class="col-lg-12 col-sm-12 form-control"  name="name" id="name" value="" required>
                                <option value="">Select PersonalNo.</option>
                                    @foreach($promotion as $promotion)
                                        <option value="{{$promotion->id}}">{{$promotion->empId}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-lg-12 col-sm-12 control-label">Promotion Date</label>
                        <div class="col-sm-12 col-lg-12 col-sm-12">
                            <input type="date" id="number" name="number"  placeholder="" class="form-control" required>
                        </div>
                    </div>           

                 
                    
                  
                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Next Due</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="date" id="next" name="next"  placeholder="" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12control-label">Remarks</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="remarks" name="remarks"  placeholder="" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="vehicleButton" value="create">Save changes
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
    <!-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>   -->
<script type="text/javascript">
  
    //Loading the contents of the Datatable from here
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('promotion.index') }}",   //**  both are database fields*/
        columns: [
            {data: 'empId', name: 'personalNo'},
            {data: 'promotionDate', name: 'promotionDate'},
            {data: 'grade', name: 'gradeFrom'},
            {data: 'grade', name: 'gradeTo'},
            {data: 'nextDue', name: 'nextDue'},
            {data: 'remarks', name: 'remarks'},
           
            

            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageVehicle').click(function () {
        $('#vehicleButton').val("create-room");
        // $('#vehicle_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new Promotion Details");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var vehicle_id = $(this).data('id');
     
      $.get("{{ route('promotion.index') }}" +'/' + vehicle_id +'/edit', function (data) {  //give route*
          $('#modelHeading').html("Edit family details");
          $('#vehicleButton').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#vehicle_id').val(data.id);
          $('#name').val(data.personalNo); //input id,database
          $('#number').val(data.promotionDate);
          $('#from').val(data.gradeFrom);
          $('#to').val(data.gradeTo);
          $('#next').val(data.nextDue);
          $('#remarks').val(data.remarks);

          
          

      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#vehicleButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Save');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('promotion.store') }}",
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
            $.get('/getView?v=promotion_history',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
            });
            // window.location.href = '/home';
        table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#vehicleButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteVehicle', function () {
      var vehicle_id = $(this).data('id');
     
      $.get("{{ route('promotion.index') }}" +'/' + vehicle_id +'/edit', function (data) {
          $('#vehicleHeading').html("Do you want to delete the Detail?");
          $('#vehicleDeleteButton').val("edit-room");
          $('#vehicleModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
           $('#vehicle_id').val(data.id);
          $('#name').val(data.personalNo); //input id,database
          $('#number').val(data.promotionDate);
          $('#from').val(data.gradeFrom);
          $('#to').val(data.gradeTo);
          $('#next').val(data.nextDue);
          $('#remarks').val(data.remarks);


     



      })
   });
   
  // after clicking yes in delete
    $('#vehicleDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroypromotionhistory') }}",
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
            $.get('/getView?v=promotion_history',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
            });
            // window.location.href = '/home';
			table.draw();                 
       
       

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#vehicleDeleteButton').html('Save Changes');
          }
      });
    });
    
    // $('body').on('click', '.deleteVehicle', function() {
	// 				if(confirm("Do you want to delete it?")) {
	// 					$.ajax({
	// 						dataType: 'json',
	// 						type: "POST",
	// 						url: "{{ route('destroyVehicle') }}",
	// 						data: {
	// 							'id': $(this).data('id'),
	// 							'_token': $('input[name=_token]').val()
	// 						},
	// 						success: function(data) {
	// 							window.onload = callajaxOnPageLoad(page);
	// 							var alt = document.createElement("div");
	// 							alt.setAttribute("style", "position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
	// 							alt.innerHTML = "Data Updated Successfully! ";
	// 							setTimeout(function() {
	// 								alt.parentNode.removeChild(alt);
	// 							}, 4500);
	// 							document.body.appendChild(alt);
	// 							window.location.href = '/manage_vehicle';
	// 							table.draw();
	// 						},
	// 						error: function(data) {
	// 							console.log('Error:', data);
	// 						}
	// 					});
	// 				}
	// 				if(false) {
	// 					window.close();
	// 				}
	// 	});
     
     
</script>

<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
		});
		</script>


