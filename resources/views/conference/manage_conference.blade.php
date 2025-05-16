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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
 
<div class="container">
    <a class="btn success" href="javascript:void(0)" id="manageConference">New Meeting Room&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table">
    @csrf
        <thead>
            <tr>

                <th>No</th>
                <th>Conference_Name</th>
                <th>Capacity</th>
                <th>Location</th>
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


                   <input type="hidden" name="id" id="conference_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Conferene_Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Title" value="" maxlength="50" required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Capacity</label>
                        <div class="col-sm-12">
                            <input type="number" id="capacity" name="capacity"  placeholder="Only Number Accepted" class="form-control" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label">Location</label>
                        <div class="col-sm-12">
                            <input type="text" id="location" name="location"  placeholder="Location of Meeting hall" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-12">
                            <input type="hidden" id="range_id" name="range_id" value="1"  placeholder="1,2,3 only" class="form-control" required>
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit" class="btn btn-success" id="conferenceButton" value="create">Save changes
		     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="conferenceModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="conferenceHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">       
               


                 
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                        <button type="submit" class="btn btn-outline-success" id="conferenceDeleteButton" value="create">Yes</button>
						<button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>
                     </button>
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
  
    var table = $('.data-table').DataTable({ 
        processing: true,
        serverSide: true,
        ajax: "{{ route('conference.index') }}",
        columns: [
            {data: 'id', name: 'id'},//database,input field name
            {data: 'Conference_Name', name: 'name'},
            {data: 'capacity', name: 'capacity'},
            {data: 'location', name: 'location'},
            

            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });
    $('#manageConference').click(function () {
        $('#conferenceButton').val("create-room");
        $('#conference_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Create New Meeting Room");
        $('#ajaxModel').modal('show');
    });
    $('body').on('click', '.edit', function () {
      var conference_id = $(this).data('id');
      $.get("{{ route('conference.index') }}" +'/' + conference_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Meeting Room");
          $('#conferenceButton').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#conference_id').val(data.id);
          $('#name').val(data.Conference_Name);//#input id and with data(DB field name)
          $('#capacity').val(data.capacity);
          $('#location').val(data.location);
          $('#range_id').val(data.range_id);

      })
   });
    $('#conferenceButton').click(function (e) {
        e.preventDefault();
        $(this).html('Saving...');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('conference.store') }}",
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
	      $('#conferenceButton').html('Save Changes');
	      alert("Cannot leave fields empty");

          }
      });
    });


    $('body').on('click', '.d', function () {
      var conference_id = $(this).data('id');
      $.get("{{ route('conference.index') }}" +'/' + conference_id +'/edit', function (data) {
          $('#conferenceHeading').html("Do you want to delete the conference?");
          $('#conferenceDeleteButton').val("edit-room");
          $('#conferenceModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#conference_id').val(data.id);
          $('#name').val(data.Conference_Name);//#input id and with data(DB field name)
          $('#capacity').val(data.capacity);
          $('#location').val(data.location);
          $('#range_id').val(data.range_id);
          
          

      })
   });
    $('#conferenceDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Saving...');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroy') }}",
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
       
            window.location.href = '/manage_conference';
            table.draw();
            },
          error: function (data) {
              console.log('Error:', data);
              $('#conferenceButton').html('Save Changes');
          }
      });
    });
    
</script>
