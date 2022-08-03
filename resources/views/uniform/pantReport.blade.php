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
  
  
<div class="container-fluid"  style="margin-right:20%;width:95%;">    
 <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
                
                    <div class="form-group row col-sm-12 col-md-12">
                    <div class="col-lg-6 col-sm-12 col-md-6">
                    <label class="col-md-4 col-form-label text-md-left" for="stardate">Office</label>

                    <select class="form-control" name="filter_startdate" id="filter_startdate" required>
                     <option value="">Select Office</option>
                        @foreach($officedetails as $officedetails)
                    <option value="{{$officedetails->id}}">{{$officedetails->longOfficeName}}</option>
                        @endforeach
                    </select>

                        <!-- <input type="date" name="filter_startdate" id="filter_startdate" placeholder="Start Date" class="form-control" required> -->
     
                    </div>  
						
                    
                    <div class="col-lg-6 col-sm-12 col-md-6">
                    <label class="col-md-4 col-form-label text-md-left" for="stardate">Pant Size</label>

                        <!-- <input type="date" name="filter_enddate" id="filter_enddate"  placeholder="End Date" class="form-control" required> -->
                        <select class="form-control" name="filter_enddate" id="filter_enddate" required>
                     <option value="">Select Pant Size</option>
                     <option value="shirt">Shirt</option>
                     <option value="pant">Pant</option>

                        <!-- @foreach($pant as $pant)
                    <option value="{{$pant->id}}">{{$pant->pantSizeName}}</option>
                        @endforeach -->
                    </select>
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
                <b>Pant Size Report</b>
            </h5>
        </div>
	</div> 


            
   <div class="table-responsive textfont">
    <table id="reportdata" class="table table-bordered table-striped">
        <thead>
         
         <tr class="text-nowrap">
             <th>Id</th>
             <th>Name</th>
            <th>Office</th>
            <th>Emp</th>
            <th>Pant</th>
            <th>Shirt</th>

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

   
        var dataTable = $('#reportdata').DataTable({

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
                url: "/pantReport",
                type: "Post",
                data:{filter_startdate:filter_startdate, filter_enddate:filter_enddate}
           
               
            },

          
            
            columns: [

                {
                    data:'pantId',
                    name:'pantId'
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
                    data:'empId',
                    name:'empId'
                },
                {
                    data:'pantSizeName',
                    name:'pantSizeName'
                },
                {
                    data:'shirtSizeName',
                    name:'shirtSizeName'
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
            $('#reportdata').DataTable().destroy();
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
        $('#reportdata').DataTable().destroy();
        fill_datatable();
    });

});


  
</script>