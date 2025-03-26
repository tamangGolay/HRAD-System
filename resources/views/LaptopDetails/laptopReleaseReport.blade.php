
<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  
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
                <b>Laptop Release Report</b>
            </h5>
        </div>
	</div>   

   <div class="table-responsive textfont">
    <table id="report_data" class="table table-bordered table-striped" >
        <thead>
         <tr class="text-nowrap">

            <th>Sl No</th>
            <th>Employee Id</th>
            <th>Employee Name </th>
            <th>Release Amount</th>
            <th>Release Date</th>
            
            
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
			
			//lengthMenu: [ 4, 7, 10 ],
            "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
            buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'print'
             ], 
            processing: true,
            serverSide: true,

            ajax:{
                url: "{{ route('laptopReleaseReport.index') }}",
                data:{filter_startdate:filter_startdate, filter_enddate:filter_enddate}
            },

            order: [[4, "desc"]], // Order by releasedate column (index 4) in descending order

            columns: [

                {
                    data: null,
                    name: 'id',
                    render: function (data, type, row, meta) {
                        return meta.row + 1; // Start Sl No from 1
                    }
                },
                {
                    data:'empid',
                    name:'empid'
                },
                {
                    data:'empName',
                    name:'empName'
                },

                {
                    data:'amount',
                    name:'amount'
                },
                {
                    data:'releasedate',
                    name:'releasedate',
                    render: function(data) {
                        // Split the date and time components
                        var parts = data.split(' ');
                        // Take only the date part
                        var dateOnly = parts[0];
                        return dateOnly;
                    }
                }              
                
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(index + 1); // Update Sl No in the first column
            }
        });
    }

    $('#filter').click(function(){
    var filter_startdate = $('#filter_startdate').val();
    var filter_enddate = $('#filter_enddate').val();

    if(filter_startdate != '' && filter_enddate != '') { // Corrected this line
        $('#report_data').DataTable().destroy();
        fill_datatable(filter_startdate, filter_enddate);
    }
    else {
        alert('Select Both filter options'); // This will now execute if one or both dates are not selected
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
