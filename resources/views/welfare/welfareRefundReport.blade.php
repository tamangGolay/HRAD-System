
<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> -->
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
  <!-- <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script> -->
  <!-- <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>   -->
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" /> -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
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
 
  
<div class="container-fluid"  style="margin-right:20%;width:95%;">    
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
                        <button type="button" style="width:90px" name="filter" id="filter" class="btn btn-success">Filter</button>

                        <button type="button"  style="width:90px" name="reset" id="reset" class="btn btn-warning">Reset</button>
                    </div>
                </div>

            </div>
            
            <br />
<div class="card-header bg-green">
		<div class="col text-center">
			<h5>
                <b>Welfare Refund Report</b>
            </h5>
        </div>
	</div>   

   <div class="table-responsive textfont">
    <table id="report_data" class="table table-bordered table-striped" >
        <thead>
         <tr class="text-nowrap">

            <th>Sl No</th>
            <th>Employee Id</th>
            <th>Refund Amount</th>
            <th>Refund Date</th>
            
            
        </tr>
         </thead>
     </table>
   </div>
     <br />
 <br/>
  </div>

 </body>
</html>

<script>
$(document).ready(function(){

    fill_datatable();

    function fill_datatable(filter_startdate = '', filter_enddate = '')
    {
        var dataTable = $('#report_data').DataTable({

            dom: 'Blfrtip',
			
			lengthMenu: [ 4, 7, 10 ],
            buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'print'
             ], 
            processing: true,
            serverSide: true,

            ajax:{
                url: "{{ route('refundReport.index') }}",
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
                    data:'amount',
                    name:'amount'
                },
                {
                    data:'refundDate',
                    name:'refundDate'
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
