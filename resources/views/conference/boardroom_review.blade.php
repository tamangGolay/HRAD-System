<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header bg-green text-center">
                <h5><b>BoardRoom Review</b></h5>
            </div>

            <div class="card-body table-responsive p-0">
                <table id="example3" class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr class="text-nowrap">
                            <th>ID</th>
                            <th>Emp Id</th>
                            <th>Name</th>
                            <th>Contact No</th>
                            <th>Wing/Dept/Div</th>
                            <th>Meeting Name</th>
                            <th>Conference Name</th>
                            <th class="text-nowrap">Start Date and Time</th>
                            <th class="text-nowrap">End Date and Time</th>
                            <th>Approve</th>
                            <th>Reject with Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($review as $rv)
                            <tr class="text-nowrap">
                                <td>{{ $rv->id }}</td>
                                <td>{{ $rv->emp_id }}</td>
                                <td>{{ $rv->name }}</td>
                                <td>{{ $rv->contact_number }}</td>
                                <td>{{ $rv->officeDetails }}</td>
                                <td>{{ $rv->meeting_name }}</td>
                                <td>{{ $rv->Conference_Name }}</td>
                                <td>{{ date("Y-m-d h:i A", strtotime($rv->start_date)) }}</td>
                                <td>{{ date("Y-m-d h:i A", strtotime($rv->end_date)) }}</td>

                                <td style="width:40%">
                                    <form method="POST" action="/conferenceapprove">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ csrf_token() }}">
                                        <button type="submit" name="id[]" value="{{ $rv->id }}" class="btn btn-outline-success text-dark">Approve</button>
                                    </form>
                                </td>

								<td style="width:40%">
									<form method="POST" action="/conferencereject" enctype="multipart/form-data" accept-charset="UTF-8">
										@csrf
										<input type="hidden" name="token" id="tokenid" value="{{ csrf_token() }}">

										<button type="submit" name="id[]" id="id2" value="{{ $rv->id }}" class="btn btn-outline-danger text-center text-dark mb-2">
											Reject
										</button>

										<div>
											<textarea name="reason" id="reason" placeholder="Reason for rejection"
												style="margin-left:5%; width:90%;" rows="2" required></textarea>
										</div>
									</form>
								</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="float-right">{{ $review->links() }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<link href="{{ asset('css/bose.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<!-- Scripts -->
<script src="{{ asset('assets/js/jquery-3.5.1.slim.min.js') }}"></script>
<script src="{{ asset('/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script src="{{ asset('/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script src="{{ asset('/admin-lte/datatables/nima.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/vfs_fonts.js') }}"></script>

<!-- DataTable Initialization -->
<script>
    $(function () {
        $('#example3').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            lengthChange: true,
            searching: true,
            ordering: false,
            info: true,
            autoWidth: false,
            paging: true,
            retrieve: true,
            buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5']
        });

         });

    //home icon
$(document).ready(function() {

document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;</i></a></strong>';

});
</script>
