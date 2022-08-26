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
                    <label class="col-md-4 col-form-label text-md-left" for="stardate">Start Date</label>

                        <input type="date" name="filter_startdate" id="filter_startdate" placeholder="Start Date" class="form-control" required>
     
                    </div>  
            
                    
                    <div class="col-lg-6 col-sm-12 col-md-6">
                    <label class="col-md-4 col-form-label text-md-left" for="stardate">End Date</label>

                        <input type="date" name="filter_enddate" id="filter_enddate"  placeholder="End Date" class="form-control" required>
                       
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
                <b>Welfare Payment Report</b>
            </h5>
        </div>
  </div>


            
   <div class="table-responsive textfont">
    <table id="report_data" class="table table-bordered table-striped">
        <thead>
         
         <tr class="text-nowrap">
             <th>Sl No</th>
            <th>Emp Id</th>
            <th>Release Date</th>
            <th>Deceased</th>
            <th>Amount</th>
            <th>Reason</th>
            
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

    function fill_datatable(filter_startdate = '', filter_enddate = '')
    {

   
        var dataTable = $('#report_data').DataTable({

            dom:'Blfrtip',   
            buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'print'
             ],

            
            processing: true,
            serverSide: true,

           
            ajax:{
                url: "{{ route('paymentreport.index') }}", 
                data:{filter_startdate:filter_startdate, filter_enddate:filter_enddate}
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
                    data:'releaseDate',
                    name:'releaseDate'
                },
                {
                    data:'relation',
                    name:'relation'
                },
                {
                    data:'amount',
                    name:'amount'
                },

                {
                    data:'reason',
                    name:'reason'
                }

                
            ]

        
        });
    }


    $('#filter').click(function(){
        var filter_startdate = $('#filter_startdate').val();
        var filter_enddate = $('#filter_enddate').val();

        if(filter_startdate != '' &&  filter_startdate != '')
        {
            $('#report_data').DataTable().destroy();
            fill_datatable(filter_startdate, filter_enddate);
        }
        else
        {
            alert('Select Both filter option');
        }
    });

    $('#reset').click(function(){
        $('#filter_startdate').val('');
        $('#filter_enddate').val('');
        $('#report_data').DataTable().destroy();
        fill_datatable();
    });

});


  
</script>