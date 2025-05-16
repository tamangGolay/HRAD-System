
<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  
  <style>
    .topicReport{
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
 
  
<div class="container-fluid">    
<div class="row">
    <!-- Start Date -->
    <div class="col-md-6">
        <div class="form-group textfont">
            <label for="filter_startdate">Start Date</label>
            <input type="date" name="filter_startdate" id="filter_startdate" class="form-control" required>
        </div>
    </div>

    <!-- End Date -->
    <div class="col-md-6">
        <div class="form-group textfont">
            <label for="filter_enddate">End Date</label>
            <input type="date" name="filter_enddate" id="filter_enddate" class="form-control" required>
        </div>
    </div>
</div>

<!-- Filter & Reset Buttons -->
<div class="row mt-3">
    <div class="col text-center">
        <button type="button" name="filter" id="filter" class="btn btn-success">Filter</button>
        <button type="button" name="reset" id="reset" class="btn btn-secondary">Reset</button>
    </div>
</div>
<br />

    <div class="card-header bg-green">
		<div class="col text-center topicReport">
			<h5>
                <b>Conference Report</b>
            </h5>
        </div>
	</div>   

   <div class="table-responsive textfont">
    <table id="report_data" class="table table-bordered table-striped">
        <thead>
         <tr class="text-nowrap">
            
            <th>Emp Id</th>
            <th>Name</th>
            <th>Contact No</th>
            <th>Wing/Dept/Div</th>
            <th>Meeting Name</th>
            <th>Conference Name</th>
			
            <th>Start Date and Time</th>
            <th>End Date and Time</th>
            <th>status</th>
            
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

            dom: 'Blfrtip',
			
			lengthMenu: [ 10, 25, 50 ],
            buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'print'
             ], 
            processing: true,
            serverSide: true,
            ajax:{
                url: "{{ route('conferenceReport.index') }}",
                data:{filter_startdate:filter_startdate, filter_enddate:filter_enddate}
            },
            columns: [

                
                {
                    data:'emp_id',
                    name:'emp_id'
                },

                {
                    data:'name',
                    name:'name'
                },
                {
                    data:'contact_number',
                    name:'contact_number'
                },

                {
                    data:'officeDetails',
                    name:'officeDetails'
                },
                {
                    data:'meeting_name',
                    name:'meeting_name'
                },
                {
                    data:'Conference_Name',
                    name:'Conference_Name'
                },
				
                {
                    data:'start_date',
                    name:'start_date'
                },
                {
                    data:'end_date',
                    name:'end_date'
                },
				{
                    data:'state',
                    name:'state'
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
