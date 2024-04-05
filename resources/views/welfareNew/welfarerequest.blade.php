<style>
.welfarerefund{
	
	font-family: "Times New Roman", Times, serif;
    font-size: 25px;
  }
  .textfont{
	font-family: Arial, Helvetica, sans-serif; 
	font-size: 15px;
  }
.preserveLines{
	white-space:normal;
}
/* .justification{
	height:100px; */

</style>


<div class="container">
 <div class="row">	
	<div class="col-md-12">
			<div class="card">
	
		<!-- <div class="card card-outline"> -->
			<div class="welfarerefund card-header bg-green  d-flex justify-content-center"> <strong>Welfare Request</strong></div>
			<!--/card-header-->
			<div class="textfont card-body">
				<form method="POST" action="{{ route('Request_welfare') }}" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf                    
					<input type="hidden" class="form-control" value="{{ Auth::user()->emailId }}" name="emailId" id="emailId">				
					<input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >					
					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
					<input type="hidden" class="form-control" name="requestDate" id="requestDate">									

				<div class=" textfont form-group row"> 
                <label class="col-md-2 col-form-label text-md-right" for="nameid">&nbsp;&nbsp;&nbsp;Topic:</label>
                      <div class="col-md-8 ">
                        <input type="text" name="topicWelfare" class="form-control" id="topicWelfare" placeholder="Topic" required>
                      </div>
        </div>   
        
        <div class=" textfont form-group row"> 
                <label class="col-md-2 col-form-label text-md-right" for="empID">&nbsp;&nbsp;&nbsp;EmpId:</label>
                <div class="col-md-3">                       
                <input type="number" id="empID" class="form-control" placeholder="empId,you are requesting for" onKeyPress="if(this.value.length==8) return false;
					       if( isNaN(String.fromCharCode(event.keyCode))) return false"; name="empID" value="{{ old('EmpId') }}"
							  autocomplete="EmpId" onFocusOut="checkEmployee(this.value);" 
							  onKeyup=" if(this.value.length==8) getEmployeeDetails(this.value) 
							  if(this.value[0] == 3 || this.value[0] == 9) empcheck (this.value) ;" required> 
                </div>

                      <span id="info" class="text-danger text-md-right"></span>
                     <div class="col-sm-2"> 
                    <span id="empid" class="text-danger"></span>
                  </div>

                      <div class="col-md-3">
                        <input type="text" name="empName" class="form-control" id="empName" placeholder="Name" readonly required>
                      </div>
        </div>

        
        <div class=" textfont form-group row"> 
                <label class="col-md-2 col-form-label text-md-right" for="nameid">&nbsp;&nbsp;&nbsp;Claiming for:</label>
                      <div class="col-md-8">                      
                        <select name="relationToEmp" id="relationToEmp" class="form-control" required> 
                          <option value=" ">Select Relation</option>
                          <option value="Father">Father</option>
                          <option value="Mother">Mother</option> 
                          <option value="Spouse">Spouse</option>
                          <option value="Son">Son</option> 
                          <option value="Daughter">Daughter</option>
                          <option value="In-law Mother">In-law (Mother)</option> 
                          <option value="In-law Father">In-law (Father)</option> 
                          <option value="Resign">Resign (50%)</option>
                          <option value="Employee">Employee</option>                           
                        </select> 
                      </div>
        </div>  
												

				<div class="form-group row">
                        <label class="col-md-2 col-form-label text-md-right">&nbsp;&nbsp;&nbsp;Justification:</label>
                        <div class="col-md-8">
                                <div contenteditable="true" rows="18" class="justification form-control preserveLines" id="justification" required>
                                    {!! old('justification') !!}
                                </div>
                                <input type="hidden" rows="18" name="justification" id="justification-input">
                        </div>
                </div>
					

					<div class="form-group row mb-0">
						<div class="col text-right col-form-label col-md-right col-sm-4 col-md-6 col-lg-6 ">
							<button type="submit"  id="notes" class="btn btn-success btn-lg">Submit</button>
						</div>
						</div> 
					</form>
   				 </div>

                    <!-- <div class="form-group row mb-0"> -->
						<div class="col text-right col-form-label col-md-right col-sm-4 col-md-6 col-lg-12 ">
							<button  id="notescancel" class="btn btn-info btn-md" onclick="welfareStatus();" style="color:black;">View Welfare Status</button>
						</div>

					</div>
			</div>
		</div>
		</div> 
	
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

		<script type="text/javascript">
		
		$(document).ready(function() {

		
		});



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
                                document.getElementById('empid').innerHTML = 'Please check your Empl Id!';  
                                 document.getElementById('empID').value='';
								
                    
                            }               
                                                         
                            
                })
        });
      
  
} 

function empcheck()
  {

    if(document.getElementById('empID').value[0] == '3' || document.getElementById('empID').value[0] == '9' ){
       document.getElementById('empid').innerHTML = '';                        

    }
  }

</script>

	<script>
		

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

	
  
  
function welfareStatus()
{
 $.get('welfareStatusReview',function(data){ 
    $('#contentpage').empty();                  
    $('#contentpage').append(data.html);
 });

} 

</script>

		
<script>
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    document.getElementById("requestDate").value = date;

    // Use jQuery to copy content from contenteditable div to hidden input on form submit
    $('form').submit(function () {
        var justificationContent = $('#justification').html();
        $('#justification-input').val(justificationContent);
    });
</script>

<script>
	
document.addEventListener('input', function (e) {
    if (e.target && e.target.classList.contains('justification')) {
        // Adjust the height of the contenteditable div
        e.target.style.height = 'auto';
        e.target.style.height = e.target.scrollHeight + 'px';
    }
});
</script>