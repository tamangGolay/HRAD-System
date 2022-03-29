<div class="row">
    <div class="col">
    <form method="POST" action="{{ route('Q_Facility_Rooms') }}" enctype="multipart/form-data" accept-charset="UTF-8">
      @csrf
        <div class="card card-primary card-outline">
            <div class="card-header bg-info">
                 <div class="row">&nbsp;&nbsp;&nbsp;<strong>Facility Details:</strong></div>
            </div>
                    
            <div class="card-body">
             <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
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
                <!-- facility name -->
                 <div class="form-group row"> 
                    <label class="col-sm-2 text-right" for="fname">&nbsp;&nbsp;&nbsp;Facility Name:</label>
                    <div class="col-sm-6">
                     <select name="fname" id="fname">
                                                                   
                      </select>
                    </div>
                </div>
                <!-- starting room number -->
                <div class="form-group row"> 
                    <label class="col-sm-2 text-right" for="fname">&nbsp;&nbsp;&nbsp;Starting Room #:</label>
                    <div class="col-sm-4">
                        <input id="sroom" type="number" name="sroom">
                    </div>
                </div>

                 <!-- Last room number -->
                <div class="form-group row"> 
                    <label class="col-sm-2 text-right" for="fname">&nbsp;&nbsp;&nbsp;Total Rooms:</label>
                    <div class="col-sm-4">
                        <input id="totalroom" type="number" name="totalroom">
                    </div>
                </div>

                 <!-- button -->
                <div class="form-group row">                    
                    <div class="col-sm-4">
                        <input name="buton" id="createForm" type="button" class="btn btn-warning float-right" value="View/Create Room Details">
                    </div>
                </div>
            </div>
        </div> <!-- /card -->
        <div class="card card-outline">
            <div class="card-header bg-secondary">
             Room Details:
            </div>
            <div class="card-body">                    
               <div class="form-group row"> 
                <div id="container" />            
               </div>
            </div>            
        </div>
            <div class="form-group row">                    
                    <div class="col-sm-4">
                        <div id="savebutton" />                      
                    </div>
             </div>
    </form>
    </div>
</div>

<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
<script type="text/javascript">

$(document).ready(function() {

  document.getElementById('contenthead').innerHTML = '<strong>Update Room Details</strong>';

  var button = document.getElementById('createForm');
  button.addEventListener('click', addFields);

  $("#dzongkhag").on('change',function(e)
    {
           //console.log(e);
          //  var id = e.target.value;
                var container = document.getElementById("container");
                // Clear previous contents of the container
                while (container.hasChildNodes()) {
                    container.removeChild(container.lastChild);
                }

                var sbutton = document.getElementById("savebutton");
                // Clear previous contents of the container
                while (sbutton.hasChildNodes()) {
                    sbutton.removeChild(sbutton.lastChild);
                }

                //get list of facilities under the given dzongkhag.
                 var dz = document.getElementById('dzongkhag').value;
                 var totalrooms;
                 var csrftoken =document.getElementById('tokenid').value;
                $.get('/getValues?source=facilities&info='+dz+'&token='+csrftoken,function(data){
                         //console.log(data);
                         $('#fname').empty();                        
                          $.each(data, function(index, flist){
                              $('#fname').append('<option value="'+flist.id+'">'+flist.facility_name+'</option>');                             
                          })

                          $('#fname').change();
                          
                 });

    });

  $("#fname").on('change',function(e){
           //console.log(e);
          //  var id = e.target.value;
                var container = document.getElementById("container");
                // Clear previous contents of the container
                while (container.hasChildNodes()) {
                    container.removeChild(container.lastChild);
                }

                var sbutton = document.getElementById("savebutton");
                // Clear previous contents of the container
                while (sbutton.hasChildNodes()) {
                    sbutton.removeChild(sbutton.lastChild);
                }

                 var fid = document.getElementById('fname').value;
                 var troom = document.getElementById('totalroom');
                 var csrftoken =document.getElementById('tokenid').value;
                $.get('/getValues?source=facilityroom_no&info='+fid+'&token='+csrftoken,function(data){
                         console.log(data);
                         //$('#totolroom').value = 0;                        
                          $.each(data, function(index, froom){
                               troom.value = froom.no_of_rooms;
                          })
                         
                 });

            });



  });

function addFields()
{

    var dz = document.getElementById('dzongkhag').value;
    var qf = document.getElementById('fname').value;
    input_correct =true;
    
    if(dz == null || dz == "")
    {
        alert("Please select select Dzongkhag.");
        document.getElementById('dzongkhag').focus();
        input_correct = false;
    }

    if(qf == null || qf == "")
    {
        alert("Please select select Facility.");
        document.getElementById('fname').focus();
        input_correct = false;
    }

    if(input_correct == false)
    {
        return false;
    }

    if(document.getElementById("sroom").value <= 0)
    {
        alert("please enter value starting room number");
        document.getElementById("sroom").focus();
        return false;
    }

     //call ajax to find if the rooms are updated.

    var csrftoken =document.getElementById('tokenid').value;
    $.get('/getRoomDetails?dz='+dz+'&fq='+qf+'&token='+csrftoken,function(data){

        //console.log(data);
        var container = document.getElementById("container");
        // Clear previous contents of the container
        while (container.hasChildNodes()) {
            container.removeChild(container.lastChild);
        }

        //title room.
        var input = document.createElement("input");
            input.type = "text";
            input.value = "Room #";
            input.setAttribute('readonly','');      
            input.classList.add("bg-secondary");
            input.classList.add("text-center");
            container.appendChild(input);
        //title beds.
        var bed = document.createElement("input");
            bed.type = "text";
            bed.value = "Number of Beds";
            bed.setAttribute('readonly','');
            bed.classList.add("bg-secondary");
            bed.classList.add("text-center");
            container.appendChild(bed);

        container.appendChild(document.createElement("br"));

      
         if(data.length > 1)
         {                    

             $.each(data, function(index, frooms){

                var input = document.createElement("input");        
                    input.type = "text";
                    input.name = "rooms[]";
                    input.id = "roomid"+index;
                    input.classList.add("bg-warning");
                    input.setAttribute('readonly','');
                    input.classList.add("text-center");
                    input.value = frooms.room_no;
               
                    container.appendChild(input);
       
                    //bed input.
                    var bed = document.createElement("input");
                    bed.type = "number";
                    bed.name = "beds[]";
                    bed.id = "bedid"+index;       
                    bed.value = frooms.beds;
                    bed.classList.add("text-right");
                    bed.classList.add("text-muted");
                    container.appendChild(bed);
                    //break.
                    container.appendChild(document.createElement("br"));

                      })
          }
          else
          {
           // Number of inputs to create
            var startroom = document.getElementById("sroom").value;
            var totalroom = document.getElementById("totalroom").value;

            for(i=0;i<totalroom;i++)
            {
             
                // Create an <input> element, set its type and name attributes
                var input = document.createElement("input");        
                input.type = "text";
                input.name = "rooms[]";
                input.id = "roomid"+i;
                input.classList.add("bg-warning");
                input.setAttribute('readonly','');
                input.classList.add("text-center");
                input.value = startroom;
                startroom++;
                container.appendChild(input);
       
                //bed input.
                var bed = document.createElement("input");
                bed.type = "number";
                bed.name = "beds[]";
                bed.id = "bedid"+i;       
                bed.value = "1";
                bed.classList.add("text-right");
                bed.classList.add("text-muted");
                container.appendChild(bed);

                // Append a line break 
                container.appendChild(document.createElement("br"));

            }
          }

        //create button for saving room details.
        var sbutton = document.getElementById("savebutton");
        // Clear previous contents of the container
        while (sbutton.hasChildNodes()) {
            sbutton.removeChild(sbutton.lastChild);
        }

        var btn = document.createElement("button");
            btn.type = "submit";
            btn.innerHTML = "Save";
            btn.classList.add("btn");
            btn.classList.add("float-right");
            btn.classList.add("btn-success");

        sbutton.appendChild(btn);
        
    });

       
}
</script>
