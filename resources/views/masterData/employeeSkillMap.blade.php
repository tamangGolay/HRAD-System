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
    <a class="btn success" href="javascript:void(0)" id="manageSkillCategory">Add New Employee Skills&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>
                <th>Id</th>
                <th>EmployeeId</th>
                <th>Skills</th>
                <th>Obtained On</th>
                <th>Expiray Date On</th>
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


                   <input type="hidden" name="id" id="skillcategory_id">
                   
                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">Employee Id</label>
                        <div class="col-sm-12">
                            <!-- <input type="text" class="form-control" id="empId" name="empId" placeholder="Enter your Employee Id" value="" maxlength="50" required> -->
                            <select name="pNo" id="pNo" value="" class="form-control" required>

                                             <option value="">select your employee</option>
                                             @foreach($emp as $emp)

                                             <option value="{{$emp->id}}">{{$emp->empId}}</option>
										@endforeach
							</select>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">Skills</label>
                        <div class="col-sm-12">
                             <select name="skillId" id="skillId" value="" class="form-control" required>

                                             <option value="">select Skills</option>

                                             @foreach($skills as $skills)

                                             <option value="{{$skills->id}}">{{$skills->skillName}}</option>
										@endforeach
							</select>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">Obtained on</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="obtainedOn" name="obtainedOn" placeholder="" value="" maxlength="50" required>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="name" class="col-sm-2 col-lg-8 control-label">Expiry Date</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="expiryDate" name="expiryDate" placeholder="" value="" maxlength="50" required>
                        </div>
                     </div>
                    
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="skillcategoryButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="employeeSkillCategoryModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="skillcategoryHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                    <button type="submit" class="btn btn-outline-success" id="skillCategoryDeleteButton" value="create">Yes</button>
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
        ajax: "{{ route('employeeskillmap.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'empId', name: 'users.empId'},
            {data: 'skillName', name: 'skillmaster.skillName'},
            {data: 'obtainedOn', name: 'obtainedOn'},
            {data: 'expiryDate', name: 'expiryDate'},
            {data: 'action', name: 'action'}
        ]
    });


    //After Clicking the Add New button it will trigger here
    $('#manageSkillCategory').click(function () {    //manange vehicle
        $('#skillcategoryButton').val("create-room");
        $('#skillcategory_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new Employee");   // model heading
        $('#ajaxModel').modal('show');  

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.editSkillCategory', function () {
      var skillcategory_id = $(this).data('id');
     
      $.get("{{ route('employeeskillmap.index') }}" +'/' + skillcategory_id +'/edit', function (data) {
          $('#modelHeading').html("Edit employee skill  details");
          $('#skillcategoryButton').val("edit-grade");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#skillcategory_id').val(data.id);
          $('#pNo').val(data.pNo); //input id,database
          $('#skillId').val(data.skillId);
          $('#obtainedOn').val(data.obtainedOn);
          $('#expiryDate').val(data.expiryDate);   

      })
   });


//   After clicking save changes in Add and Edit it will trigger here

    $('#skillcategoryButton').click(function (e) {  //after clicking save changes
       
        e.preventDefault();
        $(this).html('Saving...');
        

        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('employeeskillmap.store') }}",    // grade-route
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

       $.get('/getView?v=employeeskillmap',function(data){        
           $('#contentpage').empty();                          
           $('#contentpage').append(data.html);
            });

            // window.location.href = '/home';
        table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#skillcategoryButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });


  //  After clicking delete it will trigger here

    $('body').on('click', '.deleteSkillCategory', function () {
      var skillcategory_id = $(this).data('id');
     
      $.get("{{ route('employeeskillmap.index') }}" +'/' + skillcategory_id +'/edit', function (data) {
          $('#skillcategoryHeading').html("Do you want to delete the Skill Category?");
          $('#skillCategoryDeleteButton').val("edit-grade");
          $('#employeeSkillCategoryModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#skillcategory_id').val(data.id); //input id,database
          $('#pNo').val(data.pNo); //input id,database
          $('#skillId').val(data.skillId);
          $('#obtainedOn').val(data.obtainedOn);
          $('#expiryDate').val(data.expiryDate);  
          
      })
   });
   
  // after clicking yes in delete
    $('#skillCategoryDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Deleting...');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyEmployeeSkill') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#employeeSkillCategoryModel').modal('hide');
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

           $.get('/getView?v=employeeskillmap',function(data){        
           $('#contentpage').empty();                          
           $('#contentpage').append(data.html);
            });

            
            // window.location.href = '/home';
			table.draw();       
               
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#skillCategoryDeleteButton').html('Save Changes');
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


