<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Counter</title>

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <style>
        .attendanceTitle { font-family: "Times New Roman", Times, serif; font-size: 25px; }
        .textfont { font-family: Arial, Helvetica, sans-serif; font-size: 15px; }
        .styleCol { white-space: nowrap; }
    </style>
</head>

<body>

<div class="container-fluid" style="margin-right:20%; width:95%;">
    <div class="row">
        <div class="col-md-12">

            {{-- Filters --}}
            <div class="form-group row">

                {{-- Year --}}
                <div class="col-lg-4 col-md-4">
                    <label for="filter_year">Select Year</label>
                    <select name="filter_year" id="filter_year" class="form-control">
                        <option value="">All Years</option>
                        @for ($y = date('Y'); $y >= 2025; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Month --}}
                <div class="col-lg-4 col-md-4">
                    <label for="filter_month">Select Month</label>
                    <select name="filter_month" id="filter_month" class="form-control">
                        <option value="">All Months</option>
                        @foreach([1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'] as $key => $month)
                            <option value="{{ $key }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Office --}}
                <div class="col-lg-4 col-md-4">
                    <label for="office_name">Office Name</label>
                    <select name="office_name" id="office_name" class="form-control">
                        <option value="">All Offices</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->officeDetails }}">{{ $office->officeDetails }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            {{-- Buttons --}}
            <div class="form-group text-center">
                <button type="button" id="filter" class="btn btn-success">Filter</button>
                <button type="button" id="reset" class="btn btn-warning">Reset</button>
            </div>

        </div>
    </div>

    {{-- Title --}}
    <div class="attendanceTitle card-header bg-green text-center">
        <h5><b>Attendance Counter</b></h5>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table id="attendanceCount_data" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Emp ID</th>
                    <th>Name</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Office Name</th>
                    <th>Checkin On Time</th>
                    <th>Checkin Late</th>
                   
                    <th>Checkout On Time</th>
                    <th>Checkout Early</th>
                     <th>System Absent</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

{{-- JS --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function () {

    // Initialize DataTable with empty data
    let table = $('#attendanceCount_data').DataTable({
        serverSide: true,
        processing: true,
        deferLoading: 0, // Start empty
        destroy: true,
        aLengthMenu: [[20,40,60,100,-1],[20,40,60,100,"All"]],

        dom: 'Blfrtip',
        buttons: ['copy', 'excel', 'csv', 'print'],
       
        ajax: {
            url: "{{ route('attendanceCount.index') }}",
            data: function(d) {
                d.filter_year = $('#filter_year').val();
                d.filter_month = $('#filter_month').val();
                d.office_name = $('#office_name').val();
            }
        },
        columns: [
            { data: null, render: function (data,type,row,meta){ return meta.row + 1; },name:'' },
            { data: 'user_id', name: 'user_id' },
            { data: 'empName', name: 'empName' },
            { data: 'month_name', name: 'month_name' },
            { data: 'year', name: 'year' },
            { data: 'officeDetails', name: 'officeDetails',orderable: false, searchable: false },
            { data: 'checkin_on_time_count', name: 'checkin_on_time_count' },
            { data: 'checkin_late_count', name: 'checkin_late_count' },
          
            { data: 'checkout_on_time_count', name: 'checkout_on_time_count' },
            { data: 'checkout_early_count', name: 'checkout_early_count' },
              { data: 'system_absent_count', name: 'system_absent_count' }
        ],

        columnDefs: [
            { orderable: false, targets: 0 } // disable sorting for Sl. No
            ],
            order: [] // disable default ordering to prevent ORDER BY ''
    });

    // Filter button
    $('#filter').click(function () {
        table.ajax.reload();
    });

    // Reset button
    $('#reset').click(function () {
        $('#filter_year').val('');
        $('#filter_month').val('');
        $('#office_name').val('');
        table.ajax.reload();
    });

});
</script>

</body>
</html>
