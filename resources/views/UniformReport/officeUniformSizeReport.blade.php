
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


 <div class="col-lg-6 col-sm-12 col-md-12">
    <label class="col-md-4 col-form-label text-md-left" for="year">Year</label>
    <div class="col-sm-12 col-lg-12">
        <select name="year" id="year" class="form-control" required>
            <option value="">Select Year</option>
            <!-- Add your years dynamically if needed -->
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <!-- Add more years as needed -->
        </select>
    </div>
</div>
        <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="form-group row col-sm-12 col-md-12">                    
              
                        <div class="col-lg-6 col-sm-12 col-md-6">
                        <label class="col-md-4 col-form-label text-md-left" for="stardate">Office Name</label>
                        <div class="col-sm-12">                          
                            <select name="officeId" id="officeId" value="" class="form-control" required>
                                             <option value="">Select OfficeName</option>
                                             @foreach($officedetailsx as $officedetailsx)
                                             <option value="{{$officedetailsx->officeDetails}}">{{$officedetailsx->officeDetails}}</option>
										
                                            @endforeach
							</select>

                        </div>
                    </div>
						                   
                    <div class="col-lg-6 col-sm-12 col-md-6">
                      <label class="col-md-4 col-form-label text-md-left" for="stardate">Uniform Name</label>
                        <div class="col-sm-12">                          
                            <select name="cloths" id="cloths" value="" class="form-control" required>

                            <option value="">Select Uniform Name</option>
                            <option value="Shirts">Shirts</option>
                            <option value="Jackets">Jackets</option>
                            <option value="Rain Coats">Rain Coats</option>
                            <option value="Pants">Pants</option>
                            <option value="Shoes">Shoes</option>  
                            <option value="Gumboots">Gumboots</option>  
                                                        
						</select>
                    
                    </div>
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
            <b>Officewise Uniform Size Report</b>
            </h5>
        </div>
	</div>   

   <div class="table-responsive textfont">
    <table id="report_data" class="table table-bordered table-striped" >
        <thead>
         <tr class="text-nowrap">

            
            <th>Office Name</th>
            <th>Uniform Name</th>
            <th>Uniform Size</th>
            <th>Uniform Count</th>
            <th>Year</th>          
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

    // function fill_datatable(officeId = '', cloths = '')
    function fill_datatable(officeId = '', cloths = '', year = '')

    {
        var dataTable = $('#report_data').DataTable({

            dom: 'Blfrtip',
			
			lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50,100, "All"]],
            buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'print'
             ], 
            processing: true,
            serverSide: true,

            ajax:{
                url: "{{ route('officewiseUniformSizeReport.index') }}",
                data:{officeId:officeId, cloths:cloths, year: year}
            },
            columns: [

                {
                    data:'Office',
                    name:'Office'
                },
                
                {
                    data:'cloths',
                    name:'cloths'
                },
                {
                    data:'size',
                    name:'size'
                },

                
                {
                    data:'count(*)',
                    name:'count(*)'
                },               
                
                {
                    data:'year',
                    name:'year'
                }    
				

            ]
        });
    }


    $('#filter').click(function(){
        var officeId = $('#officeId').val();
        var cloths = $('#cloths').val();
        var year = $('#year').val();

        if(officeId != '' &&  cloths != '' &&  year != '')
        {
            $('#report_data').DataTable().destroy();
            fill_datatable(officeId, cloths, year);
        }
        else
        {
            alert('Select all the paramter to filter');
        }
    });

    $('#reset').click(function(){
        $('#officeId').val('');
        $('#cloths').val('');
        $('#report_data').DataTable().destroy();
        fill_datatable();
    });

});
  
</script>
