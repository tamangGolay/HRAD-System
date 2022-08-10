<!DOCTYPE html>

<html>

<head>


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>   -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


    <!-- <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">

</head>

<body>

  

<div class="container-fluid" style="margin-right:20%;width:95%;"> 

    <h5 class="text-center">Filter Promotion List Data</h5>
       
 <div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12 text-center">
        <div class="form-group row col-sm-12 col-md-12">        
            <div class="col-lg-6 col-sm-6 col-md-6 text-center">
                <input type="number" name="promotionDueDate" id="promotionDueDate" class="form-control searchEmail" placeholder="Search ...">
                <input type="number" name="month" id="month" class="form-control searchEmaile" placeholder="Search ...">                       
            </div>     
        </div>
        <button type="button" name="" id="btnFiterSubmitSearch" class="btn btn-success col-lg-2 mt-3">Filter</button>
        <button type="button" name="promotionDueDate" id="Reset" class="btn btn-success col-lg-2 mt-3">Reset</button>
 
    </div> 
</div> 
</div>
    <br>

    <table class="table table-bordered data-table ">
    @csrf
                <input type="hidden"  value="{{ csrf_token() }}">

        <thead>

            <tr>
                <th><button class="btn btn-sm btn-success d-none" id="deleteAllBtn">Insert</button>
                <input type="checkbox" class="" id="checkbox" name="main_checkbox"><label></label></th>
                <th>Sl No</th>
                <th>Emp Id</th>
                <th>Grade</th>
                <th>Basic Pay</th>
                <th>Promotion Year</th>
                <th>Promotion Month
                </th>
                <!-- <th width="100px">Action</th> -->

            </tr>

        </thead>

        <tbody>

        </tbody>

    </table>

</div>

  

</body>

  

<!-- <script type="text/javascript"> -->

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

                //GET ALL COUNTRIES
               var table =  $('#data-table').DataTable({
                     processing:true,
                     info:true,
                     ajax:"{{ route('get.countries.list') }}",
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
                    $('input[name="country_checkbox"]').each(function(){this.checked = false;});
                    $('input[name="main_checkbox"]').prop('checked', false);
                    $('button#deleteAllBtn').addClass('d-none');
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
                   $('button#deleteAllBtn').text('Insert ('+$('input[name="country_checkbox"]:checked').length+')').removeClass('d-none');
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

               var url = '{{ route("delete.selected.countries") }}';
               if(checkedCountries.length > 0){
                   swal.fire({
                       title:'Are you sure?',
                       html:'You want to insert <b>('+checkedCountries.length+')</b> data',
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
                           $.post(url,{countries_ids:checkedCountries},function(data){
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

        ajax: {

          url: "{{ route('promotionlistall.index') }}",

          data: function (d) {

                d.promotionDueDate = $('.searchEmail').val(),

                d.month = $('.searchEmaile').val(),

                d.search = $('input[type="search"]').val()

            }

        },

        columns: [

            {data:'checkbox', name:'checkbox', orderable:false, searchable:false},

            {data: 'id', name: 'id'},

            {data: 'empId', name: 'empId'},
            
            {data: 'grade', name: 'grade'},
            
            {data: 'basicPay', name: 'basicPay'},
                        
            {data: 'promotionDueDate', name: 'promotionDueDate'},

            {data: 'month', name: 'month'},

            // {data: 'action', name: 'action', orderable: false, searchable: false},

        ]

    }).on('draw', function(){
                    $('input[name="country_checkbox"]').each(function(){this.checked = false;});
                    $('input[name="main_checkbox"]').prop('checked', false);
                    $('button#deleteAllBtn').addClass('d-none');
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

