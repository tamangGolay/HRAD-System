
<style>
    
    a {
        color: black !important;
        text-decoration: none;
    }
    
    .btn-primary {
        color: #fff !important;
        background-color: #007bff;
        border-color: #007bff;
    }
    .success {
        color: #fff !important;
        background-color: #28a745;
        border-color: #28a745;
    }
    
    </style>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">                  
             
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<!-- called in bose.css -->

<!-- user_profile -->
<script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
 
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<!-- <link href="{{asset('css/bose.css')}}" rel="stylesheet">  -->
 
<div class="container" style="color:black;">
  <div class="row"> 
  <div class="col-md-12"> 
      <div class="card">

      <div class="card-header bg-green  d-flex justify-content-center"> <h4>Add Job Description</h4> </div>
			       
      <!--/card-header-->
      <br>  

      <form method="POST" action="/jobdescription" enctype="multipart/form-data" accept-charset="UTF-8" >
            @csrf

        

            <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
           
<!-- //{{Auth::user()->empId}} -->
            <!-- <input type="hidden" id="did" name="frId"> -->
                       
            <div class="form-group row"> 
              <label class="col-md-3 col-form-label text-md-right"  for="emp_id">&nbsp;&nbsp;&nbsp;Employee Id:</label>              
                <div class="col-md-6">
                    <input type="number" onKeyPress="if(this.value.length==8) return false; 
                    
                    
                    if( isNaN(String.fromCharCode(event.keyCode))) return false;"
                    
                    
                     class="form-control" value="{{ old('empId') }}"  autocomplete="off" name="emp_id" id="emp_id" placeholder="Employee Id" 
					 
					 onKeyup="

					 if(this.value.length==8 || this.value[0] != 3)
					 getEmployeeDetails(this.value)
					 if(this.value[0] == 3)
					 nima (this.value)

					 ;" required>
          

                </div>
                <div class="col-sm-2">
                    <span id="empid" class="text-danger"></span>
                </div>
            </div>

            <input type="hidden" class="form-control" name="createdDate" id="createdDate" >
   
            <div class="form-group row"> 
              <label class="col-md-3 col-form-label text-md-right" for="nameid">&nbsp;&nbsp;&nbsp;Name:</label>
                <div class="col-md-6">
                  <input type="text" name="nameid" class="form-control" id="nameid" placeholder="Name" readonly required>
                </div>
            </div> 
   


            
             <div class="form-group row"> 
              <label class="col-md-3 col-form-label text-md-right" for="division">&nbsp;&nbsp;&nbsp;Div/Dept/Wing:</label>
                <div class="col-sm-10 col-md-6">
                <input type="text" class="form-control" name="division" id="division" placeholder="Division" readonly required>                  
                </div>
            </div> 

       
            <input type="hidden" class="form-control" name="officeId" id="officeId" placeholder="Division" readonly required>      

            <div class="form-group row"> 
              <label class="col-md-3 col-form-label text-md-right" for="jobdescription">&nbsp;&nbsp;&nbsp;Job Description:</label>
                <div class="col-sm-10 col-md-6">
                <textarea input type="text" rows="14" class="form-control" name="jobdescription" autocomplete="off" id="jobdescription" required> 
                         </textarea></div>
            </div>
 



         <div class="notice">
          <!-- <p style="font-size:20px" > <b> *You are kindly requested to vacate the meeting room, if CEO wants to have a meeting.</b></p></div> -->
           <div class="form-group row mb-0" >
              <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12 ">
                <button type="submit" id="book" class="btn btn-outline-success btn-lg">Save details</button>
                </div> 
              <br>
              <br>
              <br> <br>
              
        </div> 
      </div>        
           
          </form>
        
      </div> <!--/card-body-->

      <footer class="text-muted main-footer" style="text-center"><br>
      <div  class="d-flex justify-content-center">
      <!-- &nbsp;&nbsp;<p style="text-align:center"><h4>Please contact Front Desk (02 325095/322226) to cancel your booking</strong></h4> -->
   
        </div>
      </footer>
      
</div>  
</div> 
</div>

<script>
    var today = new Date();
	var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
	document.getElementById("createdDate").value = date;
</script>

<script type="text/javascript">
  
 

	function nima()
	{

		if(document.getElementById('emp_id').value[0] == '3' ){

		document.getElementById('empid').innerHTML = '';                        

		}
	}

function getEmployeeDetails(val)
{



    //pulling records using cid from checkin table 
      var csrftoken =document.getElementById('tokenid').value;
          $.get('/getValues?source=jobDescription&info='+val+'&token='+csrftoken,function(data){              
                    console.log(data);
                  
                    document.getElementById('nameid').value = '';                      
                    document.getElementById('division').value =  '';
                    document.getElementById('officeId').value =  '';           
                    document.getElementById('empid').value = '';                        



                    
                $.each(data, function(index, Employee){

                               if(Employee.empName != null)
                          {

                           
                          document.getElementById('nameid').value = Employee.empName;                      
                          document.getElementById('division').value =  Employee.longOfficeName;
                          document.getElementById('officeId').value =  Employee.office;
                          document.getElementById('emp_id').innerHTML= Employee.empId;                    
            
                        
                        }				


                            
                            else {
                                document.getElementById('empid').innerHTML = 'Please check your Employee ID!!!';  
								// document.getElementById('emp_id').value='';
  
                            }                       
                                                         
                            
                })
        });
      
  

}  
$('div.alert').delay(6500).slideUp(300);// Session message  display time




</script>



  
      




