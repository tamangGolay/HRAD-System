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
    <a class="btn success" href="javascript:void(0)" id="manageOffice">Add Office &nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>

                <th>No</th> 
                <th style="width:20%">Office Name</th>
                <th>Office Address</th>
                <th>Office Head</th>
                <th>Report to</th>
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


                   <input type="hidden" name="id" id="office_id">
                    <div class="form-group">
                        <label for="name" class="col-lg-12 col-sm-2 control-label">Office Name</label>
                        <div class="col-lg-12 col-sm-12">
                        <select class="col-lg-12 col-sm-12 form-control" name="officeName" id="officeName" value="" required>
                                             <option value="">Select Office</option>
                                             @foreach($officen as $officen)
                                             <option value="{{$officen->id}}">{{$officen->longOfficeName}}</option>
										@endforeach
							</select>                       
                        </div>
                    </div> 
      
                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Office Address</label>
                        <div class="col-lg-12 col-sm-12">
                        <select class="col-lg-12 col-sm-12 form-control" name="officeAddress" id="officeAddress" value="" required>
                                             <option value="">Select Office Location</option>
                                             @foreach($offadd as $placemastern)
                                             <option value="{{$placemastern->placeId}}">{{$placemastern->Address}}</option>
										@endforeach
							</select>


                        </div> 
                    </div>

                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Office Head</label>
                        <div class="col-lg-12 col-sm-12">
                        <select class="col-lg-12 col-sm-12 form-control" name="officeHead" id="officeHead" value="" required>
                                             <option value="">Select Office Head</option>
                                             @foreach($offhead as $offhead)
                                             <option value="{{$offhead->empId}}">{{$offhead->empId}}</option>
										@endforeach
							</select>   
                            </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-lg-12 col-sm-2 control-label">Report to Office</label>
                        <div class="col-lg-12 col-sm-12">
                        <select class="col-lg-12 col-sm-12 form-control" name="reportToOffice" id="reportToOffice" value="" required>
                                             <option value="">Select Office</option>
                                             @foreach($reportto as $reportto)
                                             <option value="{{$reportto->id}}">{{$reportto->officeDetails}}</option>
										@endforeach
							</select>
                        
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="officeButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="officeModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="officeHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="officeDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('office.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            // {data: 'officeName', name: 'officeName'},
            {data: 'longOfficeName', name: 'A.longOfficeName', orderable: true, searchable: true},
            {data: 'Address', name: 'office_address.Address',orderable: true, searchable: true},
            {data: 'HeadOfOffice', name: 'officehead.HeadOfOffice',orderable: true, searchable: true},
            {data: 'officeDetails', name: 'officedetails.officeDetails',orderable: true, searchable: true},
            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageOffice').click(function () {
        $('#officeButton').val("create-room");
        $('#office_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new office");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var office_id = $(this).data('id');
     
      $.get("{{ route('office.index') }}" +'/' + office_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Office details");
          $('#officeButton').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#office_id').val(data.id);
          $('#officeName').val(data.officeName); //input id,database
          $('#officeAddress').val(data.officeAddress);
          $('#officeHead').val(data.officeHead);
          $('#reportToOffice').val(data.reportToOffice);
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#officeButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Saving..');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('office.store') }}",
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
            $.get('/getView?v=officemaster',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
            }); 
            // window.location.href = '/home';
        table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#officeButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });
 
  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteOffice', function () {
      var office_id = $(this).data('id');
     
      $.get("{{ route('office.index') }}" +'/' + office_id +'/edit', function (data) {
          $('#officeHeading').html("Do you want to delete office?");
          $('#officeDeleteButton').val("edit-room");
          $('#officeModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#office_id').val(data.id);
           //input id,database          
          $('#officeName').val(data.officeName); //input id,database
          $('#officeAddress').val(data.officeAddress);
          $('#officeHead').val(data.officeHead);
          $('#reportToOffice').val(data.reportToOffice);
      })
   });
   
  // after clicking yes in delete
    $('#officeDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Deleting...');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyoffice') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#officeModel').modal('hide');
              table.draw();
              window.onload = callajaxOnPageLoad(page);
        var alt = document.createElement("div");
             alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
             alt.innerHTML = "Data Updated Successfully! ";
             setTimeout(function(){
              alt.parentNode.removeChild(alt);
             },4500);
            document.body.appendChild(alt);
            $.get('/getView?v=officemaster',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
            }); 
            // window.location.href = '/home';
			table.draw();                          
          },
          error: function (data) {
              console.log('Error:', data);
              $('#officeDeleteButton').html('Save Changes');
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


