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


    <div class="container-fluid">     

        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">

                <div class="form-group row col-sm-12 col-md-12">
                    <div class="col-lg-4 col-sm-12 col-md-6">
                      
                        <label class="col-md-4 col-form-label text-md-left" for="stardate">Start Date</label>

                        <input type="date" name="filter_startdate" id="filter_startdate" placeholder="Start Date" class="form-control" required>

                    </div>


                    <div class="col-lg-4 col-sm-12 col-md-6">
                        <label class="col-md-4 col-form-label text-md-left" for="stardate">End Date</label>

                        <input type="date" name="filter_enddate" id="filter_enddate" placeholder="End Date" class="form-control" required>

                    </div>

                    <div class="col-lg-4 col-sm-12 col-md-6">
                        <label class="col-md-4 col-form-label text-md-left" for="office_name">Office Name</label>
                        <select name="office_name" id="office_name" class="form-control">
                            <option value="">Select Office</option>
                            <option value="Direct Report">Direct Report</option>
                            @foreach($offices as $office)
                            <option value="{{ $office->officeDetails }}">{{ $office->officeDetails }}</option>
                            @endforeach
                        </select>
                    </div>


                </div>

                <div class="form-group textfont" align="center">
                    <button type="button" style="width:90px" name="filter" id="filter" class="btn btn-success">Filter</button>

                    <button type="button" style="width:90px" name="reset" id="reset" class="btn btn-warning">Reset</button>
                 
                      
                </div>

                 
                <div class="col-md-12 col-lg-12 col-sm-12" style="margin-top: 15px; margin-bottom:15px; text-align: center">
                    <a href="https://drive.google.com/file/d/1bCl0hakczJrTybDyWuIZlOnQLUz6DXsy/view?usp=sharing" target="_blank" style="color: blue;  font-size: 18px;">
                                        📄 User Manual for Supervisors
                    </a>
                </div>             

                <div style="color:red;">   
                        <p>
                            <span style="color:green;">***</span>
                            Note: This review tab allows supervisors to view their employees' attendance from the previous day. Only records of employees who were <strong>absent</strong>, arrived <strong>late</strong>, or left <strong>early</strong> are shown here.
                         <span style="color:green;">***</span>
                        </p>
                </div>


            </div>

        </div>

        <br />
        <div class="attendanceTitle card-header bg-green">
            <div class="col text-center">
                <h5>
                    <b>Attendance Review</b>
                </h5>
            </div>
        </div>

        <div class="table-responsive textfont">
            <table id="att_data" class="table table-bordered table-striped">
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
                        <th rowspan="2">Action</th>
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

        <br />
        <br />
    </div>

<!-- Approval Remark Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approval Justification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="remark">Enter your justification:</label>
                <textarea id="remark" name="remark" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmApproval">Approve</button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Remark Modal -->
<!-- <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Justification to reject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="remark">Enter your justification:</label>
                <textarea id="remarkReject" name="remarkReject" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmReject">Save Changes</button>
            </div>
        </div>
    </div>
</div> -->


</body>

</html>

<script>
    $(document).ready(function() {

        var filterApplied = false;
        var authUserOfficeId = '{{ Auth::user()->office }}';
        var authUserHead = '{{ Auth::user()->empId }}';
       

        // console.log('test data here',reportToOffice );
      
        
        var dataTable = fill_datatable();

        function fill_datatable(filter_startdate = '', filter_enddate = '', office_name = '') {
            return $('#att_data').DataTable({
                dom: 'Blfrtip',
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
                ajax: {
                    url: "{{ route('attendanceReview.index') }}",
                    data: {
                        filter_startdate: filter_startdate,
                        filter_enddate: filter_enddate,
                        office_name: office_name
                    }
                },
                columns: [
                                  
                    {
                        data: null,
                        name: 'sl_no',
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Start Sl No from 1
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

                    {
                        data: null, // We'll render the buttons here
                        render: function(data, type, row) {

                            // if (!row.canApproveReject) {
                            //     return '';
                            // }

                        //     if ( row.head != authUserHead) {
                        //     return '';  // Hide approve and reject button if not direct supervisor
                        // }
                            // Render the Approve and Reject buttons if direct supervisor
                    // console.log('canApproveReject:', row.canApproveReject);

                            if (row.canApproveReject == true) {
                            return `
                                <button class="btn btn-outline-success btn-sm approve-btn" data-id="${row.id}"  data-date="${row.date}" style="color: black;  margin-right: 10px;"> <i class="fas fa-check"></i></button>
                                
                                <button class="btn btn-outline-danger btn-sm reject-btn"  data-id="${row.id}" data-date="${row.date}" style="color: black;"> <i class="fas fa-times"></i></button>
                            `;
                        }
                    else{
                        return `<span class="text-muted">N/A</span>`;
                    }}
                    }
                    
                ],
                rowCallback: function(row, data, index) {
                    $('td:eq(0)', row).html(index + 1); // Update Sl No in the first column

                    if (!filterApplied) {

                     if (row.canApproveReject == false) {
                     $(row).hide(); // Hide the entire row
                 }
            }
                },
                
                
            });
        }

        $('#filter').click(function() {
            var filter_startdate = $('#filter_startdate').val();
            var filter_enddate = $('#filter_enddate').val();
            var officeName = $('#office_name').val();

            if (filter_startdate != '' && filter_enddate != '' && officeName != '') { // Corrected this line
                $('#att_data').DataTable().destroy();
                filterApplied = true;
                fill_datatable(filter_startdate, filter_enddate, officeName);
            } else {
                alert('Select Both filter options'); // This will now execute if one or both dates are not selected
            }
        });

        $('#reset').click(function() {
            $('#filter_startdate').val('');
            $('#filter_enddate').val('');
            $('#office_name').val('');
            filterApplied = false;
            $('#att_data').DataTable().destroy();
            fill_datatable();
        });

        // For approve and reject 

    // 1.Approve button click handler
    $(document).on('click', '.approve-btn', function() {
    var rowId = $(this).data('id');
    var date = $(this).data('date');

   // Store rowId & date globally to use in the approval button click
   $('#approvalModal').data('rowId', rowId).data('date', date).modal('show');
    });
  
    // When the "Approve" button in the modal is clicked
    $('#confirmApproval').on('click', function() {
    var rowId = $('#approvalModal').data('rowId');
    var date = $('#approvalModal').data('date');
    var remark = $('#remark').val().trim(); // Get the remark input

    if (remark === "") {
        alert("Please enter a justification before approving.");
        return;
    }
    
    $.ajax({
        url: "{{ route('attendanceReview.updateStatus') }}", 
        method: 'POST',
        data: {
            id: rowId,
            date: date,
            status: 'Approved',  
            remark: remark,  // Send the remark
            _token: '{{ csrf_token() }}'  
        },
        success: function(response) {
            if (response.success) {               
                $('#approvalModal').modal('hide'); 
                alert('Justification added sucessfully!')
                $('#att_data').DataTable().ajax.reload();
            } else {
                alert('Failed to update status.');
            }
        }
    });

});
// 2. reject
$(document).on('click', '.reject-btn', function() {
    var rowId = $(this).data('id');
    var date = $(this).data('date');

     if (!confirm("Are you sure you want to reject this attendance record?")) {
        return;
    }


    // Store rowId & date globally to use in the approval button click
//    $('#rejectModal').data('rowId', rowId).data('date', date).modal('show');
    // });
  
    // When the "Approve" button in the modal is clicked
    // $('#confirmReject').on('click', function() {
    // var rowId = $('#rejectModal').data('rowId');
    // var date = $('#rejectModal').data('date');
    // var remarkReject = $('#remarkReject').val().trim(); // Get the remark input

    // if (remarkReject === "") {
    //     alert("Please enter a justification before approving.");
    //     return;
    // }   
   
    $.ajax({
        url: "{{ route('attendanceReview.updateStatusReject') }}", 
        method: 'POST',
        data: {
            id: rowId,
            date: date,
            status: 'Rejected',  
           // remarkReject: remarkReject,  // Send the remark
            _token: '{{ csrf_token() }}'  
        },
        success: function(response) {
            if (response.success) {               
                // $('#rejectModal').modal('hide'); 
                alert('Rejected sucessfully!')

                $('#att_data').DataTable().ajax.reload();
            } else {
                alert('Failed to update status.');
            }
        }
    });

});       
        

    });
</script>