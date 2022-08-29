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
<div class=" card-header bg-green text-center mb-3">
              <h3>Place Master</h3>
	</div>
    <a class="btn success" href="javascript:void(0)" id="manageplace">Add new place&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>
                <th>No</th>
                <th>Village</th>
                <th>Town</th>
                <th>Gewog</th>
                <th>Drungkhag</th>
                <th>Dzongkhag</th>
                <th>Place Category</th>


                <th width=150px">Action</th>
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


                   <input type="hidden" name="id" id="place_id">

                   <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Town</label>
                        <div class="col-sm-12">
                            <!-- <input type="text" id="dzongkhagId" name="dzongkhagId"   class="form-control" required> -->

                            <select name="townName" id="townId" value="" class="form-control" required>
                                             <option value="">Select Town</option>
                                             @foreach($town as $town)

                                             <option value="{{$town->id}}">{{$town->townName}}</option>
										@endforeach
							</select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Village</label>
                        <div class="col-sm-12">
                            <!-- <input type="text" id="dzongkhagId" name="dzongkhagId"   class="form-control" required> -->

                            <select name="villageName" id="villageId" value="" class="form-control"  required>
                                             <option value="">Select Village</option>
                                             @foreach($village as $village)

                                             <option value="{{$village->id}}">{{$village->villageName}}</option>
										@endforeach
							</select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Drungkhag</label>
                        <div class="col-sm-12">
                            <!-- <input type="text" id="dzongkhagId" name="dzongkhagId"   class="form-control" required> -->

                            <select name="drungkhagName" id="drungkhagId" value="" class="form-control" required>
                                             <option value="">Select Drungkhag</option>
                                             @foreach($drungkhag as $drungkhag)

                                             <option value="{{$drungkhag->id}}">{{$drungkhag->drungkhagName}}</option>
										@endforeach
							</select>
                        </div>
                    </div>

                  
                   
                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">Gewog</label>
                        <div class="col-sm-12">
                            <!-- <input type="text" class="form-control" id="gewogName" name="gewogName" value=""  required> -->
                            <select name="gewogName" id="gewogId" value="" class="form-control" required>
                                             <option value="">Select Gewog</option>
                                             @foreach($gewog as $gewog)

                                             <option value="{{$gewog->id}}">{{$gewog->gewogName}}</option>
										@endforeach
							</select>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 col-lg-8 control-label">Dzongkhag</label>
                        <div class="col-sm-12">
                            <!-- <input type="text" id="dzongkhagId" name="dzongkhagId"   class="form-control" required> -->

                            <select name="Dzongkhag_Name" id="dzongkhagId" value="" class="form-control" required>
                                             <option value="">Select Dzongkhag</option>
                                             @foreach($dzongkhag as $dzongkhag)

                                             <option value="{{$dzongkhag->id}}">{{$dzongkhag->Dzongkhag_Name}}</option>
										@endforeach
							</select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">Place Category</label>
                        <div class="col-sm-12">
                         <select class="form-control" id="placeCategory" name="placeCategory">
                                  <option>Village</option>
                                  <option>Town</option>
                                  <option>Gewog</option>
                                  <option>Drungkhag</option>
                                  <option>Dzongkhag</option>
                                </select>   
                        
                        <!-- <input type="text" class="form-control" id="placeCategory" name="placeCategory" value=""  required> -->
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10text-center">
                     <button type="submit"  class="btn btn-outline-success" id="placeButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="placeModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="placeHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="placeDeleteButton" value="create">Yes</button>
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
        // "searching": true,
		"ordering": true,
		"paging": true,
        ajax: "{{ route('place.index') }}",
        columns: [
            {data: 'id', name: 'id',orderable: true, searchable: true},
            {data: 'villageName', name: 'villagemaster.villageName', orderable: false, searchable: true},
            {data: 'townName', name: 'townmaster.townName', orderable: false, searchable: true},
             {data: 'gewogName', name: 'gewogmaster.gewogName', orderable: false, searchable: true},
             {data: 'drungkhagName', name: 'drungkhagmaster.drungkhagName', orderable: false, searchable: true},
            {data: 'Dzongkhag_Name', name: '.dzongkhags.Dzongkhag_Name', orderable: false, searchable: false},
            {data: 'placeCategory', name: 'placeCategory', orderable: false, searchable: true},

            {data: 'action', name: 'action', orderable: true, searchable: false},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageplace').click(function () {
        $('#placeButton').val("create-room");
        $('#place_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new place");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.editplace', function () {
      var place_id = $(this).data('id');
     
      $.get("{{ route('place.index') }}" +'/' + place_id +'/edit', function (data) {
          $('#modelHeading').html("Edit place details");
          $('#placeButton').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#place_id').val(data.id);
          $('#placeCategory').val(data.placeCategory); //input id,database
          $('#townId').val(data.townId);//keeping input name and dB field name same so that the search will not give error
          $('#villageId').val(data.villageId);//keeping input name and dB field name same so that the search will not give error
          $('#gewogId').val(data.gewogId);//keeping input name and dB field name same so that the search will not give error
          $('#dzongkhagId').val(data.dzongkhagId);//keeping input name and dB field name same so that the search will not give error
          $('#drungkhagId').val(data.drungkhagId);//keeping input name and dB field name same so that the search will not give error

         
          
     
     
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#placeButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Saving..');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('place.store') }}",
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
            $.get('/getView?v=placemaster',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
            });
        
            // window.location.href = '/home';
        table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#placeButton').html('Save Changes');
              alert(data);
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteplace', function () {
      var place_id = $(this).data('id');
     
      $.get("{{ route('place.index') }}" +'/' + place_id +'/edit', function (data) {
          $('#placeHeading').html("Do you want to delete the place?");
          $('#placeDeleteButton').val("edit-room");
          $('#placeModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#place_id').val(data.id);
          $('#placeCategory').val(data.placeCategory); //input id,database
          $('#townId').val(data.townId);//keeping input name and dB field name same so that the search will not give error
          $('#villageId').val(data.villageId);//keeping input name and dB field name same so that the search will not give error
          $('#gewogId').val(data.gewogId);//keeping input name and dB field name same so that the search will not give error
          $('#dzongkhagId').val(data.dzongkhagId);//keeping input name and dB field name same so that the search will not give error
          $('#drungkhagId').val(data.drungkhagId);//keeping input name and dB field name same so that the search will not give error

      })
   });
   
  // after clicking yes in delete
    $('#placeDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Deleting...');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyplace') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#placeModel').modal('hide');
              table.draw();
              window.onload = callajaxOnPageLoad(page);
        var alt = document.createElement("div");
             alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
             alt.innerHTML = "Data Updated Successfully! ";
             setTimeout(function(){
              alt.parentNode.removeChild(alt);
             },4500);
            document.body.appendChild(alt);
            $.get('/getView?v=placemaster',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
            });
            // window.location.href = '/home';
			table.draw();                 
       
       

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#placeDeleteButton').html('Save Changes');
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


