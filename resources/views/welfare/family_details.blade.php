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
    <a class="btn success" href="javascript:void(0)" id="manageFamily">Add Relatives Details&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table">
    @csrf
        <thead>
            <tr>
                 <th>Id</th>
                <th>Personal Number</th>
                <th>Cid</th>
                <th>Cid (Other)</th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Relation</th>
                <th width="13%">Action</th> 
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


                      <input type="hidden" name="id" id="family_id">

                              <div class="form-group">
                              <label class="col-lg-12 col-sm-12 control-label">Personal No</label>
                              <div class="col-lg-12 col-sm-12">    
                             <select class=form-control name="empId" id="empId" value="" required>
                                             <option value="">Select Personal No.</option>
                                             @foreach($pno as $pno)
                                             <option value="{{$pno->empId}}">{{$pno->empId}}</option>
										@endforeach
							</select>

                        </div>
                     </div>

                       
                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Relative's Name</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="name" name="name"  placeholder="relativename" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                    
                        <label class="col-lg-12 col-sm-12 control-label">Relative's CID</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="cIdNo" name="cIdNo" onKeyPress="if(this.value.length==11) return false;" placeholder="Only if relative have CID" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Relative's other CID (<span style="color:red"><i>required only if your relative dont have CID</i></span>)</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="cIDOther" name="cIDOther"  placeholder="Only if relative dont have CID" class="form-control" required>
                        </div>
                    </div>

                   
                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Relative's DoB</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="date" id="doB" name="doB"  placeholder="dob" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Relation</label>
                        <div class="col-lg-12 col-sm-12">
                            <!-- <input type="text" id="relation" name="relation"  placeholder="relation" class="form-control" required> -->
                            <select class=form-control name="relation" id="relation" value="" required>
                                             <option value="">Select Relation</option>
                                             @foreach($relation as $relation)
                                             <option value="{{$relation->id}}">{{$relation->relationshipName}}</option>
										@endforeach
							</select>
                        </div>
                    </div>
                                

                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="familyButton" value="create">Save changes</button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="familyModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="familyHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="familyDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('wfrelatives.index') }}",   //** */
        columns: [
            {data: 'id', name: 'id'},
            {data: 'empId', name: 'users.empId'},
            {data: 'cIdNo', name: 'cIdNo'},
            {data: 'cIDOther', name: 'cIDOther'},
            {data: 'name', name: 'name'},
            {data: 'doB', name: 'doB'},
            {data: 'relationshipName', name: 'relationmaster.relationshipName'},
            {data: 'action', name: 'action'}
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageFamily').click(function () {
        $('#familyButton').val("create-room"); 
         $('#family_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add Family Details");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var family_id = $(this).data('id');
     
      $.get("{{ route('wfrelatives.index') }}" +'/' + family_id +'/edit', function (data) {  //give route*
          $('#modelHeading').html("Edit relatives details");
          $('#familyButton').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#family_id').val(data.id);
          $('#empId').val(data.empId); //input id,database
          $('#name').val(data.name);
          $('#cIdNo').val(data.cIdNo);
          $('#cIDOther').val(data.cIDOther);
          $('#doB').val(data.doB);
          $('#relation').val(data.relation);

      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#familyButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Saving...');

        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('wfrelatives.store') }}",
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
       
            $.get('/getView?v=wfRelatives',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
             }); 
            // window.location.href = '/home';
        table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#familyButton').html('Save Changes');
              alert("Cannot leave fields empty/cannot fill both cid/cid other");
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteFamily', function () {
      var family_id = $(this).data('id');
     
      $.get("{{ route('wfrelatives.index') }}" +'/' + family_id +'/edit', function (data) {
          $('#familyHeading').html("Do you want to delete the Detail?");
          $('#familyDeleteButton').val("edit-room");
          $('#familyModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
           $('#family_id').val(data.id);
          $('#empId').val(data.empId); //input id,database
          $('#name').val(data.name);
          $('#cIdNo').val(data.cIdNo);
          $('#cIDOther').val(data.cIDOther);
          $('#doB').val(data.doB);
          $('#relation').val(data.relation);


      })
   });
   
  // after clicking yes in delete
    $('#familyDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Deleting...');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyrelativesdetails') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#familyModel').modal('hide');
              table.draw();
              window.onload = callajaxOnPageLoad(page);
            var alt = document.createElement("div");
             alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
             alt.innerHTML = "Data Updated Successfully! ";
             setTimeout(function(){
              alt.parentNode.removeChild(alt);
             },4500);
            document.body.appendChild(alt);
            $.get('/getView?v=wfRelatives',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
             }); 
            // window.location.href = '/home';
			table.draw();                 
       
       

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#familyDeleteButton').html('Save Changes');
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


