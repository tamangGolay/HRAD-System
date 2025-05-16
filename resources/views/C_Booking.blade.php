<!-- Stored in resources/views/pages/dispatch.blade.php -->
@extends('layouts.masterstartpage')
@section('pagehead')
<!-- c_booking -->

<style>
 .topicConference{
    font-family: "Times New Roman", Times, serif;
    font-size: 30px;
  }
</style>

<div class="container-fluid" style="width: 100%; display:table">
  <div style="display:table-row">

    <div class="col-sm-6" style="width:58%; display: table-cell">
      <ol class="breadcrumb float-sm-left">


        <li class="breadcrumb-item"><a href="/tracking">Track Status</a></p>
        </li>
        <li class="breadcrumb-item"><a href="#"></a></li>

      </ol>
    </div>
    <div class="col-sm-6" style="display: table-cell">
      <ol class="breadcrumb float-sm-right">


        <li class="breadcrumb-item"><a href="/admin">Login</a></p>
        </li>
        <li class="breadcrumb-item"><a href="#"></a></li>

      </ol>
    </div>
  </div>
</div><!-- /.container-fluid -->
@endsection



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
<div style="font-size:20px" class="alert alert-danger">
  <strong> {{ session()->get('error1') }}</strong>
</div>
@endif


@if(session()->has('fail'))
<div style="font-size:20px" class="alert alert-danger">
  <strong> {{ session()->get('fail') }}</strong>
</div>
@endif



<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<link href="{{asset('css/bose.css')}}" rel="stylesheet">

<!-- c_booking -->
<script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>

<div class="container-fluid">
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header small-box bg-green d-flex justify-content-center">
        <div class="card-title topicConference">
          <h4><strong>Booked Conference Details</strong></h4>
        </div>
      </div>

      <div class="card-body table-responsive">
        <table id="myTable" class="table table-hover table-striped  table-bordered">

          <thead>
            <tr>
              <th style="width:10px">No</th>
              <th class="text-nowrap">Name</th>
              <th class="text-nowrap">Office Name</th>
              <th class="text-nowrap">Contact No.</th>
              <th class="text-nowrap">Conference Name</th>
              <th class="text-nowrap">Meeting Name</th>
              <th class="text-nowrap">Start Date and Time</th>
              <th class="text-nowrap">End Date and Time</th>

            </tr>
          </thead>

          @foreach($c_book as $fv)
          <tr>

            <td> {{($fv->id) - 5}}           </td>

            <td> {{$fv->name}}            </td>


            <td> {{$fv->officeDetails}}            </td>
            <td>  {{$fv->contact_number}}            </td>

            <td class="text-nowrap">              {{$fv->Conference_Name}}            </td>

            <td>              {{$fv->meeting_name}}            </td>
            <td class="text-nowrap">              {{date("Y-m-d h:i A",strtotime($fv->start_date))}}            </td>


            <td class="text-nowrap">              {{date("Y-m-d h:i A",strtotime($fv->end_date))}}            </td>

          </tr>
          @endforeach
          </tbody>
        </table>
        <div class="float-right"> {{$c_book->links()}} </div>

      </div>
    </div>
  </div>
</div>
</div>

<div class="container-fluid">
<div class="row">
  <div class="col">
    <div class="card card-green ">      
        <div class="col bg-green d-flex justify-content-center topicConference">
          <h4><strong>Booking Form</strong></h4>
        </div>
      
      <br>

      <form method="POST" action="/conferencebook" enctype="multipart/form-data" accept-charset="UTF-8">
        @csrf

      <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">

      <div class="cardbody">
      <!-- emp id -->
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right" for="user">&nbsp;&nbsp;&nbsp;Employee Id:</label>
            <div class="col-sm-10 col-md-6 col-lg-4">
              <input type="number" onKeyPress="if(this.value.length==8) return false;              
                    
                    if( isNaN(String.fromCharCode(event.keyCode))) return false;" 
                class="form-control" value="{{ old('empId') }}" autocomplete="off" name="empId" id="empId" placeholder="Employee Id"

                onKeyup="

					 if(this.value.length==8 || this.value[0] != 3)
					 getEmployeeDetails(this.value)
					 if(this.value[0] == 3)
					 record (this.value);" required>

            </div>
            <div class="col-sm-2">
              <span id="empid" class="text-danger"></span>
            </div>
          </div>

          <!-- name -->
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right" for="nameid">&nbsp;&nbsp;&nbsp;Name:</label>
            <div class="col-sm-10 col-md-6 col-lg-4">
              <input type="text" name="name" class="form-control" id="nameid" placeholder="Name" readonly required>
            </div>
          </div>

          <!-- office name -->
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right" for="division">&nbsp;&nbsp;&nbsp;Office Name:</label>
            <div class="col-sm-10 col-md-6 col-lg-4">
              <input type="text" class="form-control" name="division" id="division" placeholder="Division" readonly required>
            </div>
          </div>


          <input type="hidden" class="form-control" name="divisionh" id="divisionh" placeholder="Division" readonly required>

          <!-- contact no -->
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right" for="contact_number">&nbsp;&nbsp;&nbsp;Contact number:</label>
            <div class="col-sm-10 col-md-6 col-lg-4">
              <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Contact Number" readonly required>
            </div>
          </div>

          <!-- meeting name -->
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Meeting Name:</label>
            <div class="col-sm-10 col-md-6 col-lg-4">
              <input type="text" class="form-control" name="meeting_name" id="meeting_name" placeholder="Meeting Name" autocomplete="off" required>
            </div>
          </div>
        
          <!-- no of people range -->
          <div class="textfont form-group row">
            <label class="col-sm-4 col-form-label text-md-right " for="no_of_people">&nbsp;&nbsp;&nbsp;Number of people:</label>
            <div class=" col-sm-10 col-md-6 col-lg-4">
             
              <select class="form-control" name="no_of_people90" id="no_of_people90" required>
                <option value="">Select range of people</option>
                @foreach($no_of_people90 as $no_of_people90)
                <option name="no_of_people90" value="{{$no_of_people90->id}}">{{$no_of_people90->range}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- conference name -->
          <div class="textfont form-group row">
            <label class="col-sm-4 col-form-label text-md-right " for="conference">Conference Name:</label>
            <div class="col-sm-10 col-md-6 col-lg-4">
              <select class="form-control" name="conference" id="conference" required>
              </select>
            </div>
          </div>

          <!-- start date -->
          <div class="form-group row">
            <label for="dtpickerdemo" class="col-md-4 col-form-label text-md-right">&nbsp;&nbsp;&nbsp;Start date and time:</label>
            <div class="col-sm-10 col-md-6 col-lg-4 input-group date px-4" id="dtpickerdemo">
              <input type="text" class="form-control" name="start_date" placeholder="yyyy/mm/dd hh:mm" autocomplete="off" required />
              <span class="input-group-addon">

                <span class="glyphicon glyphicon-calendar"></span>
              </span>

            </div>
          </div>

              <!-- END date -->
          <div class="form-group row">
            <label for="dtpickerdemo2" class="col-md-4 col-form-label text-md-right"> &nbsp;&nbsp;&nbsp;End date and time:</label>
            <div class="col-sm-10 col-md-6 col-lg-4 input-group date px-4" id='dtpickerdemo2'>
              <input type="text" class="form-control" name="end_date" placeholder="yyyy/mm/dd hh:mm" autocomplete="off" required />
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
          <!-- ok -->

          <div class="notice">
            <p style="font-size:15px"> <b> *You are kindly requested to vacate the meeting room, if CEO wants to have a meeting.</b></p>
          </div>

          <div class="form-group row mb-3">
            <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12 ">
              <button type="submit" id="book" class="btn nSuccess btn-lg topicConference">Book Now</button>
            </div>             
          </div>
          </div>   <!--/card-body-->
      </form>

       
    <footer class="text-muted main-footer" style="text-align:center">   
    <div  class="d-flex justify-content-center">
      <p style="text-align:center">
        <h5>Please contact Front Desk (02 325095/322226) to cancel your booking.</h5>
   
    </div>
    </footer>
  
      </div> 
    </div> 
</div> 
</div>

<script type="text/javascript">

$(document).ready(function() {
    $('#myTable').DataTable( {
     // dom: "Blfrtip",
        "pagingType": "simple_numbers",
        "ordering": false,
        "aLengthMenu": [
                    [7, 20, 40,60, 100],
                    [7, 20, 40,60, 100]
                  ],        
    } );
} );

	$(function () {
            $('#dtpickerdemo2').datetimepicker();
            $('#dtpickerdemo').datetimepicker();
            $("#dtpickerdemo2").on("dp.change", function (e) {
                // $('#dtpickerdemo2').data("DateTimePicker").minDate(e.date);                               
            });
            $("#dtpickerdemo").on("dp.change", function (e){
                
                $('#dtpickerdemo2').data("DateTimePicker").minDate(e.date);
            });        
          });      

$('#dtpickerdemo').datetimepicker({
  format:'YYYY-MM-DD hh:mm A',

      toolbarPlacement: "bottom",       
    
       showClear:true,
       focusOnShow:false,   

       sideBySide:true,
       minDate:new Date(),
  
         stepping: 15,
         showClose:true,
          
   });

 
$('#dtpickerdemo2').datetimepicker({
  format:'YYYY-MM-DD hh:mm A',
  toolbarPlacement: "bottom",
       
       focusOnShow:false,
    
       showClear:true,

      sideBySide:true,
       minDate:new Date(),
  
         stepping: 15,
         showClose:true,
});

  $(document).ready(function() {
  $("#dtpickerdemo").on("dp.show", function(e) {
    $('.OK').html("OK");
  });
});


$(document).ready(function() {
  $("#dtpickerdemo").on("dp.show", function(e) {
    $('.RESET').html("RESET");
  });
});

$(document).ready(function() {
  $("#dtpickerdemo2").on("dp.show", function(e) {
    $('.OK').html("OK");
  });
});

$(document).ready(function() {
  $("#dtpickerdemo2").on("dp.show", function(e) {
    $('.RESET').html("RESET");
  });
});

function record()
	{
		if(document.getElementById('empId').value[0] == '3' ){

		document.getElementById('empid').innerHTML = '';                        

		}
	}

function getEmployeeDetails(val)
{

    //pulling records using cid from checkin table 
      var csrftoken =document.getElementById('tokenid').value;
          $.get('/getValues?source=C_Booking&info='+val+'&token='+csrftoken,function(data){              
                    //console.log(data);
                  
                    document.getElementById('nameid').value = '';                      
                    document.getElementById('contact_number').value = '';
                    document.getElementById('division').value =  '';
                    document.getElementById('divisionh').value =  '';
                    document.getElementById('empid').innerHTML = '';                        
                    
                $.each(data, function(index, Employee){


                          if(Employee.empName != null)
                          {
                              document.getElementById('nameid').value = Employee.empName;                      
                                document.getElementById('contact_number').value = Employee.mobileNo;
                                document.getElementById('division').value =  Employee.officeDetails;
                                document.getElementById('divisionh').value =  Employee.office;

                            
                             
                                document.getElementById('empId').innerHTML='';
                        }				


                            
                            else {
                                document.getElementById('empid').innerHTML = 'Please check your Employee ID!!!';  
								// document.getElementById('emp_id').value='';
                    
                            }                       
                                                         
                            
                })
        });
      
  

}  
$('div.alert').delay(6500).slideUp(300);// Session message  display time


$("#no_of_people90").on('change',function(e){
           console.log(e);
            var id = e.target.value;
            var csrftoken = document.getElementById('tokenid').value;
            $.get('/getValues?source=people&info='+id+'&token='+csrftoken,function(data){              
               // console.log(data);
                 $('#conference').empty();               
                  $.each(data, function(index, facility){
                      $('#conference').append('<option value="'+facility.id+'">'+facility.Conference_Name+'</option>');   
                  })

              
               
            });
    });


</script>
      @endsection