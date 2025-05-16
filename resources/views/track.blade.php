<?php
header('X-Frame-Options: SAMEORIGIN');
?>
@extends('layouts.masterdefault')
@section('title', 'Login')
@section('content')

<style>

.w-25{
  white-space:nowrap;
}

.cardTrack, .register-box {
    width: 90%;
 
}

.REG, .register-page {
    -ms-flex-align: center;
    align-items: center;
    
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    height: auto;
    -ms-flex-pack: center;
    justify-content: center;
    width:100%;
   
}
.card{
  margin-top:10%;
}

</style>



<div class="hold-transition REG">
    <div class="cardTrack">
            <div class="card">
                <div class="card-body">
                <div class="card-header bg-green">     
        <div class="d-flex justify-content-center" >Tracking Status </div>
      </div>
     
     <div class="card-body table-responsive p-0">    
                <table id="example1" class="table table-hover table-striped table-bordered">
                <thead >
                 <tr class="text-nowrap">  
                  <th>Booking _Id</th>
                  <th>Emp_id</th>
                  <th>Name</th>
               
                  <th>Contact_no</th>
                  <th width=15%>Wing/Dept/Div</th>
                  <th>Meeting Name</th>
                  <th>Conference Name</th>
                  <th class="w-25 ">Date and Time</th>                  
                  <th>Status</th>
                  <th>Reason</th>

                 </tr>
                </thead>
                <tbody>   
                    
            
                  @foreach($review as $rv) 

                
                  <tr>
                  <td>
                     {{$rv->id - 5}}
                    </td>
                 
                    <td>

                     {{$rv->emp_id}}
    
                    </td>
                    <td>
                     {{$rv->name}}
                    </td>
                    <td>
                     {{$rv->contact_number}}
                    </td>
                    <td>
                     {{$rv->officeDetails}}
                    </td>
                    
                    <td>
                     {{$rv->meeting_name}}
                    </td>
                    <td>
                     {{$rv->Conference_Name}}
                    </td>
                    
                    
                    <td>

                    {{date("Y-m-d h:i A",strtotime($rv->start_date))}}

                    <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;to
                    <br>

                    {{date("Y-m-d h:i A",strtotime($rv->end_date))}}
                    </td>

                                       
                    <td style="width:40%">

                    @if($rv->status=='0' && ($rv->conference_id ==1 ) )

                      <strong style="color:red">  Pending </strong>

                    @elseif($rv->status == '1' && ($rv->conference_id != 1 ) )

                    <strong style="color:red"> cancelled  </strong>  
                  
                    @elseif($rv->status == '2' && ($rv->conference_id == 1 ) )
                    
                    <strong style="color:red"> Cancelled </strong>  


                    @else
                      
                    <strong style="color:green">  Approved </strong>

                    
                    @endif
                   
              
                    </td>
                    <td style="width:40%">

                    {{$rv->reason}}
                   </td>

                  </tr>

               
                  @endforeach
                 </tbody>
                 </table>
            </div>
      
         <div class="float-right">
                {{$review->links()}}
         </div>
        
      <div> <!--/card-body-->

              
            </div>
        </div>

     



      

@endsection
