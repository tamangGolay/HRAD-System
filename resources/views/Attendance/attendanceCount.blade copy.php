
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <style>
        .attendanceTitle {
            font-family: "Times New Roman", Times, serif;
            font-size: 25px;
        }

        .textfont {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
        }
        .styleCol{
            white-space: nowrap;
        }
    </style>
</head>

<body>

<div class="container-fluid" style="margin-right:20%;width:95%;">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group row">
                <div class="col-lg-6 col-md-6">
                    <label for="filter_month">Select Month</label>
                    <select name="filter_month" id="filter_month" class="form-control" required>
                        <option value="">Select Month</option>
                        @foreach(['1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'] as $key => $month)
                            <option value="{{ $key }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 col-md-6">
                    <label for="office_name">Office Name</label>
                    <select name="office_name" id="office_name" class="form-control">
                        <option value="">Select Office</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->officeDetails }}">{{ $office->officeDetails }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group text-center">
                <button type="button" id="filter" class="btn btn-success">Filter</button>
                <button type="button" id="reset" class="btn btn-warning">Reset</button>
            </div>
        </div>
    </div>

    <div class="attendanceTitle card-header bg-green text-center">
        <h5><b>Attendance Counter</b></h5>
    </div>
    <div class="table-responsive">
        <table id="attendanceCount_data" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Emp ID</th>
                    <th>Name</th>
                    <th>Office Name</th>
                    <th>Checkin OnTime Count</th>
                    <th>Checkin Late Count</th>
                    <th>Checkout OnTime Count</th>
                    <th>Checkout Early Count</th>
                   
                </tr>
            </thead>
        </table>
    </div>
</div>


</body>

</html>

<script>
    $(document).ready(function() {
        function loadDataTable(month = '', office = '') {
            $('#attendanceCount_data').DataTable({
                "aLengthMenu": [
                    [20, 40, 60, 100, -1],
                    [20, 40, 60, 100, "All"]
                ],
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'print'
                ],
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ route('attendanceCount.index') }}",
                    data: { filter_month: month, office_name: office }
                },
                columns: [
                    { data: null, render: function(data, type, row, meta) { return meta.row + 1; } },
                    { data: 'user_id', name: 'user_id' },
                    { data: 'empName', name: 'empName' },
                    { data: 'officeDetails', name: 'officeDetails' },
                    { data: 'checkin_on_time_count', name: 'checkin_on_time_count' },
                    { data: 'checkin_late_count', name: 'checkin_late_count' },
                    { data: 'checkout_on_time_count', name: 'checkout_on_time_count' },
                    { data: 'checkout_early_count', name: 'checkout_early_count' }

                ]
            });
        }
        loadDataTable();
        $('#filter').click(function() {
            loadDataTable($('#filter_month').val(), $('#office_name').val());
        });
        $('#reset').click(function() {
            $('#filter_month').val('');
            $('#office_name').val('');
            loadDataTable();
        });
    });
</script>

