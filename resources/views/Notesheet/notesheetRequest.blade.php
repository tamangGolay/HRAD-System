<style>

.welfarerefund{
	
	font-family: "Times New Roman", Times, serif;
    font-size: 25px;
  }
  .textfont{
	font-family: Arial, Helvetica, sans-serif; 
	font-size: 15px;
  }
</style>


<div class="container">
 <div class="row">	
	<div class="col-md-12">
			<div class="card">
	
		<!-- <div class="card card-outline"> -->
			<div class="welfarerefund card-header bg-green  d-flex justify-content-center"> <strong>Note Sheet</strong> </div>
			<!--/card-header-->
			<div class="textfont card-body">
				<form method="POST" action="{{ route('Request_notesheet') }}" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
                    <input type="hidden" class="form-control" value="{{ Auth::user()->empName }}" name="empName" id="empName" >
					<input type="hidden" class="form-control" value="{{ Auth::user()->emailId }}" name="emailId" id="emailId">
					<input type="hidden" class="form-control" value="{{ Auth::user()->office}}" name="office" id="office">
					<input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >
					
					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
					<input type="hidden" class="form-control" name="notesheetDate" id="notesheetDate" >

									

				<div class=" textfont form-group row"> 
                <label class="col-md-2 col-form-label text-md-right" for="nameid">&nbsp;&nbsp;&nbsp;Topic:</label>
                      <div class="col-md-8 ">
                        <input type="text" name="topic" class="form-control" id="topic" placeholder="Topic" required>
                      </div>
                  </div>               

					
					 
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-md-right" for="purpose">&nbsp;&nbsp;&nbsp;Justication:</label>
						<div class="col-md-8 ">
						<textarea input type="text" rows="18" class="form-control" name="justification" autocomplete="off" id="justification" required> 
                         </textarea></div>
					</div>

                    
					<!-- <div class="form-group row">
						<label class="col-md-2 col-form-label text-md-right" for="purpose">&nbsp;&nbsp;&nbsp;Status:</label>
						<div class="col-md-8">
						<input type="number" class="form-control" name="status" autocomplete="off" id="status" readonly required> 
						</div>
					</div>							 -->
					

					<div class="form-group row mb-0">
						<div class="col text-right col-form-label col-md-right col-sm-4 col-md-6 col-lg-6 ">
							<button type="submit"  id="notes" class="btn btn-success btn-lg">Submit</button>
						</div> 
</form>
    </div>

                    <!-- <div class="form-group row mb-0"> -->
						<div class="col text-right col-form-label col-md-right col-sm-4 col-md-6 col-lg-12 ">
							<button  id="notescancel" class="btn btn-info btn-lg" onclick="notesheetCancel();" style="color:black;">View Notesheet</button>
						</div>
					</div>
                
				
				
			</div>
		</div> </div>
		

		<script src="{{URL::asset('/admin-lte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
		<script src="{{URL::asset('/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
		<script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
		<script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script> 

		
		
		
		
	

   <script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		
		$(document).ready(function() {

		document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';

		});

function checkEmployee(val) {
	
	var csrftoken = document.getElementById('tokenid').value;
	$.get('/getValues?source=checkrefund&info=' + val + '&token=' + csrftoken, function(data) {
		console.log(data);
		
		$.each(data, function(index, Employee) {
			if(Employee.empId != null) {  //empId here is db col name from wfrelease
				document.getElementById('empid').innerHTML = 'Sorry!.This user is not eligble for Refund.';
				document.getElementById('emp_id').value = '';
			}
			
		})
	});
  }

  function getEmployeeDetails(val)
{
    //pulling records using cid from checkin table

      var csrftoken = document.getElementById('tokenid').value;

          $.get('/getValues?source=getName&info='+val+'&token='+csrftoken,function(data){              
                    console.log(data);
                  
                    document.getElementById('empName').value = '';                      
                    
                    document.getElementById('empid').innerHTML = '';              
                    
                   $.each(data, function(index, Employee){


                          if(Employee.empName != null)
                          {
                            document.getElementById('empName').value = Employee.empName;                  
                                
                            document.getElementById('empId').innerHTML='';
                        }  

                            
                            else {
                                document.getElementById('empid').innerHTML = 'Please check your Employee ID!!!';  
                                 document.getElementById('emp_id').value='';
								
                    
                            }               
                                                         
                            
                })
        });
      
  
} 


		</script>

	<script>
		$(function() {
			$("#vehiclerecord").DataTable({
				"dom": 'Blfrtip',
				"responsive": true,
				"lengthChange": true,
				"searching": true,
				"ordering": false,
				"info": false,
				"autoWidth": false,
				"paging": true,
				"retrieve":true,
				buttons: []

			 });
		});

		$('form').submit(function () {
    // Bail out if the form contains validation errors
    if ($.validator && !$(this).valid()) return;

    var form = $(this);
    $(this).find('input[type="submit"], button[type="submit"]').each(function (index) {
        // Create a disabled clone of the submit button
        $(this).clone(false).removeAttr('id').prop('disabled', true).insertBefore($(this));

        // Hide the actual submit button and move it to the beginning of the form
        $(this).hide();
        form.prepend($(this));
    });
	});

	
  function empcheck()
  {

    if(document.getElementById('emp_id').value[0] == '3' || document.getElementById('emp_id').value[0] == '9' ){
       document.getElementById('empid').innerHTML = '';                        

    }
  }
  
function notesheetCancel()
{
 $.get('selfghCancelBooking',function(data){ 
    $('#contentpage').empty();                  
    $('#contentpage').append(data.html);
 });

}
  

		</script>