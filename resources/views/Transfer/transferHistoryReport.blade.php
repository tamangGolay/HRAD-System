
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
            
                </div>

            </div>
            
            <br />
<div class="card-header bg-green">
		<div class="col text-center">
			<h5>
                <b>Transfer History Report</b>
            </h5>
        </div>
	</div>   

   <div class="table-responsive textfont">
    <table id="report_data" class="table table-bordered table-striped" >
        <thead>
         <tr class="text-nowrap">

            <th>Employee Id</th>
            <!-- <th>Name</th> -->
            <!-- <th>Designation</th> -->
            <!-- <th>Grade</th> -->
            <th>Current Office</th>
            <th>New Office</th>
            <th>Report to Office(CO)</th>
            <th>Report to Office</th>            
            
            <th>Transfer Type</th>
            <th>Transfer Benefit</th>    
            <th>Transfer Reason</th>
            <th>Transfer Date</th>
            <th>Remarks</th>
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

    function fill_datatable(transferFrom = '', transferDate = '')
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
                url: "{{ route('transferhistoryreport.index') }}",
                data:{transferFrom:transferFrom, transferDate:transferDate}
            },
            columns: [

                {
                    data:'empId',
                    name:'empId'
                },
                
                {
                    data:'officeDetails',
                    name:'officeDetails'
                },
                {
                    data:'tooffname',
                    name:'tooffname'
                },
                {
                    data:'oficereoprt',
                    name:'oficereoprt'
                },

                {
                    data:'oficereoprtf',
                    name:'oficereoprtf'
                },
                
               
                {
                    data:'transferType',
                    name:'transferType'
                },
                {
                    data:'transferBenefit',
                    name:'transferBenefit'
                },
                {
                    data:'reasonForTransfer',
                    name:'reasonForTransfer'
                },
                {
                    data:'transferDate',
                    name:'transferDate'
                },
                {
                    data:'hRRemarks',
                    name:'hRRemarks'
                }
            ]
        });
    }


    $('#filter').click(function(){
        var transferFrom = $('#transferFrom').val();
        var transferDate = $('#transferDate').val();

        if(transferDate != '' &&  transferDate != '')
        {
            $('#report_data').DataTable().destroy();
            fill_datatable(transferFrom, transferDate);
        }
        else
        {
            alert('Select Both filter option');
        }
    });

    $('#reset').click(function(){
        $('#transferFrom').val('');
        $('#transferDate').val('');
        $('#report_data').DataTable().destroy();
        fill_datatable();
    });

});
  
</script>
