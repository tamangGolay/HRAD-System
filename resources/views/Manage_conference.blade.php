<style>
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
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<div class="container"> <a class="btn success" href="javascript:void(0)" id="createNewBook"> Create New Meeting Room </a>
	<table class="table table-bordered data-table"> @csrf
		<thead>
			<tr>
				<th>No</th>
				<th>Conference_Name</th>
				<th>Capacity</th>
				<th width="300px">Action</th>
			</tr>
		</thead>
		<tbody> </tbody>
	</table>
</div>
<div class="modal fade" id="ajaxModel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modelHeading"></h4> </div>
			<div class="modal-body">
				<form id="bookForm" name="bookForm" class="form-horizontal"> @csrf
					<input type="hidden" value="{{ csrf_token() }}">
					<input type="hidden" name="conference_id" id="conference_id">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Conferene_Name</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="name" name="name" placeholder="Enter Title" value="" maxlength="50" required=""> </div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Capacity</label>
						<div class="col-sm-12">
							<input type="number" id="capacity" name="capacity" placeholder="Only Number Accepted" class="form-control"> </div>
					</div>
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
var table = $('.data-table').DataTable({
	processing: true,
	serverSide: true,
	ajax: "{{ route('conference.index') }}",
	columns: [{
		data: 'id',
		name: 'conference_id'
	}, {
		data: 'Conference_Name',
		name: 'name'
	}, {
		data: 'capacity',
		name: 'capacity'
	}, {
		data: 'action',
		name: 'action',
		orderable: true,
		searchable: true
	}, ]
});
$('#createNewBook').click(function() {
	$('#saveBtn').val("create-book");
	$('#conference_id').val('');
	$('#bookForm').trigger("reset");
	$('#modelHeading').html("Create New Meeting Room");
	$('#ajaxModel').modal('show');
});
$('body').on('click', '.editBook', function() {
	var conference_id = $(this).data('id');
	$.get("{{ route('conference.index') }}" + '/' + conference_id + '/edit', function(data) {
		$('#modelHeading').html("Edit Meeting Room");
		$('#saveBtn').val("edit-book");
		$('#ajaxModel').modal('show');
		$('meta[name="csrf-token"]').attr('content'),
			$('#conference_id').val(data.id);
		$('#name').val(data.Conference_Name);
		$('#capacity').val(data.capacity);
	})
});
$('#saveBtn').click(function(e) {
	e.preventDefault();
	$(this).html('Save');
	$.ajax({
		data: $('#bookForm').serialize(),
		url: "{{ route('conference.store') }}",
		type: "POST",
		dataType: 'json',
		success: function(data) {
			$('#bookForm').trigger("reset");
			$('#ajaxModel').modal('hide');
			table.draw();
			window.onload = callajaxOnPageLoad(page);
			var alt = document.createElement("div");
			alt.setAttribute("style", "position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
			alt.innerHTML = " Successful! ";
			setTimeout(function() {
				alt.parentNode.removeChild(alt);
			}, 3000);
			document.body.appendChild(alt);
			$.get('/getView?v=booking_review', function(data) {
				$('#contentpage').empty();
				$('#contentpage').append(data.html);
			});
		},
		error: function(data) {
			console.log('Error:', data);
			$('#saveBtn').html('Save Changes');
		}
	});
});
$('body').on('click', '.deleteBook', function() {
	var conference_id = $(this).data("id");
	if(confirm("Are You sure want to delete !")) {
		$.ajax({
			type: "DELETE",
			url: "{{ route('conference.store') }}" + '/' + conference_id,
			success: function(data) {
				table.draw();
			},
			error: function(data) {
				console.log('Error:', data);
			}
		});
	}
});
</script>