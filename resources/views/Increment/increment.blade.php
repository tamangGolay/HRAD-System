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

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- called in bose.css -->
    <link href="{{asset('css/bose.css')}}" rel="stylesheet">

    
     
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}"> 
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->


</head>
  
<div class="container">
    <a class="btn btn-success" href="javascript:void(0)" id="manageIncrement">Add new Increment Details&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
       <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>
            <th>
            <input type="checkbox" name="main_checkbox" id="checkbox"class=""><label></label>
            <button class="btn btn-sm btn-success d-none" id=deleteAllBtn>Generate Increment Duelist</button> </th>
            <th>Sl.No</th>   
            <th>Employee Id</th>
            <th>Last Increment Date</th>
			<th>Increment Due Date</th>
			<th>Increment Cycle</th>
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
    

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>   -->
    
    <!-- //code from other site -->

    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('toastr/toastr.min.js') }}"></script>     
    <script>

    toastr.options.preventDuplicates = true;

    $(function () {

$(document).on('click','input[name="main_checkbox"]', function(){
      if(this.checked){
        $('input[name="country_checkbox"]').each(function(){
            this.checked = true;
        });
      }else{
         $('input[name="country_checkbox"]').each(function(){
             this.checked = false;
         });
      }
      toggledeleteAllBtn();
}); 

$(document).on('change','input[name="country_checkbox"]', function(){

   if( $('input[name="country_checkbox"]').length == $('input[name="country_checkbox"]:checked').length ){
       $('input[name="main_checkbox"]').prop('checked', true);
   }else{
       $('input[name="main_checkbox"]').prop('checked', false);
   }
   toggledeleteAllBtn();
});

function toggledeleteAllBtn(){
   if( $('input[name="country_checkbox"]:checked').length > 0 ){
       $('button#deleteAllBtn').text('Generate Increment Duelist ('+$('input[name="country_checkbox"]:checked').length+')').removeClass('d-none');
   }else{
       $('button#deleteAllBtn').addClass('d-none');
   }
}

$(document).on('click','button#deleteAllBtn', function(){
   $.ajaxSetup({
      headers:{
     'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
     }
    }); 

    $('button#deleteAllBtn').addClass('d-none');
    $('#checkbox').addClass('d-none');


    var checkedCountries = [];            
   $('input[name="country_checkbox"]:checked').each(function(){
       checkedCountries.push($(this).data('id'));
       
   });               

   var url = '{{ route("insert.duelist") }}';            

   if(checkedCountries.length > 0){
       swal.fire({
           title:'Are you sure?',
           html:'You want to generate <b>('+checkedCountries.length+')</b> increment Duelist records',                       
           showCancelButton:true,
           showCloseButton:true,
           confirmButtonText:'Yes, Generate',
           cancelButtonText:'Cancel',
           confirmButtonColor:'#008000',
           cancelButtonColor:'#d33',
           width:300,
           allowOutsideClick:false
       }).then(function(result){
           if(result.value){
               $.post(url,{countries_ids:checkedCountries},function(data){
                  if(data.code == 1 ){                 
                    $('#data-table').DataTable().ajax.reload(null, true);                             
                    toastr.success(data.msg);
                    $.get('/getView?v=incrementall',function(data){        
                    $('#contentpage').empty();                          
                     $('#contentpage').append(data.html);
                       });
                    
                  }
                  else{
                    $('#data-table').DataTable().ajax.reload(null, true);
                    toastr.error(data.msg);
                    $.get('/getView?v=incrementall',function(data){        
                    $('#contentpage').empty();                          
                     $('#contentpage').append(data.html);
                       });

                  }
               },
               
               'json');                                   

           }
       })
   }
});
});

$(function () {

  
    //Loading the contents of the Datatable from here
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        "aLengthMenu":[[10,50,500,-1],[10,50,500,"All"]],
        ajax: "{{ route('incrementall.index') }}",
        columns: [
            {data: 'checkbox', name: 'checkbox',orderable: false, searchable: false},
            {data: 'id', name:'id'},
            {data: 'empId', name:'empId'},
            {data: 'lastIncrementDate', name: 'lastIncrementDate'},
			{data: 'incrementDueDate', name: 'incrementDueDate'},
			{data: 'incrementCycle', name: 'incrementCycle'},
			// {data: 'modificationReason', name: 'modificationReason'},
		    {data: 'action', name: 'action',orderable: false, searchable: false}
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

});
</script>



 <!-- After clicking delete it will trigger here -->

    



