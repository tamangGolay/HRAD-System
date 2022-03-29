<!-- Stored in resources/views/pages/dispatch.blade.php -->

  <div class="row">    
    <div class="col">
      <div class="card card-primary card-outline">
       <div class="card-header bg-info">       
        <div class="col bg-info">&nbsp;&nbsp;&nbsp;Quarantine Facility Details</div>
      </div><!--/card-header-->
      <br>
      <form method="POST" action="{{ url('Q_Facility') }}" enctype="multipart/form-data" accept-charset="UTF-8">
            @csrf   
            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="dzongkhag">&nbsp;&nbsp;&nbsp;Dzongkhag:</label>
                <div class="col-sm-6">               
                  <select name="dzongkhag" id="dzongkhag" required>
                    <option value="">Select dzongkhag</option>
                      @foreach($dzongkhags as $dzongkhag)
                        <option value="{{$dzongkhag->id}}">{{$dzongkhag->Dzongkhag_Name}}</option>
                      @endforeach
                  </select>
                </div>
            </div>
            
            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="nameid">&nbsp;&nbsp;&nbsp;Facility Name:</label>
                <div class="col-sm-6">
                  <input type="text" name="name" class="form-control" id="nameid" placeholder="Facility Name"  required>
                </div>
            </div>             

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="roomnumber">&nbsp;&nbsp;&nbsp;Total Rooms:</label>
                <div class="col-sm-2">
                  <input type="number" name="totalrooms" class="form-control" id="roomnumber" placeholder="Total rooms" required>
                </div>
            </div>
            
            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="starrating">&nbsp;&nbsp;&nbsp;Star Rating</label>
                <div class="col-sm-6">               
                  <select name="starrating" id="starrating">
                    <option value="">Select Rating</option>
                    <option value="1">Budget Hotel</option>
                    <option value="2">Guest House</option>
                    <option value="3">3 star</option>
                    <option value="4">4 star</option>
                    <option value="5">5 star</option>
                    <option value="6">School</option>

                  </select>
                </div>
            </div>

            <div class="form-group row"> 
              <label class="col-sm-2 text-right" for="quarantinetype">&nbsp;&nbsp;&nbsp;Type:</label>
                <div class="col-sm-6">               
                  <select name="quarantinetype" id="quarantinetype" required>                   
                        <option value="Facility">Facility</option>
                        <option value="Home">Home</option>
                        <option value="Isolation">Isolation</option>
                         <option value="De-isolation">De-isolation</option>
                  </select>
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
    
$("form").each( createAllErrors );

 </script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  document.getElementById('contenthead').innerHTML = '<strong>Quarantine Facility</strong>';

});

</script>
