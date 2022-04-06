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
                <label class="col-md-4 col-form-label text-md-right" for="division">&nbsp;&nbsp;&nbsp;Div/Dept/Wing:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                    <input type="text" class="form-control" name="division" id="division" placeholder="Division" readonly required>                  
                    </div>
                </div> 
                <input type="hidden" class="form-control" name="divisionh" id="divisionh" placeholder="Division" readonly required>                  
            
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
                        <select name="pant" id="" class="form-control"><option >Select Pant Size</option>
                            <option >S</option>
                            <option >M</option>
                            <option >L</option>
                            <option >XL</option>
                            <option >2XL</option>
                            <option >3XL</option>
                            <option >4XL</option>
                            <option >5XL</option>
                            <option >6XL</option>
                        </select>                 
                    </div>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="2" name="shirt_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Shirt Size:</label>
                        <div class="col-sm-10 col-md-6 col-lg-4">
                            <select name="shirt" id="" class="form-control"><option >Select Shirt Size</option>
                                <option >S</option>
                                <option >M</option>
                                <option >L</option>
                                <option >XL</option>
                                <option >2XL</option>
                                <option >3XL</option>
                                <option >4XL</option>
                                <option >5XL</option>
                            </select>                  
                        </div>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="3" name="jacket_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Jacket Size:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                        <select name="jacket" id="" class="form-control"><option >Select Jacket Size</option>
                            <option >S</option>
                            <option >M</option>
                            <option >L</option>
                            <option >XL</option>
                            <option >2XL</option>
                            <option >3XL</option>
                            <option >4XL</option>
                            <option >5XL</option>
                        </select>                 
                    </div>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="4" name="shoe_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Shoe Size:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                        <select name="shoe" id="" class="form-control"><option >Select Shoe Size</option>
                            <option >3</option>
                            <option >4</option>
                            <option >5</option>
                            <option >6</option>
                            <option >7</option>
                            <option >8</option>
                            <option >9</option>
                            <option >10</option>
                            <option> 11</option>
                            <option >12</option>
                            <option >13</option>
                            <option >14</option>
                            <option >15</option>
                        </select>                  
                    </div>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="5" name="jumboot_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Jumboot Size:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                        <select name="jumboot" id="" class="form-control"><option >Select Jumboot Size</option>
                            <option >3</option>
                            <option >4</option>
                            <option >5</option>
                            <option >6</option>
                            <option >7</option>
                            <option >8</option>
                            <option >9</option>
                            <option >10</option>
                            <option> 11</option>
                            <option >12</option>
                            <option >13</option>
                            <option >14</option>
                            <option >15</option>
                        </select>                  
                    </div>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="6" name="raincoat_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Raincoat Size:</label>
                        <div class="col-sm-10 col-md-6 col-lg-4">
                            <select name="raincoat" id="" class="form-control"><option >Select Raincoat Size</option>
                                <option >S</option>
                                <option >M</option>
                                <option >L</option>
                                <option >XL</option>
                                <option >2XL</option>
                                <option >3XL</option>
                                <option >4XL</option>
                                <option >5XL</option>
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
          $.get('/getValues?source=userdetails&info='+val+'&token='+csrftoken,function(data){              
                    console.log(data);
                    document.getElementById('nameid').value = '';                      
                    document.getElementById('contact_number').value = '';
                    document.getElementById('division').value =  '';
                    document.getElementById('divisionh').value =  '';
                    document.getElementById('empid').innerHTML = '';                        
                
                $.each(data, function(index, Employee){
                    if(Employee.name != null)
                    {
                        document.getElementById('nameid').value = Employee.name;                      
                        document.getElementById('contact_number').value = Employee.contact_number;
                        document.getElementById('division').value =  Employee.description;
                        document.getElementById('divisionh').value =  Employee.org_unit_id;
                        document.getElementById('emp_id').innerHTML='';
                    }				
                    else 
                    {
                        document.getElementById('empid').innerHTML = 'Please check your Employee ID!!!';  
				    }                       
                })
            });
}  
$('div.alert').delay(4500).slideUp(300);// Session message  display time
</script>

<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
		});
		</script>







  
      




