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
</style>
<head>
    
<link href="{{asset('css/bose.css')}}" rel="stylesheet">
<!-- called in bose.css -->

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
<button class="btn btn-success" style="color:white;" href="javascript:void(0)" id="manage">Increment Duelist Records of Employee&nbsp;&nbsp;</button>
    <table class="table table-bordered data-table" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>EmpId</th>                
                <th>Increment  Year</th>
                <th>Increment  Month</th>
                <th>Old Basic</th>
                <th>Yearly Increment</th>
                <th>New Basic</th>
                <th><input type="checkbox" name="main_checkbox" id="checkbox"class=""><label></label>
                <button class="btn btn-sm btn-success d-none" id=updateAllBtn >Update data in master data</button>
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
                    $('input[name="update_checkbox"]').each(function(){
                        this.checked = true;
                    });
                  }else{
                     $('input[name="update_checkbox"]').each(function(){
                         this.checked = false;
                     });
                  }
                  toggleupdateAllBtn();
           }); 

           $(document).on('change','input[name="update_checkbox"]', function(){

               if( $('input[name="update_checkbox"]').length == $('input[name="update_checkbox"]:checked').length ){
                   $('input[name="main_checkbox"]').prop('checked', true);
               }else{
                   $('input[name="main_checkbox"]').prop('checked', false);
               }
               toggleupdateAllBtn();
           });

           function toggleupdateAllBtn(){
               if( $('input[name="update_checkbox"]:checked').length > 0 ){
                   $('button#updateAllBtn').text('Update data('+$('input[name="update_checkbox"]:checked').length+')').removeClass('d-none');
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

            
                var updateDuelist = [];            
               $('input[name="update_checkbox"]:checked').each(function(){
                   updateDuelist.push($(this).data('id'));
                   
               });               

               var url = '{{ route("update.duelist") }}';            
            
               if(updateDuelist.length > 0){
                   swal.fire({
                       title:'Are you sure?',
                       html:'You want to Update <b>('+updateDuelist.length+')</b> data in master data records',                       
                       showCancelButton:true,
                       showCloseButton:true,
                       confirmButtonText:'Yes, Update',
                       cancelButtonText:'Cancel',
                       confirmButtonColor:'#008000',
                       cancelButtonColor:'#d33',
                       width:300,
                       allowOutsideClick:false
                   }).then(function(result){
                       if(result.value){
                           $.post(url,{update_ids:updateDuelist},function(data){
                              if(data.code == 1){                               
                
                            // window.location.reload();                            
                            // toastr.options.preventDuplicates = true;
                            // $('#data-table').DataTable().ajax.reload(null, true); 
                                                                
                                toastr.success(data.msg);
                                $.get('/getView?v=incrementform',function(data){     //redirect to same page    
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
       "aLengthMenu":[[10,25,50,-1],[10,25,50,"All"]],
       ajax: {
         url: "{{ route('incrementlist.index') }}",
                },
       columns: [
           {data: 'id', 
           name: 'id', orderable: false, searchable: false},

           {data: 'empId', 
           name: 'empId'},

           {data: 'incrementYear', 
           name:'incrementYear'},

           {data: 'incrementMonth', 
           name: 'incrementMonth'},

           {data: 'oldBasic', 
           name: 'oldBasic'},

           {data: 'yearlyIncrement', 
           name: 'yearlyIncrement'},

           {data: 'newBasic', 
           name: 'newBasic'},

           {data: 'checkbox', name: 'checkbox',orderable: false, searchable: false},
               

       ]
   });
});
  
 
</script>

</html>
