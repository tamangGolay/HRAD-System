<div class="row ">
	<div class="col">
		<div class="card ">
			<div class="card-header bg-green">
				<div class="col text-center">
					<h5>
                <b>Employee Joining</b>
              </h5> </div>
			</div>
			
			
	<form method="POST" action="/updateTransferHistory" enctype="multipart/form-data"  accept-charset="UTF-8" > @csrf
     <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
     <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >

	
				<div class="card-body table-responsive p-0">
					<table id="table1" class="table table-hover table-striped table-bordered" style="width:95%;">
						<thead>
							<tr class="text-nowrap">
								<th>Sl.No</th>
                                <th>Emp Id </th>
								<th>From Office</th>
								<th>To Office</th>																						
								<th style="width:15%">Joining Date</th>
								
							</tr>
						   </thead>
						  <tbody>
					@foreach($empJoining as $empJoining)
			    <tr>					
				<td>{{$empJoining->id}}</td>
                <td>{{$empJoining->empId}}</td>
                <td>{{$empJoining->transferFrom}}</td>
                <td>{{$empJoining->transferTo}}</td>    
                    
				<td>
               <form method="POST" action="/updateTransferHistory" enctype="multipart/form-data"  accept-charset="UTF-8" > @csrf
      
					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}"> 
					<input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >						
					<input type="hidden" class="form-control" id="joiningAcceptedOn" name="joiningAcceptedOn" required readonly> 				   
					<input type="date" class="form-control" id="joinedOn" name="joinedOn" required>
				    
					<button type="submit" name="id[]" id="id" onclick="return confirm('Are you sure the joining date is correct?');" value="{{$empJoining->id}}" class="btn btn-outline-info text-dark col-lg-12 mb-4 btn-center">Save and Approve</button>
               </form> </form>
			    </td>
						
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
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
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


   <script>
		var today = new Date();
		var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
		document.getElementById("joiningAcceptedOn").value = date;
		</script>	
