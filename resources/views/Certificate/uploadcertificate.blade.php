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

</style>


<div class="container">
 <div class="row">	
	<div class="col-md-12">
			<div class="card">
	
		<!-- <div class="card card-outline"> -->
			<div class="welfarerefund card-header bg-green  d-flex justify-content-center"> <strong>Certificate Upload</strong></div>
			<!--/card-header-->
			<div class="textfont card-body">
				<form method="POST" action="{{ route('uploadCertificate') }}" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf                    
				
					<input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="authuser" id="empId" >					
					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
					

		    <!-- <div class=" textfont form-group row"> 
                <label class="col-md-2 col-form-label text-md-right" for="nameid">&nbsp;&nbsp;&nbsp;Certificate ID:</label>
                      <div class="col-md-9">
                        <input type="text" name="certificateId" class="form-control" id="certificateId" placeholder="Certificate Id" required>

                         <small id="certError" class="text-danger d-none">
                            Certificate ID must be unique
                        </small>

                      </div>
        </div>  -->


        <div class="textfont form-group row">
                <label class="col-md-2 col-form-label text-md-right">
                    &nbsp;&nbsp;&nbsp;Certificate ID:
                </label>

                <div class="col-md-9">
                    <input type="text"
                          name="certificateId"
                          class="form-control"
                          id="certificateId"
                          value="{{ $certificateId ?? '' }}"
                          readonly>

                    <small class="text-muted">
                        Auto-generated (Year / Serial)
                    </small>
                </div>
            </div>

        
        
         <div class=" textfont form-group row"> 
                <label class="col-md-2 col-form-label text-md-right" for="nameid">&nbsp;&nbsp;&nbsp;Certificate Type:</label>
                      <div class="col-md-9">
                         <select name="certificatetypeid" class="form-control" required>
                            <option value="">-- Select Certificate Type --</option>
                            @foreach($certificateTypes as $type)
                                <option value="{{ $type->id }}">
                                    {{ $type->nameofcertificate }}
                                </option>
                            @endforeach
                         </select>
                      </div>
        </div>  
        
        <div class=" textfont form-group row"> 
                <label class="col-md-2 col-form-label text-md-right" for="empID">&nbsp;&nbsp;&nbsp;EmpId:</label>
                <div class="col-md-3">                       
                <input type="number" id="empID" class="form-control" placeholder="EmpId of the certificate holder" onKeyPress="if(this.value.length==8) return false;
					       if( isNaN(String.fromCharCode(event.keyCode))) return false"; name="issueTo" value="{{ old('EmpId') }}"
							  autocomplete="EmpId" onFocusOut="checkEmployee(this.value);" 
							  onKeyup=" if(this.value.length==8) getEmployeeDetails(this.value) 
							  if(this.value[0] == 3 || this.value[0] == 9) empcheck (this.value) ;" required> 
                </div>

                      <span id="info" class="text-danger text-md-right"></span>
                     <div class="col-sm-2"> 
                    <span id="empid" class="text-danger"></span>
                  </div>

                      <div class="col-md-4">
                        <input type="text" name="receivedBy" class="form-control" id="empName" placeholder="Name" readonly required>
                      </div>
        </div>

              

        <div class="form-group row">
						<label class="col-md-2 col-form-label text-md-right">&nbsp;&nbsp;&nbsp;Issued For/Purpose:</label>
						<div class="col-md-9">
						<textarea rows="5" class="form-control preserveLines" name="issuedFor" placeholder="Type here..." id="issuedFor" required>{{ old('body') }}</textarea>
					</div>
		  </div>

        <div class=" textfont form-group row"> 
                <label class="col-md-2 col-form-label text-md-right" for="nameid">&nbsp;&nbsp;&nbsp;Issued On:</label>
                      <div class="col-md-9">
                        <input type="date" name="issueDate" class="form-control" id="issueDate" placeholder="Certificate Id" required>
                      </div>
        </div>                   
										

				
					

					<div class="form-group row mb-0">
						<div class="col text-right col-form-label col-md-right col-sm-4 col-md-6 col-lg-6 ">
							<button type="submit"  id="notes" class="btn btn-success btn-lg">Submit</button>
						</div>
						</div> 
					</form>
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

</script>


<!-- check certificateid if it exist -->
<!-- <script>
$(function () {

  $('#certificateId').on('focusout', function () {

    const certId = $(this).val().trim();

    // reset state
    $('#certError').addClass('d-none');
    $(this).removeClass('is-invalid');
    $('#notes').prop('disabled', false);

    if (!certId) return;

    $.get("{{ route('check.certificateId') }}", { certificateId: certId })
      .done(function (res) {
        if (res.exists) {
          $('#certError').removeClass('d-none');
          $('#certificateId').addClass('is-invalid');
          $('#notes').prop('disabled', true);
        }
      })
      .fail(function () {
        console.log('Certificate ID check failed');
      });

  });

});
</script> -->