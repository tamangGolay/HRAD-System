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
			<div class="welfarerefund card-header bg-green  d-flex justify-content-center"> <strong>HR Services</strong> </div>
			<!--/card-header-->
			<div class="textfont card-body">
				<form method="POST" action="{{ route('Request_HrServices') }}" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
                    <input type="hidden" class="form-control" value="{{ Auth::user()->empName }}" name="empName" id="empName" >
					<input type="hidden" class="form-control" value="{{ Auth::user()->emailId }}" name="emailId" id="emailId">
					<input type="hidden" class="form-control" value="{{ Auth::user()->office}}" name="office" id="office">
					<input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >
					
					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
					<input type="hidden" class="form-control" name="serviceDate" id="serviceDate" >

									

                    <div class="form-group row">
						<label class="col-md-2 col-form-label text-md-right" for="topic">Choose service:
							<span style="color: red;">*</span>
						</label>				

						<div class="col-md-8" style="text-align: center;">
							<select name="serviceType" id="serviceType" class="form-control" required 
							data-toggle="tooltip" data-placement="top" title="Select the service you want to avail.">

							<option value="" disabled selected>Select Service</option>
								<option value="concern letter">1. Concern Letter</option>
								<option value="pay slip">2. Pay Slip</option>
								<option value="salary advance">3. Salary Advance</option>
							</select>												
						</div>
					</div>				
					 
					<div class="form-group row" id="purposeField">
							<label class="col-md-2 col-form-label text-md-right">&nbsp;&nbsp;&nbsp;Purpose:
								<span style="color: red;">*</span>
							</label>
							<div class="col-md-8 ">
							<textarea class="form-control preserveLines" name="justification" placeholder="Type here..." id="justification" required>{{ old('body') }}</textarea>
						</div>
					</div>   
					
					<div class="form-group row" id="amountField" style="display: none;">
						<label class="col-md-2 col-form-label text-md-right">&nbsp;&nbsp;&nbsp;Amount:
							<span style="color: red;">*</span>
						</label>
						<div class="col-md-8">
							<input type="number" class="form-control" name="justification" placeholder="Enter amount..." id="amountInput" min="0" required>
						</div>
					</div>				
									

					<div class="form-group row mb-0">
						<div class="col text-right col-form-label col-md-right col-sm-4 col-md-6 col-lg-6 ">
							<button type="submit"  id="notes" class="btn btn-success btn-lg">Submit</button>
						</div>
					</div>
					
					<br />

				<div style="color:red; font-size: 12px;">
					<p>
						<span style="color:green;">*</span>
					Once submitted, your supervisor will review your request, then it moves to the next supervisor until HR. Both you and your supervisor will be notified about the request and its status via email.
						<span style="color:green;">*</span>
					</p>
				</div>
				
					</form>
   				 </div>

                    <!-- <div class="form-group row mb-0"> -->
						<!-- <div class="col text-right col-form-label col-md-right col-sm-4 col-md-6 col-lg-12 ">
							<button  id="notescancel" class="btn btn-info btn-md" onclick="serviceCancel();" style="color:black;">View Notesheet</button>
						</div> -->

					</div>
			</div>
		</div>
		</div> 
	
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

		<script type="text/javascript">
		
		$(document).ready(function() {

		document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';

		});



  

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

 
  
function serviceCancel()
{
 $.get('selfghCancelBooking',function(data){ 
    $('#contentpage').empty();                  
    $('#contentpage').append(data.html);
 });

} 

</script>

		
<script>
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    document.getElementById("serviceDate").value = date;

</script>

<script>
  // justification height adjustable based on content
  document.addEventListener('input', function (e) {
    if (e.target && e.target.id === 'justification') {        
        var scrollHeight = e.target.scrollHeight;     
        e.target.style.height = scrollHeight + 'px';
    }
});

// Adjust the height when the content is removed
document.getElementById('justification').addEventListener('keyup', function () {
    var elem = this;
    setTimeout(function () {
        var scrollHeight = elem.scrollHeight;
        elem.style.height = scrollHeight + 'px';
    }, 0);
});


</script>


<script>
  document.getElementById('serviceType').addEventListener('change', function () {
    const purposeField = document.getElementById('purposeField');
    const amountField = document.getElementById('amountField');
    const justification = document.getElementById('justification');
    const amountInput = document.getElementById('amountInput');

 if (this.value === 'salary advance') {
        // Hide and disable justification
        purposeField.style.display = 'none';
        justification.removeAttribute('required');
        justification.disabled = true;

        // Show and require amount
        amountField.style.display = 'flex';
        amountInput.setAttribute('required', true);
        amountInput.disabled = false;
    } else {
        // Show and require justification
        purposeField.style.display = 'flex';
        justification.setAttribute('required', true);
        justification.disabled = false;

        // Hide and disable amount
        amountField.style.display = 'none';
        amountInput.removeAttribute('required');
        amountInput.disabled = true;
    }
});
</script>


   

