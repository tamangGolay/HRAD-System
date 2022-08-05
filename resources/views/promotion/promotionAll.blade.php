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
    <a class="btn success" href="javascript:void(0)" id="managePromotionAll">Add New &nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>
				<th>No</th>
                <th width="30">Employee Id</th> 
                <th width="30">Grade</th>
                <th width="30">Grade Ceiling</th>
                <th width="30">Years To Promote</th>
                <th width="30">Joining Date</th>
				<th width="30">Last Promotion Date</th>
				<th width="30">Promotion Due Date</th>
                <th >Action</th>
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
				<input type="hidden" name="id" id="promo_id">
				  
					<div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Employee Id</label>
                        <div class="col-lg-12 col-sm-12">						
						<select class="col-lg-12 col-sm-12 form-control" name="empId" id="empId" value="" required>
                                             <option value="">Select Office</option>
                                             @foreach($promo as $promo)
                                             <option value="{{$promo->empId}}">{{$promo->empId}}</option>
										@endforeach
						</select>
						<!-- <input type="number" id="empId" name="empId"  placeholder="eg: 300030302" class="form-control" required> -->
                        </div>
                    </div>

					<div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Grade</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="grade" name="grade"  placeholder="eg: A2" class="form-control" required>
                        </div>
                    </div>

					<div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Grade Ceiling</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="gradeCeiling" name="gradeCeiling"  placeholder="eg: A1" class="form-control" required>
                        </div>
                    </div>

					<div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Years To Promote</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="number" id="yearsToPromote" name="yearsToPromote"  placeholder="eg: 5" class="form-control" required>
                        </div>
                    </div>

					<div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Do Joining</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="date" id="doJoining" name="doJoining"  placeholder="eg: 2021-01-20" class="form-control" required>
                        </div>
                    </div>

					<div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Last Promotion</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="date" id="doLastPromotion" name="doLastPromotion"  placeholder="eg: 2021-01-20" class="form-control" required>
                        </div>
                    </div>

					<div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Promotion Due</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="date" id="promotionDueDate" name="promotionDueDate"  placeholder="eg: 2050-01-20" class="form-control" required>
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="promotionAllButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="promotionAllModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="promotionAllHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">
        
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="promotionAllDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('promotionAll.index') }}",
        columns: [
			{data: 'id', name: 'id'},
			{data: 'empId', name: 'empId'},
            {data: 'grade', name: 'grade'},
            {data: 'gradeCeiling', name: 'gradeCeiling'},
            {data: 'yearsToPromote', name: 'yearsToPromote'},
            {data: 'doJoining', name: 'doJoining'},
            {data: 'doLastPromotion', name: 'doLastPromotion'},
			{data: 'promotionDueDate', name: 'promotionDueDate'},
            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#managePromotionAll').click(function () {
        $('#promotionAllButton').val("create-room");
        $('#promo_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new ");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var promo_id = $(this).data('id');
     
      $.get("{{ route('promotionAll.index') }}" +'/' + promo_id +'/edit', function (data) {
          $('#modelHeading').html("Edit promotion details");
          $('#promotionAllButton').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#promo_id').val(data.id);
		  $('#empId').val(data.empId);
          $('#grade').val(data.grade); //input id,database
          $('#gradeCeiling').val(data.gradeCeiling);
          $('#yearsToPromote').val(data.yearsToPromote);
          $('#doJoining').val(data.doJoining);
		  $('#doLastPromotion').val(data.doLastPromotion);
		  $('#promotionDueDate').val(data.promotionDueDate);
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#promotionAllButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Save');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('promotionAll.store') }}",
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
              $('#promotionAllButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });
 
  //  After clicking delete it will trigger here

    $('body').on('click', '.deletePromotionAll', function () {
      var promo_id = $(this).data('id');
     
      $.get("{{ route('promotionAll.index') }}" +'/' + promo_id +'/edit', function (data) {
          $('#promotionAllHeading').html("Do you want to delete?");
          $('#promotionAllDeleteButton').val("edit-room");
          $('#promotionAllModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#promo_id').val(data.id);
		  $('#empId').val(data.empId);
          $('#grade').val(data.grade); //input id,database
          $('#gradeCeiling').val(data.gradeCeiling);
          $('#yearsToPromote').val(data.yearsToPromote);
          $('#doJoining').val(data.doJoining);
		  $('#doLastPromotion').val(data.doLastPromotion);
		  $('#promotionDueDate').val(data.promotionDueDate);
      })
   });
   
  // after clicking yes in delete
    $('#promotionAllDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyPromotionAll') }}",
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
              $('#promotionAllDeleteButton').html('Save Changes');
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


