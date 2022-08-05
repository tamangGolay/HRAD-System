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
    <a class="btn success" href="javascript:void(0)" id="managegumboot">Add new Gumboot Size&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>

                <th>No</th>
                <th>EU Size</th>
                <th>US Size</th>
                <th>UK Size</th>
                <th>Inner S Length</th>
                <th>Boot Length(Cm)</th>
                <th>Inner S Width(Cm)</th>
                <th>Boot Width(Cm)</th>
                <th>Boot Opening(Cm)</th>
                 <th width="300">Action</th>
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


                   <input type="hidden" name="id" id="gumboot_id">

                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">EU Size</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="eUSize" name="eUSize" value=""  required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-8 col-sm-12 control-label">US Size</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="uSSize" name="uSSize"  placeholder="" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-8 col-sm-12 control-label">UK Size</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="uKSize" name="uKSize"  placeholder="" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-8 col-sm-12 control-label">Inner S Length</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="innerSLengthCm" name="innerSLengthCm"  placeholder="" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-8 col-sm-12 control-label">Boot Length</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="bootLengthCm" name="bootLengthCm"  placeholder="" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-8 col-sm-12 control-label">Inner S Width</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="innerSWidthCm" name="innerSWidthCm"  placeholder="" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-8 col-sm-12 control-label">Boot Width</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="bootWidthCm" name="bootWidthCm"  placeholder="" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-8 col-sm-12 control-label">Boot Opening</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="bootOpeningCm" name="bootOpeningCm"  placeholder="" class="form-control" required>
                        </div>
                    </div>


                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="gumbootButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="gumbootModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="gumbootHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">

                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="gumbootDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('gumboot.index') }}",

        columns: [
            {data: 'id', name: 'id',orderable: false, searchable: true},
            {data: 'eUSize', name: 'sizeName', orderable: false, searchable: true},
            {data: 'uSSize', name: 'usUkSize', orderable: false, searchable: true},
            {data: 'uKSize', name: 'euSize', orderable: false, searchable: true},
            {data: 'innerSLengthCm', name: 'innerSLengthCm', orderable: false, searchable: true},
            {data: 'bootLengthCm', name: 'bootLengthCm', orderable: false, searchable: true},
            {data: 'innerSWidthCm', name: 'innerSWidthCm', orderable: false, searchable: true},
            {data: 'bootWidthCm', name: 'bootWidthCm', orderable: false, searchable: true},
            {data: 'bootOpeningCm', name: 'bootOpeningCm', orderable: false, searchable: true},
            {data: 'action', name: 'action', orderable: true, searchable: false},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#managegumboot').click(function () {
        $('#gumbootButton').val("create-room");
        $('#gumboot_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new Gumboot Size");
        $('#ajaxModel').modal('show');

       
    });

   // protected $fillable = ['id','eUSize','uSSize','uKSize','innerSLengthCm','bootLengthCm','innerSWidthCm','bootWidthCm','bootOpeningCm','status'];

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.editgumboot', function () {
      var gumboot_id = $(this).data('id');
     
      $.get("{{ route('gumboot.index') }}" +'/' + gumboot_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Gumboot details");
          $('#gumbootButton').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#gumboot_id').val(data.id);
          $('#eUSize').val(data.eUSize); //input id,database
          $('#uSSize').val(data.uSSize);
          $('#uKSize').val(data.uKSize);
          $('#innerSLengthCm').val(data.innerSLengthCm);
          $('#bootLengthCm').val(data.bootLengthCm);
          $('#innerSWidthCm').val(data.innerSWidthCm);
          $('#bootWidthCm').val(data.bootWidthCm);
          $('#bootOpeningCm').val(data.bootOpeningCm);

          
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#gumbootButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Save');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('gumboot.store') }}",
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

        $.get('/getView?v=Gumboot',function(data){        
           $('#contentpage').empty();                          
           $('#contentpage').append(data.html);
            });

            // window.location.href = '/home';
        table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#gumbootButton').html('Save Changes');
              alert(data);
                
          }
      });
    });

  //  After clicking delete it will trigger here

    $('body').on('click', '.deletegumboot', function () {
      var gumboot_id = $(this).data('id');
     
      $.get("{{ route('gumboot.index') }}" +'/' + gumboot_id +'/edit', function (data) {
          $('#gumbootHeading').html("Do you want to delete?");
          $('#gumbootDeleteButton').val("edit-room");
          $('#gumbootModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#gumboot_id').val(data.id);
          $('#eUSize').val(data.eUSize); //input id,database
          $('#uSSize').val(data.uSSize);
          $('#uKSize').val(data.uKSize);
          $('#innerSLengthCm').val(data.innerSLengthCm);
          $('#bootLengthCm').val(data.bootLengthCm);
          $('#innerSWidthCm').val(data.innerSWidthCm);
          $('#bootWidthCm').val(data.bootWidthCm);
          $('#bootOpeningCm').val(data.bootOpeningCm);
      })
   });
   
  // after clicking yes in delete
    $('#gumbootDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyGumboot') }}",
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
        $.get('/getView?v=Gumboot',function(data){        
           $('#contentpage').empty();                          
           $('#contentpage').append(data.html);
            });

            // window.location.href = '/home';
			table.draw();                 
       
     
          },
          error: function (data) {
              console.log('Error:', data);
              $('#gumbootDeleteButton').html('Save Changes');
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

