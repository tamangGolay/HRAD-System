@extends('layout')
  
@section('content')
<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header bg-success text-center text-white"><h5>Reset Password</h5></div>
                  <div class="card-body">
  
                    @if (Session::has('message'))
                         <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
  
                      <form action="{{ route('forget.password.post') }}" method="POST">
                          @csrf
                          <div class="form-group row">
                          <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
                          <label for="email_address" class="col-md-4 col-form-label text-md-right">Employee Id</label>
                              <div class="col-md-6 mb-3">
                                  <!-- <input type="text" id="emp_id" class="form-control" name="emp_id" required autofocus> -->
                                  <input type="number" class="form-control" onKeyPress="if(this.value.length==8) return false; 
                
                    
                    if( isNaN(String.fromCharCode(event.keyCode))) return false;" name="empid" id="empid" placeholder="Employee Number" 
					
					onKeyup="

				if(this.value.length==8)
				getEmployeeDetails(this.value);"
					required>
                              </div>

                              <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                              <div class="col-md-6 ">
                                  <input type="text" id="email" class="form-control" name="email" readonly>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div> 
                            
                          </div>
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-success" onClick="return empty()">
                                  Reset Password
                              </button>
                          </div>
                      </form>
                        
                  </div>
              </div>
          </div>
      </div>
  </div>

</main>
@endsection



<!-- jQuery -->
<script src="{{asset('/admin-lte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/admin-lte/dist/js/adminlte.min.js')}}"></script> 

<script>
function empty() {
    var x;
    x = document.getElementById("email").value;
    if ((x == "" ) || (x =='e')){
        alert("You are not a valid user");
        return false;
    };
}

</script>
<script>

     function getEmployeeDetails(val)
{

    //pulling records using cid from checkin table 
      var csrftoken =document.getElementById('tokenid').value;
          $.get('/getValues?source=C_Booking&info='+val+'&token='+csrftoken,function(data){              
                    console.log(data);
                  
                    document.getElementById('email').value = '';                      
                    document.getElementById('empid').innerHTML = '';                        
                    
                $.each(data, function(index, Employee){


                          if(Employee.name != null)
                          {
                              document.getElementById('email').value = Employee.email;                      
                                document.getElementById('empid').innerHTML='';
                          }
                            else {
                                document.getElementById('empid').innerHTML = 'Please check your Employee ID!!!';  
								// document.getElementById('emp_id').value='';
                            }                       
                                                         
                });
        });
}
</script>
