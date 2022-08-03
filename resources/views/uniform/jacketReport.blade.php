<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <meta name="csrf-token" content="{!! csrf_token() !!}">
  
  <style>
    .ghbheading{
    font-family: "Times New Roman", Times, serif;
    font-size: 25px;
  }
  .textfont{
	font-family: Arial, Helvetica, sans-serif; 
	font-size: 15px;
  }
 </style>
 </head>
 <body>
 <div class="container-fluid" style="margin-right:20%;width:95%;">    
 <div class="row">
 <div class="col-md-12 col-lg-12 col-sm-12">
                
                <div class="form-group row col-sm-12 col-md-12">
                <div class="col-lg-6 col-sm-12 col-md-6">
        
                    <label class="col-md-4 col-form-label text-md-left" for="stardate">Jacket Size</label>
                  
                        
                            <!-- <input type="text" id="serviceHead" name="serviceHead"  placeholder="" class="form-control" required> -->
                            <select name="jacket" id="jacket" value="" class="form-control" required>

                                             <option value="">select jacket sizeName</option>
                                             @foreach($jacketsize as $jacketsize)

                                             <option value="{{$jacketsize->id}}">{{$jacketsize->sizeName}}</option>
										@endforeach
							</select>


                    </div>  
            
                    
                    <div class="col-lg-6 col-sm-12 col-md-6">
                    <label class="col-md-4 col-form-label text-md-left" for="stardate">Office Name</label>

                        <!-- <input type="text" name="officeId" id="officeId"  placeholder="Pant Size" class="form-control" required> -->

                       
                            <!-- <input type="text" id="serviceHead" name="serviceHead"  placeholder="" class="form-control" required> -->
                            <select name="officeId" id="officeId" value="" class="form-control" required>

                                             <option value="">select Office Name</option>
                                             @foreach($officename as $officename)

                                             <option value="{{$officename->id}}">{{$officename->longOfficeName}}</option>
										@endforeach
							</select>

                     </div>
                    </div>


                       
                    

                
                    
                    <div class="form-group textfont" align="center">
                        <button type="button" name="filter" style="width:90px" id="filter" class="btn  btn-success">Filter</button>

                        <button type="button" name="reset" style="width:90px" id="reset" class="btn btn-warning">Reset</button>
                    </div>
                </div>

            </div>
        
            <br />

    <div class="card-header bg-green">
    <div class="col text-center">
      <h5>
                <b>Employee Jacket Size Report</b>
            </h5>
        </div>
  </div>


            
   <div class="table-responsive textfont">
    <table id="jacket_report" class="table table-bordered table-striped">
        <thead>
         
         <tr class="text-nowrap">
             <th>Sl No</th>
            <th>Emp Id</th>
            <th>Emp Name</th>
            <th>Office Name</th>
            <th>Size</th>
            
         </tr>
    </thead>
 </table>
   </div>
            <br />
            <br />
  </div>
 </body>
</html>

<script>

$(document).ready(function(){

    fill_datatable();

    function fill_datatable(jacket = '', officeId = '')
    {

   
        var dataTable = $('#jacket_report').DataTable({

            dom:'Blfrtip',   
            buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
             ],

            
            processing: true,
            serverSide: true,

           
            ajax:{
                url: "{{ route('jacketreport.index') }}", 
                data:{jacket:jacket, officeId:officeId}
            },
            columns: [
                {
                    data:'id',
                    name:'id'
                },
                {
                    data:'empId',
                    name:'empId'
                },

                {
                    data:'empName',
                    name:'empName'
                },
                {
                    data:'longOfficeName',
                    name:'longOfficeName'
                },

                {
                    data:'sizeName',
                    name:'sizeName'
                }

                
            ]

        
        });
    }


    $('#filter').click(function(){
        var jacket = $('#jacket').val();
        var officeId = $('#officeId').val();

        if(jacket != '' &&  jacket != '')
        {
            $('#jacket_report').DataTable().destroy();
            fill_datatable(jacket, officeId);
        }
        else
        {
            alert('Select Both filter option');
        }
    });

    $('#reset').click(function(){
        $('#jacket').val('');
        $('#officeId').val('');
        $('#jacket_report').DataTable().destroy();
        fill_datatable();
    });

});


  
</script>