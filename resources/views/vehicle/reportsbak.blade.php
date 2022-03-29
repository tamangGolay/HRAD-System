<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <meta name="csrf-token" content="{!! csrf_token() !!}">

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
  <div class="container-fluid">    
 <div class="row">


                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="form-group textfont">
                    <label class="col-md-4 col-form-label" for="no_of_people">Start Date</label>
                        <input type="date" name="filter_startdate" id="filter_startdate" placeholder="Start Date" class="form-control" required>
                        <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
   
                    </div>
                    <div class="form-group textfont">
                    <label class="col-md-4 col-form-label" for="no_of_people">End Date</label>

                     <input type="date" name="filter_enddate" id="filter_enddate"  placeholder="End Date" class="form-control" required>
                       
                    </div>
                    
                    <div class="form-group textfont" align="center">
                        <button type="button" name="filter" id="filter" class="btn btn-success">Filter</button>

                        <button type="button" name="reset" id="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
            <br />
            <div class="card-header bg-green">
		<div class="col text-center">
			<h5>
                <b>Vehicle Report</b>
            </h5>
        </div>
	</div> 


            
   <div class="table-responsive textfont">
    <table id="report_data" class="table table-bordered table-striped">
        <thead>
         
         <tr class="text-nowrap">
             <th>Booking Id</th>
            <th>Emp Id</th>
            <th>Name</th>
            <th>Wing/Dept/Div</th>
            <th>Date of Requisition</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Vehicle Name</th>
            <th>Purpose</th>
            <th>Places to Visit</th>
            <th>Supervisor</th>
            <th>Designation</th>
             <th >status

            
             </th>
            
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

    $.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
	});

    fill_datatable();

    function fill_datatable(filter_startdate = '', filter_enddate = '')
    {

   
        var dataTable = $('#report_data').DataTable({

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
                url: "/reportsearch",
                type: "Post",
                data:{filter_startdate:filter_startdate, filter_enddate:filter_enddate}
           
               
            },

          
            
            columns: [
                {
                    data:'id',
                    name:'id'
                },
                {
                    data:'emp_id',
                    name:'emp_id'
                },

                {
                    data:'vname',
                    name:'vname'
                },
                {
                    data:'description',
                    name:'description'
                },

                {
                    data:'dateOfRequisition',
                    name:'dateOfRequisition'
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
                    data:'vehicle_name',
                    name:'vehicle_name'
                },
                {
                    data:'purpose',
                    name:'purpose'
                },
                {
                    data:'placesToVisit',
                    name:'placesToVisit'
                },

                {
                    data:'name',
                    name:'name'
                },

                {
                    data:'designation',
                    name:'designation'
                },

                {

                  
                    data:'action',
                    name:'action',

                }

            
            ]

        //     createdRow: (row, data, dataIndex, cells) => {
        //      $(cells[13]).css('background-color', data.status_color)
        //  }
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