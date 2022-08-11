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
    <!--checkbox-->
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
    <!--checkbox end-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->

 
<div class="container">
    <a class="btn success" href="javascript:void(0)" id="managePromotionAll">Add New &nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>
                <th><button class="btn btn-sm btn-success d-none" id="insertAllBtn">Insert</button>
                <input type="checkbox" class="" id="checkbox" name="main_checkbox"><label></label></th>
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

                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Modification Reason</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="modificationReason" name="modificationReason"  placeholder="eg: Type text here" class="form-control" required>
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



<!-- checkbox -->
<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('toastr/toastr.min.js') }}"></script>
    <script>

    
// checkbox end
         toastr.options.preventDuplicates = true;

         


         $(function(){

                //ADD NEW COUNTRY
                $('#add-country-form').on('submit', function(e){
                    e.preventDefault();
                    var form = this;
                    $.ajax({
                        url:$(form).attr('action'),
                        method:$(form).attr('method'),
                        data:new FormData(form),
                        processData:false,
                        dataType:'json',
                        contentType:false,
                        beforeSend:function(){
                             $(form).find('span.error-text').text('');
                        },
                        success:function(data){
                             if(data.code == 0){
                                   $.each(data.error, function(prefix, val){
                                       $(form).find('span.'+prefix+'_error').text(val[0]);
                                   });
                             }else{
                                 $(form)[0].reset();
                                //  alert(data.msg);
                                $('#data-table').DataTable().ajax.reload(null, false);
                                toastr.success(data.msg);
                             }
                        }
                    });
                });

                //GET ALL promotionAll
               var table =  $('#data-table').DataTable({
                     processing:true,
                     info:true,
                     ajax:"{{ route('get.promotionAll.list') }}",
                     "pageLength":5,
                     "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
                     columns:[
                        //  {data:'id', name:'id'},
                         {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
                         {data:'DT_RowIndex', name:'DT_RowIndex'},
                         {data:'empId', name:'empId'},
                         {data:'basicPay', name:'basicPay'},
                         {data:'grade', name:'grade'},
                         {data:'actions', name:'actions', orderable:false, searchable:false},
                     ]
                }).on('draw', function(){
                    $('input[name="checkboxColumn"]').each(function(){this.checked = false;});
                    $('input[name="main_checkbox"]').prop('checked', false);
                    $('button#insertAllBtn').addClass('d-none');
                });

                $(document).on('click','#editCountryBtn', function(){
                    var country_id = $(this).data('id');
                    $('.editCountry').find('form')[0].reset();
                    $('.editCountry').find('span.error-text').text('');
                    $.post('<?= route("get.country.details") ?>',{country_id:country_id}, function(data){
                        //  alert(data.details.empId);
                        $('.editCountry').find('input[name="cid"]').val(data.details.id);
                        $('.editCountry').find('input[name="empId"]').val(data.details.empId);
                        $('.editCountry').find('input[name="grade"]').val(data.details.grade);
                        $('.editCountry').modal('show');
                    },'json');
                });


                //UPDATE COUNTRY DETAILS
                $('#update-country-form').on('submit', function(e){
                    e.preventDefault();
                    var form = this;
                    $.ajax({
                        url:$(form).attr('action'),
                        method:$(form).attr('method'),
                        data:new FormData(form),
                        processData:false,
                        dataType:'json',
                        contentType:false,
                        beforeSend: function(){
                             $(form).find('span.error-text').text('');
                        },
                        success: function(data){
                              if(data.code == 0){
                                  $.each(data.error, function(prefix, val){
                                      $(form).find('span.'+prefix+'_error').text(val[0]);
                                  });
                              }else{
                                  $('#data-table').DataTable().ajax.reload(null, false);
                                  $('.editCountry').modal('hide');
                                  $('.editCountry').find('form')[0].reset();
                                  toastr.success(data.msg);
                              }
                        }
                    });
                });

                //DELETE COUNTRY RECORD
                $(document).on('click','#deleteCountryBtn', function(){
                    var country_id = $(this).data('id');
                    var url = '<?= route("delete.country") ?>';

                    swal.fire({
                         title:'Are you sure?',
                         html:'You want to <b>insert</b> the data',
                         showCancelButton:true,
                         showCloseButton:true,
                         cancelButtonText:'Cancel',
                         confirmButtonText:'Yes',
                         cancelButtonColor:'#d33',
                         confirmButtonColor:'#556ee6',
                         width:300,
                         allowOutsideClick:false
                    }).then(function(result){
                          if(result.value){
                              $.post(url,{country_id:country_id}, function(data){
                                   if(data.code == 1){
                                       $('#data-table').DataTable().ajax.reload(null, false);
                                       toastr.success(data.msg);
                                   }else{
                                       toastr.error(data.msg);
                                   }
                              },'json');
                          }
                    });

                });




           $(document).on('click','input[name="main_checkbox"]', function(){
                  if(this.checked){
                    $('input[name="checkboxColumn"]').each(function(){
                        this.checked = true;
                    });
                  }else{
                     $('input[name="checkboxColumn"]').each(function(){
                         this.checked = false;
                     });
                  }
                  toggleinsertAllBtn();
           });

           $(document).on('change','input[name="checkboxColumn"]', function(){

               if( $('input[name="checkboxColumn"]').length == $('input[name="checkboxColumn"]:checked').length ){
                   $('input[name="main_checkbox"]').prop('checked', true);
               }else{
                   $('input[name="main_checkbox"]').prop('checked', false);
               }
               toggleinsertAllBtn();
           });


           function toggleinsertAllBtn(){
               if( $('input[name="checkboxColumn"]:checked').length > 0 ){
                   $('button#insertAllBtn').text('Insert ('+$('input[name="checkboxColumn"]:checked').length+')').removeClass('d-none');
               }else{
                   $('button#insertAllBtn').addClass('d-none');
               }
           }


           $(document).on('click','button#insertAllBtn', function(){
                $.ajaxSetup({
                    headers:{
                 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
                });
                $('button#insertAllBtn').addClass('d-none');
                $('#checkbox').addClass('d-none');


               var checkedpromotionAll = [];
               $('input[name="checkboxColumn"]:checked').each(function(){
                   checkedpromotionAll.push($(this).data('id'));
               });

               var url = '{{ route("insert.selected.promotionAll") }}';
               if(checkedpromotionAll.length > 0){
                   swal.fire({
                       title:'Are you sure?',
                       html:'You want to insert <b>('+checkedpromotionAll.length+')</b> data',
                       showCancelButton:true,
                       showCloseButton:true,
                       confirmButtonText:'Yes',
                       cancelButtonText:'Cancel',
                       confirmButtonColor:'#556ee6',
                       cancelButtonColor:'#d33',
                       width:300,
                       allowOutsideClick:false
                   }).then(function(result){
                       if(result.value){
                           $.post(url,{promotion_ids:checkedpromotionAll},function(data){
                              if(data.code == 1){
                                  $('#data-table').DataTable().ajax.reload(null, true);
                                  toastr.success(data.msg);
                                  $.get('/getView?v=promotionall',function(data){
                                  $('#contentpage').empty();                          
                                  $('#contentpage').append(data.html);
                                  }); 
                              }
                           },'json');
                       }
                   })
               }
           });
        



         });
//End of code from other site
   

$(function () {


    //Loading the contents of the Datatable from here
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        "aLengthMenu":[[50,-1],[50,"All"]],
        ajax: "{{ route('promotionAll.index') }}",
        columns: [
            {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
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
          $('#modificationReason').val(data.modificationReason);
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#promotionAllButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Saving...');

        
    
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
       
            $.get('/getView?v=promotionall',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
            }); 
        
            // window.location.href = '/home';
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
          $('#modificationReason').val(data.modificationReason);
      })
   });
   
  // after clicking yes in delete
    $('#promotionAllDeleteButton').click(function (e) {
        e.preventDefault();
        $(this).html('Deleting..');
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('destroyPromotionAll') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#promotionAllModel').modal('hide');
              table.draw();
              window.onload = callajaxOnPageLoad(page);
        var alt = document.createElement("div");
             alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
             alt.innerHTML = "Data Updated Successfully! ";
             setTimeout(function(){
              alt.parentNode.removeChild(alt);
             },4500);
            document.body.appendChild(alt);
            
            $.get('/getView?v=promotionall',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
            }); 
        


            // window.location.href = '/home';
			table.draw();                          
          },
          error: function (data) {
              console.log('Error:', data);
              $('#promotionAllDeleteButton').html('Save Changes');
          }
      });
    });
    

});

     






