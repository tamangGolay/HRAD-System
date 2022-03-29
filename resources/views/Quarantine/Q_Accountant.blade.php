<!-- Stored in resources/views/pages/dispatch.blade.php -->

  <div class="row">    
    <div class="col">
      <div class="card card-primary card-outline">
       <div class="card-header bg-info">
        @if(session()->has('message'))
    		<div class="alert alert-success">
        	{{ session()->get('message') }}
    		</div>
	    @endif
            
 	    @if(session()->has('failed'))
                    <div class="alert alert-danger">
                    {{ session()->get('failed') }}
                    </div>
        @endif  
        <div class="col">&nbsp;&nbsp;&nbsp;<strong>Payment made by Government</strong></div>
      </div><!--/card-header-->
      <div class="card-body">
      <form method="POST" action="{{ url('Q_Accountant') }}" enctype="multipart/form-data" accept-charset="UTF-8">
            @csrf
            
 
            
            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="quarantine">&nbsp;&nbsp;&nbsp;Quarantine facility:</label>
                <div class="col-sm-6">               
                  <select name="quarantine" id="quarantine" required>
                    <option >Select Type of quarantine</option>
                    <option value="1">Facility</option>
                    <option value="2">Home</option>
                    <option value="3">Isolation</option>
                    <option value="4">De-isolation</option>

                  </select>
                </div>
            </div>
            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="payment_month">&nbsp;&nbsp;&nbsp;Period month:</label>
                <div class="col-sm-6">               
                  <select name="month" id="month" required>
                    <option >Select Period month</option>
                    <option value="1">January</option>
                    <option value="2">Feburary</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>


                  </select>
                </div>
            </div>      

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="contactid">&nbsp;&nbsp;&nbsp;Payment Amount:</label>
                <div class="col-sm-2">
                  <input type="text" name="paymentamount" class="form-control" id="paymentamountid" placeholder="Payment Amount">
                </div>
            </div>
           
            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="dateid">&nbsp;&nbsp;&nbsp;Date of Payment :</label>
                <div class="col-sm-2">
                <input type="date" class="form-control air-datepicker" name="paymentdate" autocomplete="off" id="paymentadteid" required>
                </div>
            </div>          
       

          <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="financialyear">&nbsp;&nbsp;&nbsp;Financial Year:</label>
                <div class="col-sm-6">               
                  <select name="financialyear" id="financialyear" required>
                    <option value="">Select Year</option>
                    <option value="2020-2021">2020-2021</option>
                    <option value="2021-2022">2021-2022</option>
                    <option value="2022-2023">2022-2023</option>
                                       </select>
                </div>
            </div>

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="contactid">&nbsp;&nbsp;&nbsp;Remarks:</label>
                <div class="col-sm-2">
                  <input type="text" name="remarks" class="form-control" id="remarksid" placeholder="Remarks">
                </div>
            </div>

           
            <!-- <hr style="margin-bottom:0.5px;height:1px;border-width:0;color:gray;background-color:gray">
                <div class="col bg-secondary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><strong>Payment made by Self:</strong></span></div>
          <hr style="margin-top:1px;height:1px;border-width:0;color:gray;background-color:gray">
            


            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="travel">&nbsp;&nbsp;&nbsp;Update status:</label>
                <div class="col-sm-2">
                  <input type="text" name="status" class="form-control" id="status" placeholder="Update status" required>
                </div>
            </div> -->

            
               
            <div class="form-group row">
              <div class="col-sm-4">
                <button type="submit" class="btn btn-success float-right">Submit</button>
              </div> 
            </div>
          </form>
        
      <div> <!--/card-body-->
      </div>
    </div>
</div>
<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
   
<script>

  var createAllErrors = function() {
        var form = $( this ),
            errorList = $( "ul.errorMessages", form );

        var showAllErrorMessages = function() {
            errorList.empty();

            // Find all invalid fields within the form.
            var invalidFields = form.find( ":invalid" ).each( function( index, node ) {

                // Find the field's corresponding label
                var label = $( "label[for=" + node.id + "] "),
                    // Opera incorrectly does not fill the validationMessage property.
                    message = node.validationMessage || 'Invalid value.';

                errorList
                    .show()
                    .append( "<li><span>" + label.html() + "</span> " + message + "</li>" );
            });
        };

        // Support Safari
        form.on( "submit", function( event ) {
            if ( this.checkValidity && !this.checkValidity() ) {
                $( this ).find( ":invalid" ).first().focus();
                event.preventDefault();
            }
        });

        $( "input[type=submit], button:not([type=button])", form )
            .on( "click", showAllErrorMessages);

        $( "input", form ).on( "keypress", function( event ) {
            var type = $( this ).attr( "type" );
            if ( /date|email|month|number|search|tel|text|time|url|week/.test ( type )
              && event.keyCode == 13 ) {
                showAllErrorMessages();
            }
        });
    };
    
$( "form" ).each( createAllErrors );


    </script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  document.getElementById('contenthead').innerHTML = '<strong>Accounts Updation</strong>';

  $("#dzongkhag").on('change',function(e){
           //console.log(e);
            var id = e.target.value;
            $.get('/getValues?source=gewogs&info='+id,function(data){              
                console.log(data);
                 $('#gewog').empty();               
                  $.each(data, function(index, gewogname){
                      $('#gewog').append('<option value="'+gewogname.id+'">'+gewogname.gewog_name+'</option>');   
                  })
               
            });
    });

});


function getFRdetail(val)
{
if(val.length > 8)
    {
        $.get('/getCIDDetailsFromApi?cid='+val,function(data){              
                console.log(data);
              
                    document.getElementById('nameid').value = '';
                    document.getElementById('ageid').value = '';
                    document.getElementById('genderid').value = '';
                   
                    const obj = JSON.parse(data);

                 if(obj != null)
                 {                 
                   document.getElementById('nameid').value = obj["name"];
                   document.getElementById('ageid').value = obj["age"];
                   if(obj["gender"] == 'M')
                   {
                        document.getElementById('genderid').value = "Male";
                   }
                   else if(obj["gender"] == 'F'){
                        document.getElementById('genderid').value = "Female";
                   }
                   else{
                    document.getElementById('genderid').value = "";
                   }
                   
                 }
                 else {
                     alert("No record");
                 }
                    
                    
            
    });
   }

}

</script>
