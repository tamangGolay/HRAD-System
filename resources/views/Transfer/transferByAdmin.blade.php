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
			<div class="welfarerefund card-header bg-success  d-flex justify-content-center"> <strong>Transfer Form</strong> </div>
			<!--/card-header-->
			<div class="textfont card-body">
				<form method="POST" action="{{ route('Admin_transfer') }}" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
                    <input type="hidden" class="form-control" value="{{ Auth::user()->empName }}" name="empName" id="empName" >
					<input type="hidden" class="form-control" value="{{ Auth::user()->office}}" name="office" id="office">
									
					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">			
					<input type="hidden" class="form-control air-datepicker" id="requestDate" name="requestDate" autocomplete="off" required readonly>
				    <input type="hidden" class="form-control" value="normal" name="status" id="status">	
				  
				 
					<div class=" textfont form-group row col-lg-12"> 
                <label class="col-md-2 col-form-label text-md-right" for="empId">Emp Id:</label>
                      <div class="col-md-8 ">
					  <select class="col-lg-12 col-sm-12 form-control" name="empId" id="empId" value="" required>
                                             <option value="">Select emp Id</option>
                                             @foreach($otherEmp as $otherEmp)
                                             <option value="{{$otherEmp->empId}}">{{$otherEmp->empId}}</option>
										@endforeach
							</select> 				 
					</div>
                  </div>			
					
					
					
					<div class=" textfont form-group row col-lg-12"> 
                <label class="col-md-2 col-form-label text-md-right" for="fromOffice">From Office:</label>
                      <div class="col-md-8 ">
					  <select class="col-lg-12 col-sm-12 form-control" name="fromOffice" id="fromOffice" value="" required>
                                             <option value="">Select Office From</option>
                                             @foreach($officedd as $officedd)
                                             <option value="{{$officedd->id}}">{{$officedd->officeDetails}}</option>
										@endforeach
							</select> 				 
					</div>
                  </div>

				 
				  <div class=" textfont form-group row col-lg-12"> 
                <label class="col-md-2 col-form-label text-md-right" for="toOffice">To Office:</label>
                      <div class="col-md-8 ">
					  <select class="col-lg-12 col-sm-12 form-control" name="toOffice" id="toOffice" value="" required>
                                            
											<option value="">Select Office From</option>
																 @foreach($officett as $officett)
																 <option value="{{$officett->id}}">{{$officett->officeDetails}}</option>
															@endforeach
												</select>  
					  <!-- <input type="text" name="toOffice" class="form-control" id="toOffice" placeholder="Engineering and Research Department" required> -->
                      </div>
                  </div>

				  <div class=" textfont form-group row col-lg-12"> 
                 <label class="col-md-2 col-form-label text-md-right" for="nameid">Request To supervisor:</label>
                      <div class="col-md-8 ">
					  <select class="col-lg-12 col-sm-12 form-control" name="requestToEmp" id="requestToEmp" value="" required>                                    
					                         @foreach($userdeta as $userdeta)
											 <option value="{{$userdeta->supervisor}}">{{$userdeta->supervisor}}</option>
										@endforeach
							</select>  
					  </div>
                  </div>
					
					 
					<div class="textfont form-group row col-lg-12">
						<label class="col-md-2 col-form-label text-md-right" for="purpose">Reason:</label>
						<div class="col-md-8 ">
						<textarea input type="text"  class="form-control" name="reason" autocomplete="off" id="reason" required> 
                         </textarea></div>
					</div>
					   
					<input type="hidden" name="status" id="status" value="normal"> 
                    <div class="form-group row mb-0">
						<div class="col text-right col-form-label col-md-right col-sm-4 col-md-6 col-lg-6 ">
							<button type="submit"  id="notes" class="btn btn-success btn-lg">Submit</button>
						</div> 
                   </form>
                </div>           
         
								
			</div>
		</div> </div>

		<script>
		var today = new Date();
		var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
		document.getElementById("requestDate").value = date;
		</script>
		

   <script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		
		$(document).ready(function() {

		document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';

		});


   

		</script>