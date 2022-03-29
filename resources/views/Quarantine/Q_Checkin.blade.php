<!-- Stored in resources/views/pages/dispatch.blade.php -->
<!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css"-->
<link href="./css/form.css" rel="stylesheet">
<!-- MultiStep Form -->
<div class="container-fluid" >
        <div class="card card-primary card-outline">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <!-- <h2><strong>Sign Up Your User Account</strong></h2>
                <p>Fill all form field to go to next step</p>
                <div class="row"> -->
                    <div class="col-md-12 mx-0">
                    <form method="POST" id="msform" action="Q_Checkin" name="nation" enctype="multipart/form-data" accept-charset="UTF-8">
                    @csrf

                    

                    <!-- progressbar -->
                    <ul id="progressbar">
                        <li class="step" id="account"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          Personal Details</strong></li>
                        <li class="step" id="personal"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          Travel Details</strong></li>
                        <li class="step" id="payment"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          Quarantine Details</strong></li>
                    </ul> <!-- fieldsets -->
              <fieldset>
              <div class="tab">     
                <div class="form-card">                            <!-- </div>  -->
                  <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">

                  <div class="form-group row"> 
                    <label class="col-form-label col-sm-2 text-right" for="user">&nbsp;&nbsp;&nbsp;CID / Work Permit:</label>              
                      <div class="col-sm-3">
                          <input type="text" class="form-control" name="cidpassport_no" id="cidpassport_no" oninput="this.className = ''" onFocusOut="getcheckindetail(this.value)" required>
                      </div>
                      <div class="col-sm-2">
                          <span id="cidno" class="text-danger"></span>
                      </div>
                  </div>
 
                <div class="form-group row"> 
                  <label class="col-sm-2 text-right" for="nameid">&nbsp;&nbsp;&nbsp;Name:</label>
                    <div class="col-sm-4">
                      <input type="text" name="name" class="form-control" oninput="this.className = ''" id="nameid" placeholder="Name"  readonly required>
                    </div>
                </div> 

                <div class="form-group row"> 
                  <label class="col-sm-2 text-right" for="ageid">&nbsp;&nbsp;&nbsp;Age:</label>
                    <div class="col-sm-2">
                      <input type="text" name="age" class="form-control" oninput="this.className = ''" id="ageid" placeholder="Age"  readonly required>
                    </div>
                </div> 

                <div class="form-group row"> 
                  <label class="col-sm-2 text-right" for="genderid">&nbsp;&nbsp;&nbsp;Gender:</label>
                    <div class="col-sm-4">
                    <input type="text" class="form-control" name="gender" oninput="this.className = ''" id="genderid" placeholder="Gender"  readonly required>                  
                    </div>
                </div> 


           

                <div class="form-group row"> 
                  <label class="col-sm-2 text-right" for="nationality">&nbsp;&nbsp;&nbsp;Nationality:</label>
                    <div class="col-sm-6">               
                      <select name="nationality" id="nationality" oninput="this.className = ''" required>
                        <option value="">Select Nationality</option>
                          @foreach($nationality as $nationality)
                            <option value="{{$nationality->id}}">{{$nationality->nationality}}</option>
                          @endforeach
                      </select>
                    </div>
                </div>
                <div class="form-group row"> 
                  <label class="col-sm-2 text-right" for="occupation">&nbsp;&nbsp;&nbsp;Occupation:</label>
                    <div class="col-sm-6">               
                      <select name="occupation" id="occupation" oninput="this.className = ''" required>
                        <option value="">Select Occupation</option>
                          @foreach($occupation as $occupationid)
                            <option value="{{$occupationid->id}}">{{$occupationid->occupation}}</option>
                          @endforeach
                      </select>
                    </div>
                </div>           

                  <div class="form-group row"> 
                    <label class="col-sm-2 text-right" for="contactid">&nbsp;&nbsp;&nbsp;Contact Number:</label>
                      <div class="col-sm-2">
                        <input type="text" name="contact_number" oninput="this.className = ''" class="form-control" id="contactid" placeholder="Contact Number">
                      </div>
                  </div>
                  <div class="form-group row"> 
                    <label class="col-sm-2 text-right" for="contactid">&nbsp;&nbsp;&nbsp;Emergency Number:</label>
                      <div class="col-sm-3">
                        <input type="text" name="emergency_number" oninput="this.className = ''" class="form-control" id="emergency" placeholder="Enter Emergency number">
                      </div>
                  </div>
                  <div class="form-group row"> 
                    <label class="col-sm-2 text-right" for="travel">&nbsp;&nbsp;&nbsp;Current Place of Residence:</label>
                      <div class="col-sm-3">
                        <input type="text" name="place" class="form-control" oninput="this.className = ''" id="place" placeholder="Enter Current Place of Residence" required>
                      </div>
                  </div>
              </div>
            </div>
            </fieldset>
            <fieldset>
              <div class="tab">
              <div class="form-card"> 
                                <hr style="margin-bottom:0.5px;height:1px;border-width:0;color:gray;background-color:gray">
                <div class="col bg-secondary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><strong>Travel Details:</strong></span></div>
          <hr style="margin-top:1px;height:1px;border-width:0;color:gray;background-color:gray">
           
       

          <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="countryoforigin">&nbsp;&nbsp;&nbsp;Country of Origin:</label>
                <div class="col-sm-6">               
                  <select name="countryoforigin" id="countryoforigin" oninput="this.className = ''" required>
                    <option value="">Select Country</option>
                      @foreach($countryoforigin as $countryoforigin)
                        <option value="{{$countryoforigin->id}}">{{$countryoforigin->country}}</option>
                      @endforeach
                  </select>
                </div>
            </div>

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="travel">&nbsp;&nbsp;&nbsp;Travel History:</label>
                <div class="col-sm-2">
                  <textarea type="text" name="travel" class="form-control" oninput="this.className = ''" id="travel" placeholder="Travel History" required>
                </textarea>
                </div>
            </div>
           
            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="dateid">&nbsp;&nbsp;&nbsp;Date of arrival :</label>
                <div class="col-sm-2">
                <input type="date" class="form-control air-datepicker" oninput="this.className = ''" name="joining_date" autocomplete="off" id="dateid" required>
                </div>
            </div>

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="travel">&nbsp;&nbsp;&nbsp;Flight Number:</label>
                <div class="col-sm-2">
                  <input type="text" name="Flightnumber" oninput="this.className = ''" class="form-control" id="Flightnumber" placeholder="Enter Flight Number" required>
                </div>
            </div>

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="travel">&nbsp;&nbsp;&nbsp;Seat # (Fight Passenger):</label>
                <div class="col-sm-2">
                  <input type="text" name="Seatno" oninput="this.className = ''" class="form-control" id="Seatno" placeholder="Enter Seat Number" required>
                </div>
            </div>
          </div>
          </div> 
        </fieldset>
        <fieldset>
          <div class="tab">
              <div class="form-card">
                                <hr style="margin-bottom:0.5px;height:1px;border-width:0;color:gray;background-color:gray">
                            <div class="col bg-secondary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><strong>Quarantine Details:</strong></span></div>
                      <hr style="margin-top:1px;height:1px;border-width:0;color:gray;background-color:gray">

            



            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="dzongkhag">&nbsp;&nbsp;&nbsp;Dzongkhag/Thromde:</label>
                <div class="col-sm-6">               
                  <select name="dzongkhag" oninput="this.className = ''" id="dzongkhag" required>
                    <option value="">Select Dzongkhag/Thromde</option>
                      @foreach($dzongkhags as $dzongkhag)
                        <option value="{{$dzongkhag->id}}">{{$dzongkhag->Dzongkhag_Name}}</option>
                      @endforeach
                  </select>
                </div>
            </div>
            
           
            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="facility">&nbsp;&nbsp;&nbsp;Name of Facility:</label>
                <div class="col-sm-6">               
                  <select name="facility" oninput="this.className = ''" id="facility" required>                    
                     
                  </select>
                </div>
            </div>

          
            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="room_number">&nbsp;&nbsp;&nbsp;Room Number:</label>
                <div class="col-sm-2">
                 <select name="room_number" oninput="this.className = ''" id="room_number" required>
                      <option value="">Select room</option>
                     
                 </select>
                  
                </div>
            </div>

            

          
           
            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="dateid">&nbsp;&nbsp;&nbsp;Date of quarantine:</label>
                <div class="col-sm-2">
                <input type="date" class="form-control air-datepicker" oninput="this.className = ''" name="date_of_quarantine" autocomplete="off" id="date_of_quarantine" required>
                </div>
            </div>

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="duration">&nbsp;&nbsp;&nbsp;Duration:</label>
                <div class="col-sm-6">               
                  <select name="duration" oninput="this.className = ''" id="duration" required>
                    <option value="">Select Duration</option>
                    <option value="3">3 days</option>
                    <option value="7">7 days</option>
                    <option value="14">14 days</option>
                    <option value="21">21 days</option>

                  </select>
                </div>
            </div>

    

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="inputPlace">&nbsp;&nbsp;&nbsp;Remarks:</label>
                <div class="col-sm-3">
                  <input type="text" name="remarks" oninput="this.className = ''" class="form-control" id="remarks" placeholder="Remarks" required>
                </div>
            </div>   
      </div>
      </div>
  </fieldset>
                            

                            <div class="row ">
                               <div class="col text-center">
                                <button class="btn btn-secondary"   type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                <button class="btn btn-success"  type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                              </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    



  <!-- <div class="row">    
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
        <div class="col">&nbsp;&nbsp;&nbsp;<strong>Personal Details</strong></div>
      </div></card-header-->
      <!-- <div class="card-body">  -->
           
          

           
        
    

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
  document.getElementById('contenthead').innerHTML = '<strong>Check In Form</strong>';
  $("#dzongkhag").on('change',function(e){
           //console.log(e);
            var id = e.target.value;
            var csrftoken = document.getElementById('tokenid').value;
            $.get('/getValues?source=facilities&info='+id+'&token='+csrftoken,function(data){              
               // console.log(data);
                 $('#facility').empty();               
                  $.each(data, function(index, facility){
                      $('#facility').append('<option value="'+facility.id+'">'+facility.facility_name+'</option>');   
                  })
               
            });
    });


 //get available rooms.
 $("#facility").on('change',function(e){
           //console.log(e);
            var id = e.target.value;
            var csrftoken = document.getElementById('tokenid').value;
            $.get('/getValues?source=availablerooms&info='+id+'&token='+csrftoken,function(data){              
               // console.log(data);
                 $('#room_number').empty();               
                  $.each(data, function(index, room){
                      $('#room_number').append('<option value="'+room.room_no+'">'+room.room_no+'</option>');   
                  })
               
            });
    });
  

var current_fs, next_fs, previous_fs; //fieldsets
var opacity;

 // Current tab is set to be the first tab (0)
  // Display the current tab

$(".next").click(function(){

current_fs = $(this).parent();
next_fs = $(this).parent().next();

//Add Class Active
$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

//show the next fieldset
next_fs.show();
//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
next_fs.css({'opacity': opacity});
},
duration: 600
});
});

$(".previous").click(function(){

current_fs = $(this).parent();
previous_fs = $(this).parent().prev();

//Remove class active
$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
previous_fs.show();

//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
previous_fs.css({'opacity': opacity});
},
duration: 600
});
});

$('.radio-group .radio').click(function(){
$(this).parent().find('.radio').removeClass('selected');
$(this).addClass('selected');
});

$(".submit").click(function(){
return false;
}); 

});
<!-- get details of checkin. -->
function getcheckindetail(val)
{
if(val.length > 8)
    {
      var csrftoken =document.getElementById('tokenid').value;


        $.get('/getCheckindetail?cid='+val+'&token='+csrftoken,function(data){              

          var dt = new Date();
                    document.getElementById('nameid').value = '';
                    document.getElementById('ageid').value = '';
                    document.getElementById('genderid').value = '';
                    document.getElementById('cidno').innerHTML = '';
                    var btn = document.getElementById('nextBtn');
                   
                   
                    const obj = JSON.parse(data);

                 if(obj != null)
                 {                    

                   if(obj["message"] == "error")
                   {
                       document.getElementById('cidno').innerHTML ="Failed to fetch. Try again later.";             
                   }

                   if(obj["message"] == "exists")
                   {
                    document.getElementById('nameid').value = obj["name"];
                    document.getElementById('ageid').value = dt.getFullYear() - obj["yob"];                 
                    document.getElementById('genderid').value = obj["gender"];

                    document.getElementById('nameid').setAttribute('readonly','');
                    document.getElementById('ageid').setAttribute('readonly','');               
                    document.getElementById('genderid').setAttribute('readonly','');

                    document.getElementById('cidno').innerHTML = obj["name"]+", Already Checked In.";
                                 
                   }

                   if(obj["message"] == "fetched")
                   {
                    document.getElementById('nameid').value = obj["name"];
                    document.getElementById('ageid').value = dt.getFullYear() - obj["yob"];
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

                    if(obj["message"] == "norecord")
                   {
                        document.getElementById('nameid').removeAttribute('readonly');
                        document.getElementById('ageid').removeAttribute('readonly');               
                        document.getElementById('genderid').removeAttribute('readonly');
                        document.getElementById('nationality').value ='';

                        var nation = document.nation;
                        //getting cid from userinput 
                        var cid = document.getElementById("cidpassport_no").innerHTML= document.getElementById('cidpassport_no').value;
                        var str = cid; 
                        var cidno = str.substring(0, 3);//choosing only three substring
                        
                        if((cidno >= 101 && cidno <= 120) || (cidno >= 201 && cidno <= 220)){//validating cid length and substring

                          document.getElementById('nationality').value = obj["nationality_id"];//nationality_id 1, bhutanese is pulled from apicontroller


                        }

                        document.getElementById('cidno').innerHTML ='no record';

                   }
                   
                }
                $('#dzongkhag').change();
            
            });
             
        }



}




var currentTab = 0;
showTab(currentTab);


function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");

  x[n].style.display = "block";
  
 
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";

    if (n == (x.length)) {
    document.getElementById("nextBtn").innerHTML = "none";
  }
  }
  
  else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
 fixStepIndicator(n)
}








function nextPrev(n) {
 

  // Exit the function if any field in the current tab is invalid:
 if (n == 1 && !validateForm()) return false;
 
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab == x.length) {
    document.getElementById("msform").submit();
   return false;
  }
  // Otherwise, display the correct tab:
    showTab(currentTab);

  
}
function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");

  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;

    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
   document.getElementsByClassName("step")[currentTab].className += " finish";
  }
 
  return valid; // return the valid status
  

}




function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace("active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}


</script>

