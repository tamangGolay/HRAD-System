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
        <div class="col bg-info">&nbsp;&nbsp;&nbsp;Personal Details</div>
      </div><!--/card-header-->
      <br>
      <form method="POST" action="{{ url('Q_Checkout') }}" enctype="multipart/form-data" accept-charset="UTF-8">
            @csrf

            <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
            <input type="hidden" name="checkinid" id="checkinid">
            <input type="hidden" name="facilityid" id="facilityid">


            <!-- <input type="hidden" id="did" name="frId"> -->

            <div class="form-group row"> 
              <label class="col-form-label col-sm-2 text-right" for="user">&nbsp;&nbsp;&nbsp;CID / Work Permit:</label>              
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="cidpassport_no" id="cidpassport_no" onFocusOut="getFRdetail(this.value);">
                </div>
                <div class="col-sm-2">
                    <span id="cidno" class="text-danger"></span>
                </div>
            </div>
 
            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="nameid">&nbsp;&nbsp;&nbsp;Name:</label>
                <div class="col-sm-3">
                  <input type="text" name="name" class="form-control" id="nameid" placeholder="Name" readonly required>
                </div>
            </div> 

          

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="genderid">&nbsp;&nbsp;&nbsp;Gender:</label>
                <div class="col-sm-2">
                <input type="text" class="form-control" name="gender" id="genderid" placeholder="Gender" readonly required>                  
                </div>
            </div> 
            
           <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="dateid">&nbsp;&nbsp;&nbsp;Date of arrival :</label>
                <div class="col-sm-2">
                <input type="date" class="form-control air-datepicker" name="joining_date" autocomplete="off" id="joining_date" readonly required>
                </div>
            </div>

           <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="travel">&nbsp;&nbsp;&nbsp;Room	Number:</label>
                <div class="col-sm-2">
                  <input type="text" name="room_no" class="form-control" id="room_no" placeholder="Room Number" readonly required>
                </div>
            </div>

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="dateid">&nbsp;&nbsp;&nbsp;Date of quarantine:</label>
                <div class="col-sm-2">
                <input type="date" class="form-control air-datepicker" name="date_of_quarantine" autocomplete="off" id="date_of_quarantine" required>
                </div>
            </div>

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="dzongkhag">&nbsp;&nbsp;&nbsp;Dzongkhag/Thromde:</label>
                <div class="col-sm-6">               
                  <select name="dzongkhag" id="dzongkhag" required>
                    <option value="">Select Dzongkhag</option>
                      @foreach($dzongkhags as $dzongkhag)
                        <option value="{{$dzongkhag->id}}">{{$dzongkhag->Dzongkhag_Name}}</option>
                      @endforeach
                  </select>
                </div>
            </div>

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="gewog">&nbsp;&nbsp;&nbsp;Gewog/Zone:</label>
                <div class="col-sm-6">
                <select name="gewog" id="gewog" required>
                    <option value="gewog">Select Gewog/Zone</option>
                      
                  </select>  
                </div>
            </div>
           
           <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="inputPlace">&nbsp;&nbsp;&nbsp;Village:</label>
                <div class="col-sm-3">
                  <input type="text" name="village" class="form-control" id="village" placeholder="Enter your village" required>
                </div>
            </div>
            <div class="form-group row"> 
            <label class="col-sm-2 text-right" for="contactid">&nbsp;&nbsp;&nbsp;Upload mbob(screenshot)</label>
              <input type="file" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" name="file" id="file" />
       
             </div>

             <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="dateid">&nbsp;&nbsp;&nbsp;Payment Date:</label>
                <div class="col-sm-2">
                <input type="date" class="form-control air-datepicker" name="payment_date" autocomplete="off" id="payment_date" required>
                </div>
              </div>


            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="inputPlace">&nbsp;&nbsp;&nbsp;Remarks:</label>
                <div class="col-sm-3">
                  <textarea type="text" name="remarks" class="form-control" id="remarks" placeholder="Remarks" required></textarea>
                </div>
            </div>

          
            <div class="form-group row">
              <div class="col-sm-4">
                <button type="submit" class="btn btn-success float-right">Check Out</button>
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

document.getElementById('contenthead').innerHTML = '<strong>Check Out</strong>';

  $("#dzongkhag").on('change',function(e){
           //console.log(e);
            var id = e.target.value;
            var csrftoken = document.getElementById('tokenid').value;
            $.get('/getValues?source=gewogs&info='+id+'&token='+csrftoken,function(data){              
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
  //       $.get('/getCIDDetailsFromApi?cid='+val,function(data){              
  //               console.log(data);
              
  //                   document.getElementById('nameid').value = '';
  //                   document.getElementById('ageid').value = '';
  //                   document.getElementById('genderid').value = '';
                   
  //                   const obj = JSON.parse(data);

  //                if(obj != null)
  //                {                 
  //                  document.getElementById('nameid').value = obj["name"];
  //                  document.getElementById('ageid').value = obj["age"];
  //                  if(obj["gender"] == 'M')
  //                  {
  //                       document.getElementById('genderid').value = "Male";
  //                  }
  //                  else if(obj["gender"] == 'F'){
  //                       document.getElementById('genderid').value = "Female";
  //                  }
  //                  else{
  //                   document.getElementById('genderid').value = "";
  //                  }
                   
  //                }
  //                else {
  //                    alert("No record");
  //                }
                    
                    
            
  //   });
  //  }

//pulling records using cid from checkin table 
   var csrftoken =document.getElementById('tokenid').value;
        $.get('/getValues?source=checkout&info='+val+'&token='+csrftoken,function(data){              
                console.log(data);
                    document.getElementById('nameid').value = ''; 
     
                    document.getElementById('genderid').value = '';
                    document.getElementById('room_no').value = '';
                    document.getElementById('joining_date').value = '';
                    document.getElementById('checkinid').value = '';
                    document.getElementById('facilityid').value = '';



                    
        $.each(data, function(index, FRd){


                  if(FRd.name != null)
                   {
                       document.getElementById('nameid').value = FRd.name;                      
                        document.getElementById('genderid').value = FRd.gender;

                        document.getElementById('room_no').value =  FRd.room_no;
                        document.getElementById('joining_date').value = FRd.date_of_arrival;
                        document.getElementById('checkinid').value = FRd.id;
                        document.getElementById('facilityid').value = FRd.facility_id;
                        document.getElementById('cidno').innerHTML='';
                       
                    }
                    else {
                        document.getElementById('cidno').innerHTML = 'Please check your CID!!!';                        
                    }
                   
                        
                        
                    
                  })
            });
    }
}

</script>
