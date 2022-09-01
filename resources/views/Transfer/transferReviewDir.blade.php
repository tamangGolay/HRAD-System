<div class="row ">
	<div class="col">
		<div class="card ">
			<div class="card-header bg-green">
				<div class="col text-center">
					<h5>
                <b>Transfer Request Review</b>
              </h5> </div>
			</div>
			<div class="col text-right col-form-label col-md-right col-sm-4 col-md-6 col-lg-12 ">
				<button  id="notescancel" class="btn btn-outline-info btn" onclick="othertransferrequest();" style="color:black;">View Transfer Request</button>
			</div
			
	<form method="POST" action="/dirReviewTransfer" enctype="multipart/form-data"  accept-charset="UTF-8" > @csrf
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
								<!-- <th style="width:3%">Recommend</th> -->
								<th style="width:3%">Approve</th>
								<th style="width:3%">Reject</th>
							</tr>
						</thead>
						<tbody>
							 @foreach($transferRequest as $rv)
						<tr>
								
                  			<td>{{$rv->id}}</td>
                 			<td>{{$rv->empId}}</td>
                 			<td>{{$rv->f}}</td>
                 			<td>{{$rv->tff}}</td>                 
                  			<td>{{$rv->reasonForTransfer}}</td>
							<td>
								<form method="POST" action="/dirReviewTransfer" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf    
									<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}"> 
									<input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >	
									<input type="hidden" name="remarks" id="remarks" value="recommended">
									<button type="submit" name="id[]" id="id" onclick="return confirm('Do you want to recommend and forward?');" value="{{$rv->id}}" class="btn btn-outline-info text-dark col-lg-12 mb-4 btn-center " >Recommend</button>
						
									<div>
									<textarea name="rejectreason" id="reason" placeholder="reason for rejection"  required></textarea>		
									</div>

								</form> 
							</td>

							<td>

								<form method="POST" action="/dirReviewTransfer" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
									<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
								<input type="hidden" name="remarks2" id="remarks2" value="rejected">  
								<button type="submit" name="id[]" id="id" onclick="return confirm('Do you want to reject?');" value="{{$rv->id}}" class="btn btn-outline-danger text-dark col-lg-12 mb-4 btn-center " >Reject</button>
								<div>
									<textarea name="rejectreason" id="reason" placeholder="reason for rejection"  required></textarea>		
									</div>
									</form> 
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
				"autoWidth":true,
				"paging": true,
				"retrieve":true,
				buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5']
			});
		});

		</script>

<script type="text/javascript">

function othertransferrequest()
{
 $.get('toDirtransferrequest',function(data){ 
    $('#contentpage').empty();                  
    $('#contentpage').append(data.html);
 });

}
</script>