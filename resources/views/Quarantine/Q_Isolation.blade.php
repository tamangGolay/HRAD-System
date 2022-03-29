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
        <div class="col">&nbsp;&nbsp;&nbsp;<strong>Personal Details</strong></div>
      </div><!--/card-header-->
      <div class="card-body">
      <form method="POST" action="{{ url('Q_Isolation') }}" enctype="multipart/form-data" accept-charset="UTF-8">
            @csrf
            <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
            <!-- <input type="hidden" id="did" name="frId"> -->
            <div class="form-group row"> 
              <label class="col-form-label col-sm-2 text-right" for="user">&nbsp;&nbsp;&nbsp;CID / Work Permit:</label>              
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="cidpassport_no" id="cidpassport_no" onFocusOut="getFRdetail(this.value);">
                </div>
                <div class="col-sm-2">
                    <span id="cidno" class="text-danger"></span>
                </div>
            </div>
 
            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="nameid">&nbsp;&nbsp;&nbsp;Name:</label>
                <div class="col-sm-2">
                  <input type="text" name="name" class="form-control" id="nameid" placeholder="Name" readonly required>
                </div>
            </div> 

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="ageid">&nbsp;&nbsp;&nbsp;Age:</label>
                <div class="col-sm-2">
                  <input type="text" name="age" class="form-control" id="ageid" placeholder="Age" readonly required>
                </div>
            </div> 

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="genderid">&nbsp;&nbsp;&nbsp;Gender:</label>
                <div class="col-sm-2">
                <input type="text" class="form-control" name="gender" id="genderid" placeholder="Gender" readonly required>                  
                </div>
            </div>        
                    

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="contactid">&nbsp;&nbsp;&nbsp;Room Number:</label>
                <div class="col-sm-2">
                  <input type="text" name="roomnumber" class="form-control" id="roomid" placeholder="Room Number" readonly required>
                </div>
            </div>
            
      
            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="dateid">&nbsp;&nbsp;&nbsp;Date of quarantine :</label>
                <div class="col-sm-2">
                <input type="date" class="form-control air-datepicker" name="dateid" autocomplete="off" id="dateid" required readonly>
                </div>
            </div>

            
            <hr style="margin-bottom:0.5px;height:1px;border-width:0;color:gray;background-color:gray">
                <div class="col bg-secondary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><strong>Isolation Details:</strong></span></div>
          <hr style="margin-top:1px;height:1px;border-width:0;color:gray;background-color:gray">
            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="dateid">&nbsp;&nbsp;&nbsp;Date of Isolation:</label>
                <div class="col-sm-2">
                <input type="date" class="form-control air-datepicker" name="isolation_date" autocomplete="off" id="dateid" required>
                </div>
            </div>

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="dateid">&nbsp;&nbsp;&nbsp;End Date:</label>
                <div class="col-sm-2">
                <input type="date" class="form-control air-datepicker" name="end_date" autocomplete="off" id="dateid" required>
                </div>
            </div>

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="travel">&nbsp;&nbsp;&nbsp;Name of isolation:</label>
                <div class="col-sm-2">
                  <input type="text" name="isolationname" class="form-control" id="v" placeholder="Name of Isolation" required>
                </div>
            </div>
            

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="inputPlace">&nbsp;&nbsp;&nbsp;Remarks:</label>
                <div class="col-sm-3">
                  <input type="text" name="remarks" class="form-control" id="remarks" placeholder="Remarks / Shop Name" required>
                </div>
            </div>
          
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
  document.getElementById('contenthead').innerHTML = '<strong>Isolation Form</strong>';
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

  var csrftoken =document.getElementById('tokenid').value;
        $.get('/getValues?source=isolation&info='+val+'&token='+csrftoken,function(data){              
                console.log(data);
                    document.getElementById('nameid').value = ''; 
                    document.getElementById('ageid').value = '';
                    document.getElementById('genderid').value = '';
                    document.getElementById('roomid').value = '';
                    document.getElementById('dateid').value = '';


        $.each(data, function(index, FRd){


                  if(FRd.name != null)
                   {
                       document.getElementById('nameid').value = FRd.name;                      
                        
                        document.getElementById('ageid').value = FRd.age;
                        document.getElementById('genderid').value = FRd.gender;
                        document.getElementById('roomid').value =  FRd.room_no;
                        document.getElementById('dateid').value = FRd.quarantine;
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
