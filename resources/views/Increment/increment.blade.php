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
    <a class="btn success" href="javascript:void(0)" id="manageIncrement">Add new Increment Details&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>
            <th>Id</th>   
            <th>Employee Id</th>
            <th>Last Increment Date</th>
			<th>Increment Due Date</th>
			<th>Increment Cycle</th>
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
                   <input type="hidden" name="id" id="increment_id">

                   <div class="textfont form-group row"> 

                   <label for="name" class="col-md-4 control-label">Employee Number</label>
                            <!-- <input type="text" class="form-control" id="skillId" name="skillId" placeholder="Enter Skills" value="" maxlength="50" required> -->
                            <div class="col-md-6">
                            <select name="empId" id="empId" value="" class="form-control" required>

                                        <option value="">select employee number</option>

                                             @foreach($usersemp as $usersemp)

                                             <option value="{{$usersemp->empId}}">{{$usersemp->empId}}</option>
										@endforeach
							</select>
                        </div>
            	</div>

				   <div class=" textfont form-group row"> 
					<label class="col-md-4 col-form-label text-left" for="nameid">Last Increment Date:</label>
               			 <div class="col-md-6">
                  			<input type="date" name="lastIncrementDate" class="form-control" id="lastIncrementDate" placeholder="Last Increment Date" required>
               			 </div>
            	</div> 


			<div class="textfont form-group row">
				<label for="releasedate" class="col-md-4 col-form-label text-left">Increment Due Date</label>
					<div class="col-md-6">
					<input id="incrementDueDate" type="date" class="form-control" name="incrementDueDate" placeholder="Increment Due Date"  required>
					</div>
			</div>
						
			<div class="textfont form-group row">
				<label for="amount" class="col-md-4 col-form-label text-left">Increment Cycle</label>
					<div class="col-md-6">
						<input id="incrementCycle" type="text" class="form-control" name="incrementCycle" required>
						
					</div>
			    </div>			

						<div class="textfont form-group row">
							<label for="reason" class="col-md-4 col-form-label text-left"> Modification Reason</label>
							<div class="col-md-6">
								
									<input id="modificationReason" type="text" class="form-control" name="modificationReason" required>
									
							</div>
						</div>

      
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="incrementButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="incrementModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="incrementHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="incrementDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('incrementall.index') }}",
        columns: [
            {data: 'id', name:'id'},
            {data: 'empId', name:'empId'},
            {data: 'lastIncrementDate', name: 'lastIncrementDate'},
			{data: 'incrementDueDate', name: 'incrementDueDate'},
			{data: 'incrementCycle', name: 'incrementCycle'},
			// {data: 'modificationReason', name: 'modificationReason'},
		  {data: 'action', name: 'action'}
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageIncrement').click(function () {    //manange vehicle
        $('#incrementButton').val("create-room");
        $('#increment_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new Increment Details");   // model heading
        $('#ajaxModel').modal('show');  

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.editIncrement', function () {
      var increment_id = $(this).data('id');
     
      $.get("{{ route('incrementall.index') }}" +'/' + increment_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Increment details");
          $('#incrementButton').val("edit-increment");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#increment_id').val(data.id);
          $('#empId').val(data.empId);
          $('#lastIncrementDate').val(data.lastIncrementDate); //input id,database
		  $('#incrementDueDate').val(data.incrementDueDate);
		  $('#incrementCycle').val(data.incrementCycle);
		  $('#modificationReason').val(data.modificationReason);
      })
   });


//   After clicking save changes in Add and Edit it will trigger here

    $('#incrementButton').click(function (e) {  //after clicking save changes
       
        e.preventDefault();
        $(this).html('Saving...');

        

        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('incrementall.store') }}",    
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
        
        
            // window.location.href = '/home';
            $.get('/getView?v=incrementall',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
            }); 

        table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#incrementButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });


  //  After clicking delete it will trigger here

//     $('body').on('click', '.deleteIncrement', function () {
//       var increment_id = $(this).data('id');
     
//       $.get("{{ route('incrementall.index') }}" +'/' + increment_id +'/edit', function (data) {
//           $('#incrementHeading').html("Do you want to delete Increment details?");
//           $('#incrementDeleteButton').val("edit-increment");
//           $('#incrementModel').modal('show');
//           $('meta[name="csrf-token"]').attr('content'),
//           $('#increment_id').val(data.id);
//           $('#empId').val(data.empId);
//           $('#lastIncrementDate').val(data.lastIncrementDate); //input id,database
// 		  $('#incrementDueDate').val(data.incrementDueDate);
// 		  $('#incrementCycle').val(data.incrementCycle);
// 		  $('#modificationReason').val(data.modificationReason);
          
//       })
//    });
   
//   // after clicking yes in delete
//     $('#incrementDeleteButton').click(function (e) {
//         e.preventDefault();
//         $(this).html('Deleting...');
    
//         $.ajax({
//           data: $('#Form').serialize(),
//           url: "{{ route('destroyIncrement') }}",
//           type: "POST",
//           dataType: 'json',
//           success: function (data) {
     
//               $('#Form').trigger("reset");
//               $('#incrementModel').modal('hide');
//               table.draw();
//               window.onload = callajaxOnPageLoad(page);
//         var alt = document.createElement("div");
//              alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
//              alt.innerHTML = "Data Updated Successfully! ";
//              setTimeout(function(){
//               alt.parentNode.removeChild(alt);
//              },4500);
//             document.body.appendChild(alt);
//             //  window.location.href = '/home';

//              $.get('/getView?v=incrementall',function(data){
//             $('#contentpage').empty();                          
//             $('#contentpage').append(data.html);
//             });
       

// 			table.draw();                 
    
//           },
//           error: function (data) {
//               console.log('Error:', data);
//               $('#incrementDeleteButton').html('Save Changes');
//           }
//       });
//     });
    
    
</script>

<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
		});
		</script>


