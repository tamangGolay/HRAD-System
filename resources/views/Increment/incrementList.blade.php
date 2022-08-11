<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
     
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
    

</head>
<body>
  

<div class="container-fluid"  style="margin-right:20%;width:95%;">    
 <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="form-group row col-sm-12 col-md-12">                    
              
                        <div class="col-lg-6 col-sm-12 col-md-6">
                        <label class="col-md-4 col-form-label text-md-left" for="stardate">Increment Year</label>                        
                         <input type="number" name="filter" id="filter" class="form-control searchIncrementList" placeholder="Year: 2023/ 2024/..">
                         
                      </div>

                      <div class="col-lg-6 col-sm-12 col-md-6">
                        <label class="col-md-4 col-form-label text-md-left" for="stardate">Increment Month</label>                        
                        <input type="number" name="month" id="month" class="form-control searchIncrementListm " placeholder="Month: January or July">
                        
                      </div>                        
                    </div> 

    <div class="form-group textfont" align="center">
    <button type="button" style="width:90px" name="" id="btnFiterSubmitSearch" class="btn btn-success ">Filter</button>
    <button type="button" style="width:90px" name="" id="Reset" class="btn btn-warning ">Reset</button>
    </div>

</div>

   </div> 


          <!-- <div class="card-header bg-green">		
            <div class="col text-center">
			<h5>
            <b>Increment form list</b>
            </h5>
        </div>
	</div>   -->

    <br>
   
    <table class="table table-bordered data-table"  id="tabb" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>EmpId</th>
                <th>Basic Pay</th>
                <th>Increment  Year</th>
                <th>Increment  Month</th>
                <th><input type="checkbox" name="main_checkbox" id="checkbox"class=""><label></label>
                <button class="btn btn-sm btn-success d-none" id=deleteAllBtn  >Insert into Duelist</button>
            </th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
  </div>
  
</body>

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
// for checkbox from here....
 
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
                   $('button#deleteAllBtn').text('Insert into Duelist ('+$('input[name="country_checkbox"]:checked').length+')').removeClass('d-none');
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
                       html:'You want to insert <b>('+checkedCountries.length+')</b> data into Duelist table',                       
                       showCancelButton:true,
                       showCloseButton:true,
                       confirmButtonText:'Yes, Insert',
                       cancelButtonText:'Cancel',
                       confirmButtonColor:'#04b976',
                       cancelButtonColor:'#d33',
                       width:300,
                       allowOutsideClick:false
                   }).then(function(result){
                       if(result.value){
                           $.post(url,{countries_ids:checkedCountries},function(data){
                              if(data.code == 1){                               
                
                            // window.location.reload();                            
                            // toastr.options.preventDuplicates = true;
                            // $('#data-table').DataTable().ajax.reload(null, true); 
                                                                
                                toastr.success(data.msg);
                                $.get('/getView?v=incrementform',function(data){        
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
   
   var table = $('.data-table').DataTable({
       processing: true,
       serverSide: true,
       ajax: {
         url: "{{ route('incrementlist.index') }}",
         data: function (d) {
               d.filter = $('.searchIncrementList').val(),
               d.month = $('.searchIncrementListm').val(),
                d.search = $('input[type="search"]').val()
           }
       },
       columns: [
           {data: 'id', 
           name: 'id', orderable: false, searchable: false},

           {data: 'empId', 
           name: 'empId'},

           {data: 'basicPay', 
           name:'users.basicPay'},

           {data: 'incrementDueDate', 
           name: 'incrementDueDate'},

           {data: 'month', 
           name: 'month'},

           {data: 'checkbox', name: 'checkbox',orderable: false, searchable: false},
               

       ]
   });
  
   

//    $('#btnFiterSubmitSearch').click(function(){
//        table.draw();
// });

$('#btnFiterSubmitSearch').click(function(){
        var filter = $('#filter').val();
        var month = $('#month').val();

        if(filter != '' &&  month != '')
        {
            
            table.clear().draw();
            
             table.draw();
        }
        else
        {
            alert('Select Both filter option');
        }
    });


$('#Reset').click(function(){
   $('#filter').val('');
   $('#month').val('');
   table.clear().draw();
});
});
    
 
</script>
</html>
