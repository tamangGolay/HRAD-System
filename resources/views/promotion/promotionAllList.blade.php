<!DOCTYPE html>

<html>

<head>


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


    <!-- <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}"> --> -->
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}"> 

</head>

<body>
<div class="container-fluid" style="margin-right:20%;width:95%;" > 
    <div class="card-header bg-green text-center">
        
            <h5>
                <b> Promotion Due List </b>
            </h5>
</div>
		
      

<br>
 <table class="table table-bordered data-table table-striped ">
    @csrf
      <input type="hidden"  value="{{ csrf_token() }}">

        <thead>

            <tr>
                <th><button class="btn btn-sm btn-success d-none" id="updateAllBtn">update</button>
                <input type="checkbox" class="" id="checkbox" name="main_checkbox"><label></label></th>
                <th>Sl No</th>
                <th>Emp Id</th>
                <th>Promotion Year</th>
                <th>Promotion Month</th>
                <th>From Grade</th>
                <th>To Grade</th>
                <th>Old Basic</th>
                <th>New Basic</th>
                <th>Office</th>
                
            </tr>

        </thead>

        <tbody></tbody>

    </table>

   
</div>


</body>


<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('toastr/toastr.min.js') }}"></script>
    <script>

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
                         {data:'promotionYear', name:'promotionYear'},
                         {data:'promotionMonth', name:'promotionMonth'},
                         {data:'fromGrade', name:'toGrade'},
                         {data:'toGrade', name:'toGrade'},
                         {data:'oldBasic', name:'oldBasic'},
                         {data:'newBasic', name:'newBasic'},
                         {data:'office', name:'office'},
                         {data:'actions', name:'actions', orderable:false, searchable:false},
                     ]
                }).on('draw', function(){
                    $('input[name="checkboxColumn"]').each(function(){this.checked = false;});
                    $('input[name="main_checkbox"]').prop('checked', false);
                    $('button#updateAllBtn').addClass('d-none');
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
                         html:'You want to <b>update</b> the data',
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
                  toggleupdateAllBtn();
           });

           $(document).on('change','input[name="checkboxColumn"]', function(){

               if( $('input[name="checkboxColumn"]').length == $('input[name="checkboxColumn"]:checked').length ){
                   $('input[name="main_checkbox"]').prop('checked', true);
               }else{
                   $('input[name="main_checkbox"]').prop('checked', false);
               }
               toggleupdateAllBtn();
           });


           function toggleupdateAllBtn(){
               if( $('input[name="checkboxColumn"]:checked').length > 0 ){
                   $('button#updateAllBtn').text('update ('+$('input[name="checkboxColumn"]:checked').length+')').removeClass('d-none');
               }else{
                   $('button#updateAllBtn').addClass('d-none');
               }
           }


           $(document).on('click','button#updateAllBtn', function(){
                $.ajaxSetup({
                    headers:{
                 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
                });
                $('button#updateAllBtn').addClass('d-none');
                $('#checkbox').addClass('d-none');


               var checkedpromotionAll = [];
               $('input[name="checkboxColumn"]:checked').each(function(){
                   checkedpromotionAll.push($(this).data('id'));
               });

               var url = '{{ route("update.selected.promotionAll") }}';
               if(checkedpromotionAll.length > 0){
                   swal.fire({
                       title:'Are you sure?',
                       html:'You want to update <b>('+checkedpromotionAll.length+')</b> data',
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
                                  $.get('/getView?v=promotionform',function(data){
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

   

    var table = $('.data-table').DataTable({

        processing: true,

        serverSide: true,

        ajax:"{{ route('promotionlistall.index') }}", 

        columns: [

            {data:'checkbox', name:'checkbox', orderable:false, searchable:false},

            {data: 'id', name: 'id'},

            {data:'empId', name:'empId'},

             {data:'promotionYear', name:'promotionYear'},

             {data:'promotionMonth', name:'promotionMonth'},

             {data:'fromGrade', name:'toGrade'},

             {data:'toGrade', name:'toGrade'},

             {data:'oldBasic', name:'oldBasic'},

              {data:'newBasic', name:'newBasic'},

            {data:'officeDetails', name:'officeDetails'},
            // {data: 'action', name: 'action', orderable: false, searchable: false},

        ]

    }).on('draw', function(){
                    $('input[name="checkboxColumn"]').each(function(){this.checked = false;});
                    $('input[name="main_checkbox"]').prop('checked', false);
                    $('button#updateAllBtn').addClass('d-none');
    });

   

    $(".searchEmail").keyup(function(){

        table.draw();

    });


  $('#btnFiterSubmitSearch').click(function(){
        table.draw();
    });



    $('#Reset').click(function(){
        $('#promotionDueDate').val('');
        $('#month').val('');
        table.clear().draw();
    });
});


</script>

</html>

