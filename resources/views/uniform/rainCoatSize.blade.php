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
    <a class="btn success" href="javascript:void(0)" id="manageraincoat">Add New Rain Coat Size&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>

                <th>No</th>
                <th>Rain Coat Size</th>
                <th>Shoulder Cm</th>
                <th>Chest Cm</th>
                <th>Waist Cm</th>
                <th>Bottom Cm</th>
                <th>Length Cm</th>
                <th>Sleeve Cm</th>
                <th width="200px">Action</th>
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


                   <input type="hidden" name="id" id="raincoat_id">

                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">Rain Coat Size</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="sizeName" name="sizeName" value="" placeholder="XXS" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-8 col-sm-12 control-label">Shoulder Cm</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="shouldersCm" name="shouldersCm"  placeholder="32.00" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-8 col-sm-12 control-label">Chest Cm</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="chestCm" name="chestCm"  placeholder="30.00" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-8 col-sm-12 control-label">Waist Cm</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="waistCm" name="waistCm"  placeholder="37.00" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-8 col-sm-12 control-label">Bottom Cm</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="bottomCm" name="bottomCm"  placeholder="40.00" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-8 col-sm-12 control-label">Length Cm</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="lengthCm" name="lengthCm"  placeholder="50.00" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-8 col-sm-12 control-label">Sleeve Cm</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="sleeveCm" name="sleeveCm"  placeholder="45.00" class="form-control" required>
                        </div>
                     </div>

                    

                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="rainCoatButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="jacketModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="raincoatHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="rainCoatDeleteButton" value="create">Yes</button>
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
		"paging": true,
        ajax: "{{ route('raincoat.index') }}",
        columns: [
            {data: 'id', name: 'id',orderable: false, searchable: true},
            {data: 'sizeName', name: 'sizeName', orderable: false, searchable: true},
            {data: 'shouldersCm', name: 'shouldersCm', orderable: false, searchable: true},
            {data: 'chestCm', name: 'chestCm', orderable: false, searchable: true},
            {data: 'waistCm', name: 'waistCm', orderable: true, searchable: true},
            {data: 'bottomCm', name: 'bottomCm', orderable: true, searchable: true},
            {data: 'lengthCm', name: 'lengthCm', orderable: true, searchable: true},
            {data: 'sleeveCm', name: 'sleeveCm', orderable: true, searchable: true},
            {data: 'action', name: 'action', orderable: true, searchable: true},


        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageraincoat').click(function () {
        $('#rainCoatButton').val("create-room");
        $('#raincoat_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new Rain Coat Size");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.editraincoat', function () {
      var raincoat_id = $(this).data('id');
     
      $.get("{{ route('raincoat.index') }}" +'/' + raincoat_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Rain Coat details");
          $('#rainCoatButton').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#raincoat_id').val(data.id);
          $('#sizeName').val(data.sizeName); //input id,database
          $('#shouldersCm').val(data.shouldersCm);
          $('#chestCm').val(data.chestCm);
          $('#waistCm').val(data.waistCm);
          $('#bottomCm').val(data.bottomCm);
          $('#lengthCm').val(data.lengthCm);
          $('#sleeveCm').val(data.sleeveCm);
         
         
        

      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#rainCoatButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Saving...');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('raincoat.store') }}",
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
        //to redirect page to same page 

        $.get('/getView?v=raincoatsize',function(data){        
           $('#contentpage').empty();                          
           $('#contentpage').append(data.html);
            });
        
            // window.location.href = '/home';
        table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#rainCoatButton').html('Save Changes');
              alert(data);
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteraincoat', function () {
      var raincoat_id = $(this).data('id');
     
      $.get("{{ route('raincoat.index') }}" +'/' + raincoat_id +'/edit', function (data) {
          $('#raincoatHeading').html("Do you want to delete the Rain Coat size name?");
          $('#rainCoatDeleteButton').val("edit-room");
          $('#jacketModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#raincoat_id').val(data.id);
          $('#sizeName').val(data.sizeName); //input id,database
          $('#shouldersCm').val(data.shouldersCm);
          $('#chestCm').val(data.chestCm);
          $('#waistCm').val(data.waistCm);
          $('#bottomCm').val(data.bottomCm);
          $('#lengthCm').val(data.lengthCm);
          $('#sleeveCm').val(data.sleeveCm);
          
          
      })
   });
   
  // after clicking yes in delete
    $('#rainCoatDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Deleting...');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyRainCoat') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#jacketModel').modal('hide');
              table.draw();
              window.onload = callajaxOnPageLoad(page);
        var alt = document.createElement("div");
             alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
             alt.innerHTML = "Data Updated Successfully! ";
             setTimeout(function(){
              alt.parentNode.removeChild(alt);
             },4500);
            document.body.appendChild(alt);

            //to redirect page to same page 

        $.get('/getView?v=raincoatsize',function(data){        
           $('#contentpage').empty();                          
           $('#contentpage').append(data.html);
            });
            
            // window.location.href = '/home';
			table.draw();                 
       
       

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#rainCoatDeleteButton').html('Save Changes');
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


