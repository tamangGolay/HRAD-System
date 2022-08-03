
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
                    <label class="col-md-4 col-form-label text-md-left" for="stardate">Office Name</label>
                        <!-- <input type="date" name="filter_startdate" id="filter_startdate" placeholder="Start Date" class="form-control" required> -->
                        <select class="col-lg-12 col-sm-12 form-control" name="offname" id="offname" value="" required>
                                             <option value="">Select Office Name</option>
                                             @foreach($shoerepo as $shoerepo)
                                             <option value="{{$shoerepo->id}}">{{$shoerepo->longOfficeName}}</option>
										@endforeach
							</select>
                    </div>  
						
                    
                    <div class="col-lg-6 col-sm-12 col-md-6">
                    <label class="col-md-4 col-form-label text-md-left" for="stardate">Shoe size UK</label>

                        <!-- <input type="date" name="filter_enddate" id="filter_enddate"  placeholder="End Date" class="form-control" required> -->
                        <select class="col-lg-12 col-sm-12 form-control" name="shoesizee" id="shoesizee" value="" required>
                                             <option value="">Select EU shoe size</option>
                                             @foreach($shoesizerepo as $shoesizerepo)
                                             <option value="{{$shoesizerepo->id}}">{{$shoesizerepo->ukShoeSize}}</option>
										@endforeach
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
                <b>Shoes Report</b>
            </h5>
        </div>
	</div>   

   <div class="table-responsive textfont">
    <table id="report_data" class="table table-bordered table-striped" >
        <thead>
         <tr class="text-nowrap">

            <th>Employee Id</th>
            <th>Name</th>
            <th>Office Name</th>
            <th>Size</th>
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

    function fill_datatable(offname = '', shoesizee = '')
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
                url: "{{ route('shoesreport.index') }}",
                data:{offname:offname, shoesizee:shoesizee}
            },
            columns: [

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
                    data:'ukShoeSize',
                    name:'ukShoeSize'
                }			
            ]
        });
    }


    $('#filter').click(function(){
        var offname = $('#offname').val();
        var shoesizee = $('#shoesizee').val();

        if(offname != '' &&  offname != '')
        {
            $('#report_data').DataTable().destroy();
            fill_datatable(offname, shoesizee);
        }
        else
        {
            alert('Select Both filter option');
        }
    });

    $('#reset').click(function(){
        $('#offname').val('');
        $('#shoesizee').val('');
        $('#report_data').DataTable().destroy();
        fill_datatable();
    });

});
  
</script>
