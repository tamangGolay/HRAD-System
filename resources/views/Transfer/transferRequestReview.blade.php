<div class="row ">
	<div class="col">
		<div class="card ">
			<div class="card-header bg-green">
				<div class="col text-center">
					<h5>
                <b>Transfer Request Review</b>
              </h5> </div>
			</div>
			
			<form method="POST" action="/" enctype="multipart/form-data"  accept-charset="UTF-8" > @csrf
      <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
     <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >

				<div class="card-body table-responsive p-0">
					<table id="table1" class="table table-hover table-striped table-bordered" style="width:95%;">
						<thead>
							<tr class="text-nowrap">
								<th>Sl No</th>
                <th>Emp Id </th>
								<th>From Office</th>
								<th>To Office</th>
								<th>Reason</th>															
								<th style="width:5%">Recommend</th>
								<th style="width:5%">Reject</th>
							</tr>
						</thead>
						<tbody>
							 @foreach($transferRequest as $rv)
							<tr>
								
                  <td>{{$rv->id}}</td>
                 <td>{{$rv->createdBy}}</td>
                 <td>{{$rv->fromOffice}}</td>
                  <td>{{$rv->toOffice}}</td>                 
                  <td>{{$rv->reason}}</td>
        

				<td>
					
					<form method="POST" action="/recommendTransfer" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf    
					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">    
                                                
					 <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >	
					<input type="hidden" name="status" id="status" value="recommended">  
					<button type="submit" name="id[]" id="id" onclick="return confirm('Do you want to recommend and forward?');" value="{{$rv->id}}" class="btn btn-outline-info text-dark col-lg-12 mb-4 btn-center " >Recommend</button>
		    	</form>
			</td>

			<td>
			<form method="POST" action="/recommendTransfer" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
			<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
			<input type="hidden" name="status2" id="status" value="rejected">  

			<button type="submit" name="id[]" id="id" onclick="return confirm('Do you want to reject?');" value="{{$rv->id}}" class="btn btn-outline-danger text-dark col-lg-12 mb-4 btn-center " >Reject</button>
				<div>
					<textarea name="rejectreason" id="reason" placeholder="reason for rejection"  required></textarea>		
					</div>
          </form> </td>
			
      </tr>
			 @endforeach 
    </tbody>

			</table>
			
			<div>				

			</div>
			</div>
		</div>

		
		
		<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center></strong>';
		});
		</script>
		<!-- jquery-validation -->
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

		
		<link href="{{asset('css/bose.css')}}" rel="stylesheet"> 
		<!-- called in bose.css -->

		<script>
	
		$(function() {
			$("#table1").DataTable({
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