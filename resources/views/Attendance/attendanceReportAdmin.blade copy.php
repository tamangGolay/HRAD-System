
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
                        @foreach(['january' => 'January', 'february' => 'February', 'march' => 'March', 'april' => 'April', 'may' => 'May', 'june' => 'June', 'july' => 'July', 'august' => 'August', 'september' => 'September', 'october' => 'October', 'november' => 'November', 'december' => 'December'] as $key => $month)
                            <option value="{{ $key }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 col-md-6">
                    <label for="office_name">Office Name</label>
                    <select name="office_name" id="office_name" class="form-control">
                        <option value="">Select Office</option>
                         <option value="Direct Report">Direct Report</option>
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

            <div style="color:red;">
                <p>
                    <span style="color:green;">***</span>
                    This shows the detailed attendance report of all employees under you. If any record is missing, it may be due to a mismatch in office address or missing data in the system. Please contact IT.  
                    <span style="color:green;">***</span>
                </p>
            </div>


        </div>
    </div>

    <div class="attendanceTitle card-header bg-green text-center">
        <h5><b>Attendance Report</b></h5>
    </div>
    <div class="table-responsive">
    <table id="report_data" class="table table-bordered table-striped">
                <thead>
                <tr>
                        <th rowspan="2">Sl.No</th>
                        <th rowspan="2">Emp ID</th>
                        <th rowspan="2">Name</th>
                        <th rowspan="2">Office Name</th>
                        <th rowspan="2">Date</th>
                        <th colspan="4" style="text-align:center;">CHECK IN</th>
                        <th colspan="4" style="text-align:center;">CHECK OUT</th>
                        <th rowspan="2">Status</th>
                       
                    </tr>
                    <tr>
                        <th class="styleCol">Checkin Location</th>
                        <th class="styleCol">In Time</th>
                        <th>Emp Remarks</th>
                        <th>Status</th>
                        <th class="styleCol">Checkout Location</th>
                        <th class="styleCol">Out Time</th>
                        <th>Emp Remarks</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
    </div>
</div>


</body>

</html>

<!-- <script>
    $(document).ready(function() {
        function loadDataTable(year = '',month = '', office = '') {
            $('#report_data').DataTable({
                "aLengthMenu": [
                     [50, 100, 250, 1000, -1],
                    [50, 100, 250, 1000, "All"]
                ],
                dom: 'Blfrtip',
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
                    url: "{{ route('attendanceReport.index') }}",
                    data: {
                        filter_year: year,
                        filter_month: month,
                        office_name: office
                    }
                },
                columns: [
                                  
                    // {
                    //     data: null,
                    //     name: 'sl_no',
                    //     render: function(data, type, row, meta) {
                    //         return meta.row + 1; // Start Sl No from 1
                    //     }
                    // },
                     {
                        data: null,
                        orderable: false,   // prevents ORDER BY
                        searchable: false,  // prevents WHERE on this col
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1; 
                        }
                    },
                    {
                        data: 'user_id',
                        name: 'user_id'
                    },
                    {
                        data: 'empName',
                        name: 'empName'
                    },
                   
                    {
                        data: 'officeDetails',
                        name: 'officeDetails'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'check_in_address',
                        name: 'check_in_address'
                    },
                    {
                        data: 'check_in_time',
                        name: 'check_in_time'
                    },
                    {
                        data: 'checkin_remarks',
                        name: 'checkin_remarks'
                    },
                    {
                        data: 'checkin_status',
                        name: 'checkin_status',
                        render: function(data, type, row) {
                            // Check if the status is "On Time" or "Delayed"
                            if (data === 'On Time') {
                                return '<span style="color: green;">' + data + '</span>';
                            } else {
                                return '<span style="color: red;">' + data + '</span>';
                            }
                        }
                    },
                    {
                        data: 'check_out_address',
                        name: 'check_out_address'
                    },
                    {
                        data: 'check_out_time',
                        name: 'check_out_time'
                    },
                    {
                        data: 'checkout_remarks',
                        name: 'checkout_remarks'
                    },
                    {
                        data: 'checkout_status',
                        name: 'checkout_status',
                        render: function(data, type, row) {
                            // Check if the status is "On Time" or "Early"
                            if (data === 'On Time') {
                                return '<span style="color: green;">' + data + '</span>';
                            } else {
                                return '<span style="color: red;">' + data + '</span>';
                            }
                        }
                    },

                    {
                        data: 'status',
                        name: 'status',
                    },                   
                    
                ],
        });
    }
        loadDataTable();
        $('#filter').click(function() {
            loadDataTable( $('#filter_year').val(''),$('#filter_month').val(), 
            $('#office_name').val());
        });
        $('#reset').click(function() {
             $('#filter_year').val('');
            $('#filter_month').val('');
            $('#office_name').val('');
            loadDataTable();
        });
    });
</script> -->


<script>
$(document).ready(function () {

    let table = $('#report_data').DataTable({
        aLengthMenu: [
            [50, 100, 250, 1000, -1],
            [50, 100, 250, 1000, "All"]
        ],
        dom: 'Blfrtip',
        buttons: ['copy', 'excel', 'csv', 'print'],
        processing: true,
        serverSide: true,

        ajax: {
            url: "{{ route('attendanceReport.index') }}",
            data: function (d) {
                // ✅ ALWAYS pull fresh values
                d.filter_year  = $('#filter_year').val();
                d.filter_month = $('#filter_month').val();
                d.office_name  = $('#office_name').val();
            }
        },

        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'user_id', name: 'user_id' },
            { data: 'empName', name: 'empName' },
            { data: 'officeDetails', name: 'officeDetails' },
            { data: 'date', name: 'date' },
            { data: 'check_in_address', name: 'check_in_address' },
            { data: 'check_in_time', name: 'check_in_time' },
            { data: 'checkin_remarks', name: 'checkin_remarks' },
            {
                data: 'checkin_status',
                name: 'checkin_status',
                render: d =>
                    d === 'On Time'
                        ? `<span style="color:green">${d}</span>`
                        : `<span style="color:red">${d}</span>`
            },
            { data: 'check_out_address', name: 'check_out_address' },
            { data: 'check_out_time', name: 'check_out_time' },
            { data: 'checkout_remarks', name: 'checkout_remarks' },
            {
                data: 'checkout_status',
                name: 'checkout_status',
                render: d =>
                    d === 'On Time'
                        ? `<span style="color:green">${d}</span>`
                        : `<span style="color:red">${d}</span>`
            },
            { data: 'status', name: 'status' }
        ]
    });

    // ✅ Filter button → just reload
    $('#filter').click(function () {
        table.ajax.reload();
    });

    // ✅ Reset button
    $('#reset').click(function () {
        $('#filter_year').val('');
        $('#filter_month').val('');
        $('#office_name').val('');
        table.ajax.reload();
    });

});
</script>
