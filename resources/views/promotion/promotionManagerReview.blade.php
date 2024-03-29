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
                <b> Promotion Review by Manager </b>
              </h5>
			</div>
		
      </div><br>

      <form method="POST" action="/recommendpromotion" enctype="multipart/form-data"  accept-charset="UTF-8" > @csrf
        <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
        <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >

        <div class="card-body table-responsive p-0">
          <table id="example1" class="table table-hover table-striped table-bordered">
            <thead> 
              <tr>
              <th>Id</th> 
              <th>Promotion Year</th>
              <th>Promotion Month</th>
              <th>Employee Id</th>
              <th>Employee Name</th>
              <th>From Grade</th>
              <th>To Grade</th>
              <th>Old Basic</th>
              <th>New Basic</th>
              <th>Office</th>
              <!-- <th>Reject Reason</th> -->
              <!-- <th>Status</th> -->
              <th >Recommend</th>
              <th >Reject</th>
              </tr>  
            </thead>
            <tbody>
		      	@foreach($promotionRequest as $rv)
		
              <tr class="text-nowrap">
                  <td> {{($rv->id)}} </td>      
                  <td> {{$rv->promotionYear}} </td>   
                  <td> {{($rv->promotionMonth)}} </td>    
                  <td> {{$rv->empId}} </td>   
                  <td> {{$rv->empName}} </td>       
			            <td> {{$rv->fGrade}} </td>   
                  <td> {{$rv->tGrade}} </td>  
                  <td> {{$rv->oldBasic}} </td>   
                  <td> {{$rv->newBasic}} </td>  
                  <td> {{$rv->longOfficeName}} </td> 
                  <!-- <td> {{$rv->rejectReason}} </td>      -->
                  <!-- <td> {{$rv->status}} </td> -->
                  <td >
                    <div class="container">
                      <div class="row">
                        <div class="col ">
                            <form method="POST" action="/recommendpromotion" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf         
                                                
                            <!-- <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >-->
                          <input type="hidden" name="status" id="status" value="Recommended">               
                            <button type="submit" name="id[]" id="id" onclick="return confirm('Do you want to recommend and forward?');" value="{{$rv->id}}" class="btn btn-outline-info text-dark col-lg-12 mb-4 btn-center " > 
                            Recommend
                            </button>
                            <!-- <input type="text"  name="remarks" class="form-control" id="remarks" placeholder="recommend remarks">               -->
                            </form>
                        </div>
                      </div>
                    </div>   
                  </td> 
                  <td>
                  <div class="container">
                      <div class="row">
                        <div class="col">     
                          <form method="POST" action="/recommendpromotion" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf    
                   
                          <!-- <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" > -->
                          <input type="hidden" name="status2" id="status" value="Rejected" required>                                 
                          <button type="submit" name="id[]" id="id" onclick="return confirm('Do you want to Reject?');" value="{{$rv->id}}" class="btn btn-outline-danger text-dark col-lg-12 mb-4 btn-center " > 
                          Reject
                          </button> </br>
                          <textarea type="text"  name="remarks2" class="form-control" id="remarks2" placeholder=" Reject Remarks" required>        </textarea>
                          </form>
                        </div>
                      </div>
                  </div>
                  </td>	
                </tr>
            </tbody>
			  <!-- <tr><th style="border-bottom:4px solid black;">Action</th> <td  style="border-bottom:4px solid black;"> -->
       @endforeach
      </table>	     
      <div>
        <!--/card-body-->
       
      </div>
      </div>
    </div>
    <script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
		});
		</script>
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
    