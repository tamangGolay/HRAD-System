


<!-- Stored in resources/views/pages/dispatch.blade.php -->
@extends('layouts.masterstartpage')
@section('pagehead')
<!-- user_profile -->

@endsection

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
<link href="{{asset('css/bose.css')}}" rel="stylesheet">
<!-- called in bose.css -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">                  
             
@section('content')

@if(session()->has('alert-success'))
            <div style="font-size:20px" class="alert alert-info">
             <strong> {{ session()->get('alert-success') }}</strong>
            </div>
          @endif

          @if(session()->has('alert-message'))
            <div style="font-size:20px" class="alert alert-info">
            <strong> {{ session()->get('alert-message') }}</strong>
            </div>
          @endif


          @if(session()->has('alert'))
            <div style="font-size:20px" class="alert alert-danger">
            <strong> {{ session()->get('alert') }}</strong>
            </div>
          @endif

		  @if(session()->has('error'))
            <div style="font-size:20px" class="alert alert-danger">
            <strong> {{ session()->get('error') }}</strong>
            </div>
          @endif

		  @if(session()->has('error1'))
            <div  style="font-size:20px" class="alert alert-danger">
            <strong> {{ session()->get('error1') }}</strong>
            </div>
          @endif
                
                
          @if(session()->has('fail'))
                        <div style="font-size:20px" class="alert alert-danger">
                        <strong>       {{ session()->get('fail') }}</strong>
                        </div>
            @endif 

 
 
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<!-- called in bose.css -->

<!-- user_profile -->
<script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
 
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<link href="{{asset('css/bose.css')}}" rel="stylesheet"> 
<div class="row">  
   
    <div class="col">
      
      
      
       <div class=" justify-content-center"> <div ><h4></h4> </div></div>
       
     
  
        
         </div>
      </div>


 
  <div class="row"> 
     
    <div class="col">

    
      <div class="card card-green ">
       <div class="card-header bg-green">
        
        <div class="col bg-green d-flex justify-content-center">&nbsp;&nbsp;&nbsp;<h4>User Profile</h4></div>
      </div><!--/card-header-->
      <br>

     



      <form method="POST" action="/profileupdate" enctype="multipart/form-data" accept-charset="UTF-8" >
            @csrf

        

            <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
           
<!-- //{{Auth::user()->empId}} -->
            <!-- <input type="hidden" id="did" name="frId"> -->
            <div class="cardbody">

            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right"  for="user">&nbsp;&nbsp;&nbsp;Employee Id:</label>              
                <div class="col-sm-10 col-md-6 col-lg-4">
                    <input type="number" onKeyPress="if(this.value.length==8) return false; 
                    
                    
                    if( isNaN(String.fromCharCode(event.keyCode))) return false;"
                    
                    
                     class="form-control"  value="{{Auth::user()->empId}}" autocomplete="off" name="emp_id" id="emp_id" placeholder="Enter your Employee Id" 
					 
					 onKeyup="

					 if(this.value.length==8 || this.value[0] != 3)
					 getEmployeeDetails(this.value)
					 if(this.value[0] == 3)
					 nima (this.value)

					 ;" onload readonly required>
          

                </div>
                <div class="col-sm-2">
                    <span id="empid" class="text-danger"></span>
                </div>
            </div>
   
            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="nameid">&nbsp;&nbsp;&nbsp;Name:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                  <input type="text" name="name" class="form-control" id="nameid" placeholder="Name" readonly required>
                </div>
            </div> 
            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="dob">&nbsp;&nbsp;&nbsp;DoB:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="dob" id="dob" placeholder="Date of birth" autocomplete="off" readonly  required>                  
                </div>
            </div>
          
            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="cid">&nbsp;&nbsp;&nbsp;CID:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="cid" id="cid" placeholder="Cid no." autocomplete="off" readonly required>                  
                </div>
            </div>

            <!-- <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="blood">&nbsp;&nbsp;&nbsp;Blood Group:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="blood" id="blood" placeholder="bloodgroup" autocomplete="off"  required>                  
                </div>
            </div>
 -->

           

          
    
           
            
                <!-- <input type="hidden" class="form-control" name="divisionh" id="divisionh" placeholder="Division" readonly required>                   -->
           

           
                
          

            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="contact_number">&nbsp;&nbsp;&nbsp;Contact number:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Contact Number"  required>                  
                </div>
            </div>


            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="fixed">&nbsp;&nbsp;&nbsp;Fixed number:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="fixed" id="fixed" placeholder="Fixed Number"  required>                  
                </div>
            </div>

            
            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="extension">&nbsp;&nbsp;&nbsp;Extension:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="extension" id="extension" placeholder="Extension Number"  required>                  
                </div>
            </div>

      

                

            
            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="emailid">&nbsp;&nbsp;&nbsp;Email Id:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="emailid" id="emailid" placeholder="email address" autocomplete="off"  >                  
                </div>
            </div>            
      
                    <div class="form-group row">
					<label class="col-md-4 col-form-label text-md-right" for="office">&nbsp;&nbsp;&nbsp;Place:</label>
						<div class="col-sm-10 col-md-6 col-lg-4">
						<select name="office" id="office" value="" class="form-control" readonly required>
												<option value="">Select Office address</option>
												@foreach($officeaddress as $officeaddress)
												<option value="{{$officeaddress->id}}">{{$officeaddress->Address}}</option>
											@endforeach
								</select>
						</div>
					</div> 

          <div class="form-group row">
					<label class="col-md-4 col-form-label text-md-right" for="qualification">&nbsp;&nbsp;&nbsp;Qualification:</label>
						<div class="col-sm-10 col-md-6 col-lg-4">
						<select name="qualification" id="qualification" value="" class="form-control" readonly required>
												<!-- <option value="">Qualification</option> -->
												@foreach($qualification as $qualification)

												<option value="{{$qualification->id}}">{{$qualification->qualificationName}}</option>
											@endforeach
								</select>
						</div>
					</div> 

          <!-- <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="designation">&nbsp;&nbsp;&nbsp;Qualification:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <textarea type="text" class="form-control" name="qualification" id="qualification" placeholder="qualification" autocomplete="off" readonly required>                   
</textarea> 
              </div>
            </div> -->


 <!-- <input type="hidden" class="form-control" name="placeId" id="placeId" placeholder="place" autocomplete="off" readonly required> -->


             <!-- <input type="text" class="form-control" name="place" id="place" placeholder="Officeaddress" autocomplete="off" readonly required>                   -->
             <!-- <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="place">&nbsp;&nbsp;&nbsp;Office Address:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="place" id="place" placeholder="place" autocomplete="off" readonly required>                  
                </div>
            </div> -->
            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="designation">&nbsp;&nbsp;&nbsp;Designation:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="designation" id="designation" placeholder="designation" autocomplete="off" readonly required>                  
                </div>
            </div>

            <input type="hidden" class="form-control" name="designationId" id="designationId" placeholder="designationId" autocomplete="off" readonly required>                  

            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="grade">&nbsp;&nbsp;&nbsp;Grade:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="grade" id="grade" placeholder="grade" autocomplete="off" readonly required>                  
                </div>
            </div>

            <input type="hidden" class="form-control" name="gradeId" id="gradeId" placeholder="grade" autocomplete="off" readonly required>                         
            
             <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="division">&nbsp;&nbsp;&nbsp;Div/Dept/Wing:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="division" id="division" placeholder="Division" readonly required>                  
                </div>
            </div> 

                   
         <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="appointment">&nbsp;&nbsp;&nbsp;Appointment date:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="appointment" id="appointment" placeholder="" autocomplete="off"  readonly required>                  
                </div>
            </div>


            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="basicpay">&nbsp;&nbsp;&nbsp;Basic Pay:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="basicpay" id="basicpay" placeholder="basicpay" autocomplete="off" readonly required>                  
                </div>
            </div>
           
            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="empstatus">&nbsp;&nbsp;&nbsp;Emp Status:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="empstatus" id="empstatus" placeholder="active/inactive" autocomplete="off" readonly required>                  
                </div>
            </div>

            
            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="lastdop">&nbsp;&nbsp;&nbsp;Last dop:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="lastdop" id="lastdop" placeholder="lastdop" autocomplete="off" readonly required>                  
                </div>
            </div>
            
            <!-- <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="resignationtype">&nbsp;&nbsp;&nbsp;Resignation Type:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="resignationtype" id="resignationtype" placeholder="resignationtype" autocomplete="off" readonly required>                  
                </div>
            </div>

            <input type="hidden" class="form-control" name="resignationtypeId" id="resignationtypeId" placeholder="grade" autocomplete="off" readonly required>                  

            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="resignationdate">&nbsp;&nbsp;&nbsp;Resignation Date:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="resignationdate" id="resignationdate" placeholder="resignationdate" autocomplete="off"  readonly required>                  
                </div>
            </div> -->

            
            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="employmenttype">&nbsp;&nbsp;&nbsp;Employment Type:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="employmenttype" id="employmenttype" placeholder="employmenttype" autocomplete="off" readonly required>                  
                </div>
            </div>

            
            <div class="form-group row"> 
              <label class="col-md-4 col-form-label text-md-right" for="incrementcycle">&nbsp;&nbsp;&nbsp;Increment Cycle:</label>
                <div class="col-sm-10 col-md-6 col-lg-4">
                <input type="text" class="form-control" name="incrementcycle" id="incrementcycle" placeholder="incrementcycle" autocomplete="off" readonly  required>                  
                </div>
            </div>       


    
         <!-- ok -->

         <div class="notice">
          <!-- <p style="font-size:20px" > <b> *You are kindly requested to vacate the meeting room, if CEO wants to have a meeting.</b></p></div> -->
           <div class="form-group row mb-0" >
              <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12 ">
                <button type="submit" id="book" class="btn nSuccess btn-lg">Update details</button>
                &nbsp;&nbsp;
                <button type="submit" id="book" class="btn nSuccess btn-lg"><a href="cd/twimc.php?EID={{Auth::user()->empId}}" >Download TWIMC</a></button>
              </div> 
              <br>
              <br>
              <br> <br>
              
        </div>   
       
           
          </form>
        
      </div> <!--/card-body-->
      <footer class="text-muted main-footer" style="text:center"><br>
      <div  class="d-flex justify-content-center">
      <!-- &nbsp;&nbsp;<p style="text-align:center"><h4>Please contact Front Desk (02 325095/322226) to cancel your booking</strong></h4> -->
   
</div>
</footer>
      </div>

     


  
</div>

<script type="text/javascript">
  


$(document).ready(function() {
  $a= document.getElementById('emp_id').value;
  getEmployeeDetails($a);




    $('#myTable').DataTable( {
        "pagingType": "simple_numbers",
        "ordering": false


    } );


} );

       




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
          $.get('/getValues?source=user_profile&info='+val+'&token='+csrftoken,function(data){              
                    console.log(data);
                  
                    document.getElementById('nameid').value = '';                      
                    document.getElementById('contact_number').value = '';
                    document.getElementById('fixed').value = '';
                    document.getElementById('extension').value = '';
                    document.getElementById('division').value =  '';
                                
                    document.getElementById('dob').value = '';                      
                    document.getElementById('cid').value = '';
                    // document.getElementById('blood').value =  '';
                    document.getElementById('designation').value =  '';
                    document.getElementById('grade').value = '';   
                    document.getElementById('appointment').value = '';                      
                    document.getElementById('basicpay').value = '';
                    document.getElementById('empstatus').value =  '';
                    document.getElementById('lastdop').value =  '';
                    document.getElementById('emailid').value = '';   
                    document.getElementById('office').value = '';                      
                    // document.getElementById('resignationtype').value =  '';
                    // document.getElementById('resignationdate').value = '';  
                    // document.getElementById('qualification').value = '';    
                    document.getElementById('employmenttype').value = '';                      
                    document.getElementById('incrementcycle').value = '';
                    
                   
                    document.getElementById('empid').value = '';                        



                    
                $.each(data, function(index, Employee){


                          if(Employee.empId != null)
                          {

                           
                            document.getElementById('nameid').value = Employee.empName;                      
                                document.getElementById('contact_number').value = Employee.mobileNo;
                                document.getElementById('fixed').value = Employee.fixedNo;
                                document.getElementById('extension').value = Employee.extension;
                                document.getElementById('division').value =  Employee.shortOfficeName;
                                           
                                document.getElementById('emp_id').innerHTML= Employee.empId;                    
                    document.getElementById('dob').value = Employee.dob;                      
                    document.getElementById('cid').value = Employee.cidNo; 
                    // document.getElementById('blood').value =  Employee.bloodGroup; 
                    document.getElementById('designationId').value =  Employee.designationId; //pulls id from desination master
                    document.getElementById('designation').value =  Employee.desisNameLong; 
                  
                    document.getElementById('grade').value = Employee.grade;
                    document.getElementById('gradeId').value = Employee.gradeId; 
                    document.getElementById('empstatus').value = Employee.empStatus;    
   

                    document.getElementById('appointment').value = Employee.appointmentDate;                       
                    document.getElementById('basicpay').value = Employee.basicPay; 
                    document.getElementById('lastdop').value =  Employee.lastDop; 
                    document.getElementById('emailid').value = Employee.emailId;    
                    //  document.getElementById('placeId').value = Employee.id;  //pulls id of officedetailss table
                    document.getElementById('office').value = Employee.office; //pulls id from users table                      
                    // document.getElementById('bankname').value = Employee.bankName; 
                    // document.getElementById('qualification').value = Employee.qualificationName;
                    // document.getElementById('accountnumber').value =  Employee.accountNumber; 
                    // document.getElementById('resignationtype').value =  Employee.resignationType; 
                    // document.getElementById('resignationtypeId').value =  Employee.resignationTypeId; 
                    // document.getElementById('resignationdate').value = Employee.resignationDate;    
                    document.getElementById('employmenttype').value = Employee.employmentType;                       
                    document.getElementById('incrementcycle').value = Employee.incrementCycle; 
                 
                        
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

<!-- <style>

.glyphicon glyphicon-trash{
  text:'RESET';
}


</style> -->


<!-- changes -->

@endsection
<!-- nima -->



  
      




