<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Conference Review</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
  <style>
    #saveBtn {
      width: 120px;
    }
    a {
      color: black !important;
      text-decoration: none;
    }
    .btn-primary {
      color: #fff !important;
      background-color: #007bff;
      border-color: #007bff;
    }
    .success {
      color: #fff !important;
      background-color: #28a745;
      border-color: #28a745;
    }
    .danger {
      color: #fff !important;
      background-color: #dc3545;
      border-color: #dc3545;
    }
  </style>
</head>

<body>
<div class="container-fluid">
  <div class="card">
    <div class="card-header bg-success text-white text-center">
      <h5><b>Booked Conference Review</b></h5>
    </div>

    @if(session('alert-success'))
      <div class="alert alert-success">{{ session('alert-success') }}</div>
    @endif
    @if(session('fail'))
      <div class="alert alert-danger">{{ session('fail') }}</div>
    @endif

    <div class="card-body table-responsive">
      <table id="myTable" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Emp Id</th>
            <th>Name</th>
            <th>Contact No</th>
            <th>Office Name</th>
            <th>Meeting Name</th>
            <th>Conference Name</th>
            <th>Start Date & Time</th>
            <th>End Date & Time</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach($review as $rv)
          @if($rv->id > 5)
          <tr>
            <td>{{ $rv->emp_id }}</td>
            <td>{{ $rv->name }}</td>
            <td>{{ $rv->contact_number }}</td>
            <td>{{ $rv->officeDetails }}</td>
            <td>{{ $rv->meeting_name }}</td>
            <td>{{ $rv->Conference_Name }}</td>
            <td>{{ date("Y-m-d h:i A", strtotime($rv->start_date)) }}</td>
            <td>{{ date("Y-m-d h:i A", strtotime($rv->end_date)) }}</td>
            <td style="width:12%">
				<a href="javascript:void(0)" data-id="{{ $rv->id }}" class="btn btn-outline-success editRequest" title="Edit" style="display: inline-block; margin-right: 5px;">
					<i class="fa fa-edit"></i>
				</a>
				<a href="javascript:void(0)" data-id="{{ $rv->id }}" class="btn btn-outline-danger deleteRequest" title="Cancel" style="display: inline-block;">
					Cancel
				</a>
			</td>

          </tr>
          @endif
        @endforeach
        </tbody>
      </table>
      <div class="float-right">{{ $review->links() }}</div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="ajaxModel" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="EditForm" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Edit Booking</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="id" id="id">

        <div class="form-group">
          <label>Conference Name</label>
          <select id="conference" name="conference" class="form-control" required>
            <option value="">Select Conference</option>
            @foreach($conference as $conf)
              <option value="{{ $conf->id }}">{{ $conf->Conference_Name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label>Start Date and Time</label>
          <input type="text" name="start_date" id="start_date" class="form-control" placeholder="yyyy/mm/dd hh:mm" required>
        </div>

        <div class="form-group">
          <label>End Date and Time</label>
          <input type="text" name="end_date" id="end_date" class="form-control" placeholder="yyyy/mm/dd hh:mm" required>
        </div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="saveBtn">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="DeleteForm" class="modal-content">
	@csrf
      <div class="modal-header">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <p>Are you sure you want to cancel this booking?</p>
        <input type="hidden" name="delete_id" id="delete_id">
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-danger">Yes, Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script>
  $(function () {
    $.ajaxSetup({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('.editRequest').click(function () {
      let id = $(this).data('id');
      $.get("{{ route('c_request.store') }}/" + id + "/edit", function (data) {
        $('#id').val(data.id);
        $('#conference').val(data.conference_id);
        $('#start_date').val(data.start_date);
        $('#end_date').val(data.end_date);
        $('#ajaxModel').modal('show');
      });
    });

    $('#EditForm').submit(function (e) {
      e.preventDefault();
      $.post("{{ route('c_request.store') }}", $(this).serialize(), function () {
        $('#EditForm')[0].reset();
        $('#ajaxModel').modal('hide');
		window.location.href = '/success';
				
      });
    });

    $('.deleteRequest').click(function () {
      let id = $(this).data('id');
	  $.get("{{ route('c_request.store') }}/" + id + "/edit", function (data) {
      $('#delete_id').val(id);
      $('#deleteModal').modal('show');
	  });
    });

    $('#DeleteForm').submit(function (e) {
      e.preventDefault();
      let id = $('#delete_id').val();

	  $.post("{{ route('delete') }}", $(this).serialize(), function () {
        
		$('#deleteModal').modal('hide');
		window.location.href = '/error';
		
      });
     
    });
  });
</script>

<script>	 
			$(function() {
			
				$('#myTable').DataTable({
					dom: "Blfrtip",
					"pagingType": "simple_numbers",
					"Searching": true,
					"ordering": false,
					"autoWidth": false,
					"retrieve":true,
					buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5']
				});
			});

			$(document).ready(function() {

			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;</i></a></strong>';

			});
			</script>

</body>
</html>
