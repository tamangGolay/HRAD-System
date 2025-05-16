<!-- Styles -->
<link href="{{ asset('css/bose.css') }}" rel="stylesheet">

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header bg-green text-center">
                <h5><b>Vehicle Review By CEO</b></h5>
            </div>

            <div class="card-body table-responsive p-0">
                <table id="CEO_table" class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr class="text-nowrap">
                            <th>Booking No</th>
                            <th>Emp Id</th>
                            <th>Wing/Dept/Div</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th style="width:30%">Purpose</th>
                            <th>Places to Visit</th>
                            <th>Approve</th>
                            <th>Reject</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($CEO_Vehicle_Review as $rv)
                        <tr>
                            <td>{{ $rv->id }}</td>
                            <td>{{ $rv->emp_id }}</td>
                            <td>{{ $rv->officeDetails }}</td>
                            <td>{{ $rv->vname }}</td>
                            <td class="text-nowrap">{{ $rv->dateOfRequisition }}</td>
                          <td class="text-nowrap">
									{{ \Carbon\Carbon::parse($rv->start_date)->format('Y-m-d') }}<br>
									{{ \Carbon\Carbon::parse($rv->start_date)->format('h:i A') }}
							</td>
                            <td class="text-nowrap">{{ $rv->end_date }}</td>
                            <td>{{ $rv->purpose }}</td>
                            <td>{{ $rv->placesToVisit }}</td>
                            <td>
                                <!-- Approve Button -->
                                <form method="POST" action="/vehicleapprove">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ csrf_token() }}">
                                    <button type="submit" name="id[]" onclick="return confirm('Do you want to Approve?');" value="{{ $rv->id }}" class="btn btn-outline-success text-dark">Approve</button>
									  
                                </form>
                            </td>
                            <td style="width:30%">
                                <!-- Reject Button & Reason -->
                                <form method="POST" action="/vehiclereject">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ csrf_token() }}">
                                    <button type="submit" name="id[]" value="{{ $rv->id }}" class="btn btn-outline-danger text-dark">Reject</button>
                                    <br><br>
                                    <textarea name="reason" placeholder="Reason for rejection" class="form-control" required></textarea>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="float-right">{{ $CEO_Vehicle_Review->links() }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('assets/js/jquery-3.5.1.slim.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#contenthead').html('<strong><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;</i></a></strong>');
    });
</script>

<!-- jQuery Validation -->
<script src="{{ asset('/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<!-- Export buttons -->
<script src="{{ asset('/admin-lte/datatables/nima.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('/admin-lte/datatables/vfs_fonts.js') }}"></script>

<script>
    $(function () {
        $('#CEO_table').DataTable({
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
</script>
