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
    <a class="btn success" href="javascript:void(0)" id="managegewog">Add new gewog&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>

                <th>No</th>
                <th>Gewog</th>
                <th>Drungkhag</th>
                 <th>Dzongkhag</th>
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


                   <input type="hidden" name="id" id="gewog_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">Gewog</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="gewogName" name="gewogName" placeholder="Enter new gewog name"value=""  required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">Drungkhag</label>
                        <div class="col-sm-12">
                            <!-- <input type="text" class="form-control" id="gewogName" name="gewogName" value=""  required> -->
                            <select name="drungkhagId" id="drungkhagId" value="" class="form-control" required>
                                             <option value="">Select Drungkhag</option>
                                             @foreach($drungkhag as $drungkhag)

                                             <option value="{{$drungkhag->id}}">{{$drungkhag->drungkhagName}}</option>
										@endforeach
							</select>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2  col-lg-8 control-label">Dzongkhag</label>
                        <div class="col-sm-12">
                            <!-- <input type="text" id="dzongkhagId" name="dzongkhagId"   class="form-control" required> -->

                            <select name="dzongkhagId" id="dzongkhagId" value="" class="form-control" required>
                                             <option value="">Select Dzongkhag</option>
                                             @foreach($dzongkhag as $dzongkhag)

                                             <option value="{{$dzongkhag->id}}">{{$dzongkhag->Dzongkhag_Name}}</option>
										@endforeach
							</select>
                        </div>
                    </div>
								
      
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="gewogButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="gewogModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="gewogHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="gewogDeleteButton" value="create">Yes</button>
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
		"ordering": true,
		"paging": true,
        ajax: "{{ route('gewog.index') }}",
        columns: [
            {data: 'id', name: 'id',orderable: true, searchable: true},
            {data: 'gewogName', name: 'gewogName', orderable: false, searchable: true},
            {data: 'drungkhagName', name: 'drungkhagmaster.drungkhagName', orderable: false, searchable: true},

            {data: 'Dzongkhag_Name', name: 'dzongkhags.Dzongkhag_Name', orderable: false, searchable: true},

            {data: 'action', name: 'action', orderable: true, searchable: false},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#managegewog').click(function () {
        $('#gewogButton').val("create-room");
        $('#gewog_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new gewog");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.editgewog', function () {
      var gewog_id = $(this).data('id');
     
      $.get("{{ route('gewog.index') }}" +'/' + gewog_id +'/edit', function (data) {
          $('#modelHeading').html("Edit gewog details");
          $('#gewogButton').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#gewog_id').val(data.id);
          $('#gewogName').val(data.gewogName); //input id,database
          $('#drungkhagId').val(data.drungkhagId);//keeping input name and dB field name same so that the search will not give error
          $('#dzongkhagId').val(data.dzongkhagId);//keeping input name and dB field name same so that the search will not give error
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#gewogButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Saving...');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('gewog.store') }}",
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
       
        
            $.get('/getView?v=gewogmaster',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
             });         
             table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#gewogButton').html('Save Changes');
              alert(data);
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deletegewog', function () {
      var gewog_id = $(this).data('id');
     
      $.get("{{ route('gewog.index') }}" +'/' + gewog_id +'/edit', function (data) {
          $('#gewogHeading').html("Do you want to delete the gewog?");
          $('#gewogDeleteButton').val("edit-room");
          $('#gewogModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#gewog_id').val(data.id);
          $('#drungkhagId').val(data.drungkhagId); //input id,database
          $('#dzongkhagId').val(data.dzongkhagId);
      })
   });
   
  // after clicking yes in delete
    $('#gewogDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Deleting...');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroygewog') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#gewogModel').modal('hide');
              table.draw();
              window.onload = callajaxOnPageLoad(page);
        var alt = document.createElement("div");
             alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
             alt.innerHTML = "Data Updated Successfully! ";
             setTimeout(function(){
              alt.parentNode.removeChild(alt);
             },4500);
            document.body.appendChild(alt);
            
            $.get('/getView?v=gewogmaster',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
             });   
            // window.location.href = '/home';
			table.draw();                 
       
       

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#gewogDeleteButton').html('Save Changes');
          }
      });
    });
    
    // $('body').on('click', '.deletegewog', function() {
	// 				if(confirm("Do you want to delete it?")) {
	// 					$.ajax({
	// 						dataType: 'json',
	// 						type: "POST",
	// 						url: "{{ route('destroygewog') }}",
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
	// 							window.location.href = '/manage_gewog';
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


