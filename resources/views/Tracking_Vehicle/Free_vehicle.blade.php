<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet" />
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header bg-green">
				<div class="col">&nbsp;&nbsp;&nbsp;Vehicle Details</div>
			</div>
			<!--/card-header-->
			<div class="card-body table-responsive p-0">
				<div>
					<table id="example1" class="table table-hover table-striped">
						<thead>
							<tr>
								<th>Slno#</th>
								<th>Vehicle_name</th>
								<th>Type</th>
								<th>Number</th>
								<th>Model</th>
								<th>Dzongkhag</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody> @foreach($Free_vehicle as $fv)
							<tr>
								<td> {{$fv->id}} </td>
								<td> {{$fv->vehicle_name}} </td>
								<td> {{$fv->vehicle_type}} </td>
								<td> {{$fv->vehicle_number}} </td>
								<td> {{$fv->model}} </td>
								<td> {{$fv->Dzongkhag_Name}} </td>
								<td> {{$fv->status}} </td>
							</tr> @endforeach </tbody>
					</table>
				</div>
				<div class="float-right"> {{$Free_vehicle->links()}} </div>
				<div>
					<!--/card-body-->
				</div>
			</div>
			<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
			<script type="text/javascript">
			$(document).ready(function() {
				document.getElementById('contenthead').innerHTML = '<strong>Vehicle Details</strong>';
			});
			</script>