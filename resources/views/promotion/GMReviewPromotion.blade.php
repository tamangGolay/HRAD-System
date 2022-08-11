<div class="row ">
	<div class="col">
		<div class="card ">
			<div class="card-header bg-green">
				<div class="col text-center">
					<h5>
                <b>Promotion Due List</b>
              </h5> </div>
			</div>
			
			<form method="POST" action="/GMrecommendpromotion" enctype="multipart/form-data"  accept-charset="UTF-8" > @csrf
        <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
        <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >


				<div class="card-body table-responsive p-0">

					<table id="table1" class="table table-hover table-striped table-bordered">
						<thead>
							<tr class="text-nowrap">
								<th>Id No</th>
                                 <th>Emp Id </th>
								<th>Prmotion Year</th>
								<th>Promotion Month</th>
								<th>From Grade</th>
								<th>To Grade</th>
								<th>Old Basic</th>
								<th>New Basic</th>	
								<th>Office Name</th>
								<th>Status</th>
								
								<th style="width:10%">Recommend</th>

								<th style="width:10%">Reject</th>
							</tr>
						</thead>
						<tbody>
							 @foreach($promotiondue as $rv)
							<tr>
								<td> {{$rv->id}} </td>
                                <td> {{$rv->empId}} </td>
								<td> {{$rv->promotionYear}} </td>
								<td> {{$rv->promotionMonth}} </td>
								 <td> {{$rv->fromGrade}} </td> 
								<td> {{$rv->toGrade}} </td>
								<td> {{$rv->oldBasic}} </td>
								<td> {{$rv->newBasic}} </td>
								<td> {{$rv->longOfficeName}} </td>
								<td> {{$rv->status}} </td>

				<td>
					
					<form method="POST" action="/GMrecommendpromotion" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf    
					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
     
                                                
					 <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >
	
					<input type="hidden" name="status" id="status" value="Proposed">  

					<button type="submit" name="id[]" id="id" onclick="return confirm('Do you want to recommend and forward?');" value="{{$rv->id}}" class="btn btn-outline-info text-dark col-lg-12 mb-4 btn-center " >Recommend</button>
			</form>
			</td>

			<td>
			<form method="POST" action="/GMrecommendpromotion" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf

			<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
			<input type="hidden" name="status2" id="status" value="Rejected">  

			<button type="submit" name="id[]" id="id" onclick="return confirm('Do you want to reject?');" value="{{$rv->id}}" class="btn btn-outline-danger text-dark col-lg-12 mb-4 btn-center " >Reject</button>
				
				<br>
				<br>
				<div>
					<textarea name="rejectreason" id="reason" placeholder="reason for rejection"  required></textarea>		
			
					</div>
</td>
			
</tr>
			 @endforeach 
    </tbody>

			</table>
			
			<div>
				
		</form>
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