<style>
	.custom-filter-button {
        background-color: #4BB543; /* Set your desired background color */
        color: #fff !important;
        border-color: ##33FF4F;
		border-radius:5px;
		width:150px;
	
    }
	
	.custom-reset-button{
		background-color: #FFC300 ; /* Set your desired background color */
		border-radius:5px;

	}

    .button-text {
        margin-right: 5px;
    }
	</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<div class="row ">
	<div class="col">
		<div class="card ">
			<div class="card-header bg-green">
				<div class="col text-center">
					<h5>
                <b>All employee uniform Report</b>
              </h5> 
			</div>
			</div>
	<div class="modal fade" id="yearFilterModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Filter by Year</h4>
            </div>
            <div class="modal-body">
                <form id="yearFilterForm" name="yearFilterForm" class="form-horizontal">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-4 text-md-right" for="filterYear">{{ __('Select Year:') }}</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="filterYear" id="filterYear" required>
                                <option value="">Select Year</option>
                                <!-- Add options dynamically based on available years -->
								@foreach($officenamez->unique('year') as $data2)
                                    <option value="{{$data2->year}}">{{$data2->year}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
                        <button type="submit" class="btn btn-outline-primary">Apply Filter</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

			<!--/card-header-->
			<form method="POST" action="/vehicleapprove" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf
				<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
				<div class="card-body table-responsive p-0">
					<table id="table1" class="table table-hover table-striped table-bordered">
						<thead>
							<tr">
								<th>Uniform Name</th>
								<th>Uniform Size</th>
								<th>Total Numbers</th>
								<th>Year</th>
								
							</tr>
						</thead>
						<tbody> @foreach($officenamez as $rv)
							<tr>
								<td> {{$rv->cloths}} </td>
								<td> {{$rv->size}} </td>
								<td> {{$rv->count}} </td>
								<td> {{$rv->year}} </td>
								
		
			</tr> @endforeach 
		</tbody>
			</table>
			
			<div>
				<!--/card-body-->
				</form>
			</div>
			</div>
		</div>

		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

		
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
		
		<script>
$(function() {
    var table = $("#table1").DataTable({
        "dom": 'Bfrtip',
        "responsive": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "paging": true,
        "retrieve": true,
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'print',
            {
				text: '<span class="button-text">Filter by Year</span>',
                className: 'custom-filter-button',
                action: function (e, dt, node, config) {
                    $('#yearFilterModal').modal('show');
                }
			},

			{
				text: '<span class="button-text">Reset</span>',
				className: 'custom-reset-button',
				action: function (e, dt, node, config) {
				$('#filterYear').val('');
				table.column(3).search('').draw();
	         	}	
            }
        ]
    });

    // Additional code for handling year filtering
    $('#yearFilterForm').submit(function (e) {
        e.preventDefault();
        var selectedYear = $('#filterYear').val();
        
        table.column(3).search(selectedYear).draw();
        $('#yearFilterModal').modal('hide');
    });
});
</script>

       <script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true"></i></a></strong>';
		});
		</script>