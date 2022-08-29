<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="chgpsswd card-header bg-green text-center">
                     <h4>Release Welfare Payment</h4>
                    </div>
				<div class="card-body">
					<form method="POST" action="{{route('paymentRelease')}}" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
					<input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >					
					
				<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}"> 

				<input type="hidden" name="id" id="id">

					<div class="textfont form-group row">
						<label for="password" class="col-md-4 col-form-label text-md-right">Employee Id</label>
							<div class="col-md-6">
								
								<input type="number" class="form-control" id="empId" name="empId" onKeyPress="if(this.value.length==8) return false;
									 if( isNaN(String.fromCharCode(event.keyCode))) return false"; value="{{old('empId') }}" autocomplete="off" onKeyup=" if(this.value.length==8 || this.value[0] != 3)
								 getEmployeeDetails(this.value)
								 
					if(this.value[0] == 3)
					checkvalue (this.value) ;" required>

					</div>
					
					<div class="col-sm-2">
                    <span id="empid" class="text-danger"></span>  </div>
				</div>

				<div class=" textfont form-group row"> 
					<label class="col-md-4 col-form-label text-md-right" for="nameid">&nbsp;&nbsp;&nbsp;Name:</label>
               			 <div class="col-md-6">
                  			<input type="text" name="empName" class="form-control" id="empName" placeholder="Name" readonly required>
               			 </div>
            	</div> 

				

			<div class="textfont form-group row">
				<label for="releasedate" class="col-md-4 col-form-label text-md-right">Date</label>
					<div class="col-md-6">
								
						<input id="requestDate" type="date" class="form-control" name="requestDate"  required>
					</div>
			</div>

			<div class="textfont form-group row"> 
		   <label class="col-md-4 col-form-label text-md-right" for="relation"  onKeyup="getEmployeeDetails(this.value);">&nbsp;&nbsp;&nbsp;Expiry Of:</label>                   
              <div class="col-sm-6">              
                  <select class="form-control form-select" name="relation"  id="relation" required>                      
				  
                  </select>
                </div>
            </div>

			<div class="textfont form-group row"> 
		   <label class="col-md-4 col-form-label text-md-right" for="cidNo">&nbsp;&nbsp;&nbsp;CID of relative:</label>                   
              <div class="col-sm-6">              
                  <select class="form-control form-select" name="cidNo"  id="cidNo" required>                      
				  
                  </select>
                </div>
            </div>
			
									
			    <div class="textfont form-group row">
				<label for="amount" class="col-md-4 col-form-label text-md-right">Amount</label>
					<div class="col-md-6">
						<input id="amount" type="number" class="form-control" name="amount" required>						
					</div>
			    </div>	
						<div class="textfont form-group row">
							<label for="reason" class="col-md-4 col-form-label text-md-right">Reason</label>
							<div class="col-md-6">
								
									<input id="reason" type="text" class="form-control" name="reason" required>
									
							</div>
						</div>						

						<div class="textfont form-group row mb-0">
							<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
								<button type="submit" class="btn btn-outline-success"> Release Payment</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
});


 </script>


<script>
	function checkvalue()
	{
		if(document.getElementById('empId').value[0] == '3' ){
		document.getElementById('empid').innerHTML = '';                        

		}
	}

function getEmployeeDetails(val)
{

    //pulling records using cid from checkin table

      var csrftoken =document.getElementById('tokenid').value;

          $.get('/getValues?source=paymentInfo&info='+val+'&token='+csrftoken,function(data){   

			  $('#relation').empty();               
                  $.each(data, function(index, facility){
                      $('#relation').append('<option value="'+facility.id+'">'+facility.relation+'</option>');   
                  })   
				  
				  $('#cidNo').empty();               
                  $.each(data, function(index, facility){
                      $('#cidNo').append('<option value="'+facility.id+'">'+facility.cIdNo+'</option>');   
                  })  
                   
				  console.log(data);    

				    //document.getElementById('cidNo').value = '';  
                    document.getElementById('empName').value = '';                      
                    document.getElementById('empid').innerHTML = '';                   
                    
                $.each(data, function(index, Employee){


                          if(Employee.empName != null)
                          {
                            document.getElementById('empName').value = Employee.empName;                      
							document.getElementById('empid').innerHTML = '';                        
                          }	
                            
                            else {

                                document.getElementById('empid').innerHTML = 'Record not found in welfare relatives!';  
								 document.getElementById('empId').value='';
                    
                            }                       
                                                         
                            
                })
        });
      
  

}
	</script>
<!-- nima -->