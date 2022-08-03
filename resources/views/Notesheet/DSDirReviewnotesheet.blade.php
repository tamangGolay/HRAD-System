<style>
hr{
  border: 2px solid green;
  border-radius: 5px;
}

</style>
<div class="row ">
  <div class="col">
    <div class="card ">
      <div class="card-header bg-green">
        <div class="col text-center">
          <h5>
                <b> Note Sheet Review DS</b>
              </h5>
			</div>
		
      </div><br>
	  
      <form method="POST" action="/directorrecommendnotesheet" enctype="multipart/form-data"  accept-charset="UTF-8" > @csrf
        <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
        <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >

        <div class="card-body table-responsive p-0">
          <table id="example1" class="table table-hover table-striped table-bordered">
            <thead> <tbody>
			@foreach($notesheetRequest as $rv)
			
              <tr class="text-nowrap">
                     <th>Note Id</th>          <td> {{($rv->id)}} </td>      </tr>
              <tr>   <th>Created By</th>       <td> {{$rv->createdBy}} </td>     </tr>
              <tr>   <th>office Name</th>        <td> {{($rv->longOfficeName)}} </td>    </tr>
              <!-- <tr>   <th>Topic</th>            <td> {{$rv->topic}} </td>         </tr> -->
			        <tr>   <th>Justification</th>    <td> {{$rv->justification}} </td> </tr>  
        

      <!-- <tr>   <th>Remarks</th> <td><input type="text"  name="remarks[]" class="form-control" id="remarks" placeholder="Topic">
     </td>  </tr>  -->
                           
			  <tr> <th>Status</th> <td> {{$rv->status}} </td>  </tr>

        <tr><th colspan="2">Action</th> </tr>
              <tr ><th colspan="2" >
              <div class="container">
                <div class="row">
                  <div class="col ">        
                    <form method="POST" action="/directorrecommendnotesheet" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf         
                     <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
                      <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >
                      <input type="hidden" name="status" id="status" value="DirectorRecommended">
                      <input type="text"  name="remarks" class="form-control" id="remarks" placeholder="recommend remarks">
                      <button type="submit" name="id[]" id="id" onclick="return confirm('Do you want to recommend and forward?');" value="{{$rv->id}}" class="btn btn-outline-info text-dark col-lg-4 mt-4 btn-center " > 
                      Recommend
                      </button> 
                    </form>
                  </div>

                  <div class="col "> 
                    <form method="POST" action="/directorrecommendnotesheet"  enctype="multipart/form-data" accept-charset="UTF-8"> @csrf   
                    <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">      
                      <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >
                      <input type="hidden" name="status" id="status" value="Approved">
                      <input type="text" name="remarks1" class="form-control" id="remarks1" placeholder="Approve Remarks">
                      <button type="submit" name="id[]" id="id"  onclick="return confirm('Do you want to Approve?');" value="{{$rv->id}}" class="btn btn-outline-success text-dark col-lg-4 mt-4 btn-center " > 
                      Approve
                      </button> 
                    </form>
                  </div>
     
                  <div class="col ">
                    <form method="POST" action="/directorrecommendnotesheet"  enctype="multipart/form-data" accept-charset="UTF-8"> @csrf    
                    <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">     
                      <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >
                      <input type="hidden" name="status" id="status" value="Rejected">                   
                      <input type="text"  name="remarks2" class="form-control" id="remarks2" placeholder=" Reject Remarks" >
                      <button type="submit" name="id[]" id="id" onclick="return confirm('Do you want to Reject?');" value="{{$rv->id}}" class="btn btn-outline-danger text-dark col-lg-4 mt-4 btn-center" > 
                      Reject
                      </button>
                    </form>
                  </div>
                </div>
              </div> 
           </td> 	                 
        </tr>

        <tr>
          <th style="border-bottom:4px solid black;" colspan="2" >          
            <form method="POST" action="/supervisorApproval/{{($rv->id)}}"  enctype="multipart/form-data" accept-charset="UTF-8" class="text-center"> @csrf         
               @csrf
              <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
              <input type="submit" value="View Details" class="btn btn-primary text-center col-lg-3" >

            <!-- <input type="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> -->
            </form>
          </th>  
        </tr>
      </thead>  
      @endforeach
	   </tbody>
    </table>	  <div>
        <!--/card-body-->
       
      </div>
      </div>
    </div>


    




    <script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
    


<script src="{{asset('/admin-lte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('/admin-lte/plugins/jquery-validation/additional-methods.min.js')}}"></script>
    <!-- DataTables -->
    <script src="{{URL::asset('/admin-lte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <!-- Script for export file from datatable -->
    <script src="{{asset('/admin-lte/datatables/nima.js')}}"></script>
    <script src="{{asset('/admin-lte/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/admin-lte/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('/admin-lte/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{asset('/admin-lte/datatables/buttons.print.min.js')}}"></script>
    <!-- <script src="{{asset('/admin-lte/datatables/buttons.flash.min.js')}}"></script> -->
    <script src="{{asset('/admin-lte/datatables/jszip.min.js')}}"></script>
    <!-- <script src="{{asset('/admin-lte/datatables/pdfmake.min.js')}}"></script> -->
    <script src="{{asset('/admin-lte/datatables/vfs_fonts.js')}}"></script>
    <!-- checkin form -->
    <script>
    $(function() {
      $("#example1").DataTable({
        "dom": 'Bfrtip',
        "responsive": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "paging": true,
        "retrieve":true,
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5']
      });
    });
    </script>