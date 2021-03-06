<link href="{{asset('css/bose.css')}}" rel="stylesheet"> 
<div class="row"> 
    <div class="col">
        <div class="card card-green ">
            <div class="card-header bg-green">
                <div class="rvheading bg-green d-flex justify-content-center"><h3>Uniform</h3></div>
            </div><!--/card-header-->
      <br>
            <form method="POST" action="/uniform" enctype="multipart/form-data" accept-charset="UTF-8" >
                @csrf
                <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
                <!-- <input type="hidden" id="did" name="frId"> -->
                <div class="cardbody">
                
                <div class="form-group row"> 
                <label class="col-md-4 col-form-label text-md-right"  for="user">&nbsp;&nbsp;&nbsp;Employee Id:</label>              
                    <div class="col-sm-10 col-md-6 col-lg-4">
                        <input type="number" onKeyPress="if(this.value.length==8) return false; 
                        if( isNaN(String.fromCharCode(event.keyCode))) return false;"
                        class="form-control" value="{{ old('emp_id') }}"  autocomplete="off" name="emp_id" id="emp_id" placeholder="Employee Id" 
                        onKeyup="if(this.value.length==8 || this.value[0] != 3)
                        getEmployeeDetails(this.value)
                        if(this.value[0] == 3)
                        nima (this.value);" required>
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
                <label class="col-md-4 col-form-label text-md-right" for="office">&nbsp;&nbsp;&nbsp;Div/Dept/Wing:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                    <input type="text" class="form-control" name="office" id="office" placeholder="office" readonly required>                  
                    </div>
                </div> 
                <input type="hidden" class="form-control" name="officeId" id="officeId" readonly required>                  
            
            <div class="form-group row"> 
                <label class="col-md-4 col-form-label text-md-right" for="contact_number">&nbsp;&nbsp;&nbsp;Contact number:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                    <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Contact Number" readonly required>                  
                    </div>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="1" name="pant_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Pant Size:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                    <select class="form-control" name="pant" id="officeName" required>
                            <option value="">Select Size</option>
                            @foreach($pant as $pant)
                            <option value="{{$pant->id}}">{{$pant->pantSizeName}}</option>
                            @endforeach
                    </select>                 
                    </div>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="2" name="shirt_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Shirt Size:</label>
                        <div class="col-sm-10 col-md-6 col-lg-4">
                        <select class="form-control" name="shirt" id="officeName" required>
                            <option value="">Select Size</option>
                            @foreach($shirt as $shirt)
                            <option value="{{$shirt->id}}">{{$shirt->shirtSizeName}}</option>
                            @endforeach
                    </select>             
                        </div>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="3" name="jacket_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Jacket Size:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                    <select class="form-control" name="jacket" id="officeName" required>
                            <option value="">Select Size</option>
                            @foreach($jacket as $jacket)
                            <option value="{{$jacket->id}}">{{$jacket->sizeName}}</option>
                            @endforeach
                    </select>                
                    </div>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="4" name="shoe_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Shoe Size:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                    <select class="form-control" name="shoe" id="officeName" required>
                            <option value="">Select Size</option>
                            @foreach($shoe as $shoe)
                            <option value="{{$shoe->id}}">{{$shoe->ukShoeSize}}</option>
                            @endforeach
                    </select>                     
                    </div>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="5" name="jumboot_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Gumboot Size:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                    <select class="form-control" name="gumboot" id="officeName" required>
                            <option value="">Select Size</option>
                            @foreach($gumboot as $gumboot)
                            <option value="{{$gumboot->id}}">{{$gumboot->ukShoeSize}}</option>
                            @endforeach
                    </select>                   
                    </div>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="6" name="raincoat_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Raincoat Size:</label>
                        <div class="col-sm-10 col-md-6 col-lg-4">
                        <select class="form-control" name="raincoat" id="officeName" required>
                            <option value="">Select Size</option>
                            @foreach($raincoat as $raincoat)
                            <option value="{{$raincoat->id}}">{{$raincoat->sizeName}}</option>
                            @endforeach
                    </select>   
                        </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12 ">
                        <button type="submit" class="btn btn-outline-success btn-save" id="bsubmit">{{ __('Insert Record') }}</button>
                    </div>
                </div>   
                </div>
            </form>
        </div>    
    </div>
</div>

<script type="text/javascript">

function nima()
{
    if(document.getElementById('emp_id').value[0] == '3' ){

		document.getElementById('empid').innerHTML = '';                        

	}
}

function getEmployeeDetails(val)
{

       
    //pulling records using emp_id from users table 
      var csrftoken =document.getElementById('tokenid').value;
          $.get('/getValues?source=user_profile&info='+val+'&token='+csrftoken,function(data){              
                    console.log(data);         
    document.getElementById('nameid').value = '';                      
                    document.getElementById('contact_number').value = '';
                    // document.getElementById('fixed').value = '';
                    // document.getElementById('extension').value = '';
                    document.getElementById('office').value =  '';
                                
                    // document.getElementById('dob').value = '';                      
                    // document.getElementById('cid').value = '';
                    // // document.getElementById('blood').value =  '';
                    // document.getElementById('designation').value =  '';
                    // document.getElementById('grade').value = '';   
                    // document.getElementById('appointment').value = '';                      
                    // document.getElementById('basicpay').value = '';
                    // document.getElementById('empstatus').value =  '';
                    // document.getElementById('lastdop').value =  '';
                    // document.getElementById('emailid').value = '';   
                    // document.getElementById('office').value = '';                      
                    // // document.getElementById('resignationtype').value =  '';
                    // // document.getElementById('resignationdate').value = '';  
                    // // document.getElementById('qualification').value = '';    
                    // document.getElementById('employmenttype').value = '';                      
                    // document.getElementById('incrementcycle').value = '';
                    
                   
                    document.getElementById('empid').value = '';                        



                    
                $.each(data, function(index, Employee){


                          if(Employee.empId != null)
                          {

                           
                            document.getElementById('nameid').value = Employee.empName;                      
                                document.getElementById('contact_number').value = Employee.mobileNo;
                    //             document.getElementById('fixed').value = Employee.fixedNo;
                    //             document.getElementById('extension').value = Employee.extension;
                                document.getElementById('office').value =  Employee.shortOfficeName;
                                document.getElementById('officeId').value =  Employee.office;

                    //             document.getElementById('emp_id').innerHTML= Employee.empId;                    
                    // document.getElementById('dob').value = Employee.dob;                      
                    // document.getElementById('cid').value = Employee.cidNo; 
                    // // document.getElementById('blood').value =  Employee.bloodGroup; 
                    // document.getElementById('designationId').value =  Employee.designationId; //pulls id from desination master
                    // document.getElementById('designation').value =  Employee.desisNameLong; 
                  
                    // document.getElementById('grade').value = Employee.grade;
                    // document.getElementById('gradeId').value = Employee.gradeId; 
                    // document.getElementById('empstatus').value = Employee.empStatus;    
   

                    // document.getElementById('appointment').value = Employee.appointmentDate;                       
                    // document.getElementById('basicpay').value = Employee.basicPay; 
                    // document.getElementById('lastdop').value =  Employee.lastDop; 
                    // document.getElementById('emailid').value = Employee.emailId;    
                    // //  document.getElementById('placeId').value = Employee.id;  //pulls id of officedetailss table
                    // document.getElementById('office').value = Employee.office; //pulls id from users table                      
                    // // document.getElementById('bankname').value = Employee.bankName; 
                    // // document.getElementById('qualification').value = Employee.qualificationName;
                    // // document.getElementById('accountnumber').value =  Employee.accountNumber; 
                    // // document.getElementById('resignationtype').value =  Employee.resignationType; 
                    // // document.getElementById('resignationtypeId').value =  Employee.resignationTypeId; 
                    // // document.getElementById('resignationdate').value = Employee.resignationDate;    
                    // document.getElementById('employmenttype').value = Employee.employmentType;                       
                    // document.getElementById('incrementcycle').value = Employee.incrementCycle; 
                 
                        
                        }				


                            
                            else {
                                document.getElementById('empid').innerHTML = 'Please check your Employee ID!!!';  
								// document.getElementById('emp_id').value='';
  
                            }                       
                                                         
                            
                })
        });
      
  

}  
$('div.alert').delay(6500).slideUp(300);// Session message  display time


//     //pulling records using emp_id from users table 
//       var csrftoken =document.getElementById('tokenid').value;
//           $.get('/getValues?source=useruniformadd&info='+val+'&token='+csrftoken,function(data){              
//                     console.log(data);
//                     document.getElementById('nameid').value = '';                      
//                     document.getElementById('contact_number').value = '';
//                     document.getElementById('division').value =  '';
//                     document.getElementById('divisionh').value =  '';
//                     document.getElementById('empid').innerHTML = '';                        
                
//                 $.each(data, function(index, Employee){
//                     if(Employee.empName != null)
//                     {
//                         document.getElementById('nameid').value = Employee.empName;                      
//                         // document.getElementById('contactNumber').value = Employee.contactNumber;
//                         document.getElementById('division').value =  Employee.longOfficeName;
//                         // document.getElementById('divisionh').value =  Employee.office;
//                         // document.getElementById('emp_id').innerHTML='';
//                     }				
//                     else 
//                     {
//                         document.getElementById('empid').innerHTML = 'Please check your Employee ID!!!';  
// 				    }                       
//                 })
//             }); 


// 	// //pulling records using cid from checkin table 
// 	// var csrftoken = document.getElementById('tokenid').value;
// 	// $.get('/getValues?source=useruniformadd&info=' + val + '&token=' + csrftoken, function(data) {
// 	// 	console.log(data);
// 	// 	// document.getElementById('nameid').value =  '';
// 	// 	document.getElementById('empid').innerHTML = '';
// 	// 	$.each(data, function(index, Employee) {
// 	// 		if(Employee.empId != null) {                  
// 	// 			document.getElementById('empid').innerHTML = 'Record already exist for this employee!!';
// 	// 			document.getElementById('emp_id').value = '';
// 	// 		}
// 	// 	})
// 	// });


// }  
// $('div.alert').delay(4500).slideUp(300);// Session message  display time
</script>

<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
		});

        
		</script>







  
      




