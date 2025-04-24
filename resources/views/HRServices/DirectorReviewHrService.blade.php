<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <style>
        .reviewTitle {
            font-family: "Times New Roman", Times, serif;
            font-size: 25px;
        }

        .textfont {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
        }

        .styleCol {
            white-space: nowrap;
        }
    </style>
</head>

<body>

    <div class="container-fluid" style="margin-right:20%;width:95%;">
        <!-- mesage box here -->
        <div id="statusMessage" class="alert" style="display: none;"></div>   
    <br>

        <div class="row">
            <div class="col-md-12">
            <div class="d-flex justify-content-center">
                <div class="form-group row align-items-center" style="gap: 15px;">
                   
                    <div class="col-auto">
                        <label for="serviceType" class="mb-0">Select Services:</label>
                    </div>

                    <!-- Dropdown -->
                    <div class="col-auto">
                        <select name="serviceType" id="serviceType" class="form-control" required style="min-width: 250px;">
                            <option value="">Select Service</option>
                            @foreach(['concern letter' => 'Concern Letter', 'pay slip' => 'Pay Slip', 'salary advance' => 'Salary Advance'] as $key => $service)
                                <option value="{{ $key }}">{{ $service }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-auto d-flex align-items-end" style="gap: 10px;">
                        <div>
                            <button type="button" id="filter" class="btn btn-success w-100">Filter</button>
                        </div>

                        <div>
                            <button type="button" id="reset" class="btn btn-warning w-100">Reset</button>
                        </div>
                    </div>

                </div></div>
            </div>
        </div>
        <!-- Hidden Emp ID -->
<input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId">

        <div class="reviewTitle card-header bg-green text-center">
            <h5><b>Director Review (HR Services)</b></h5>
        </div>
        <div class="table-responsive">
            <table id="reviewPage" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl.No</th>
                        <th>Service Id</th>
                        <th>Service Type</th>
                        <th>Created By</th>                     
                        <th>Office Name</th>
                        <th>Justification</th>
                        <th>Remarks</th>
                        <th>Action</th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Approval Remark Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remarks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="remarks">Enter your Remarks:</label>
                <textarea  id="approvalRemarks" name="approvalRemarks" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmApproval">Approve</button>
            </div>
        </div>
    </div>
</div>

<!-- for recommend modal -->
<div class="modal fade" id="recommendModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remarks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="remarks">Enter your Remarks:</label>
                <textarea id="recommendRemarks" name="recommendRemarks" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmRecommend">Recommend</button>
            </div>
        </div>
    </div>
</div>

<!-- reject modal-->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remarks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="remarks">Enter your Remarks:</label>
                <textarea id="rejectRemarks" name="rejectRemarks" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmReject">Reject</button>
            </div>
        </div>
    </div>
</div>
<!-- end here -->

<!-- Remarks modal -->
<div class="modal fade" id="remarksModal" tabindex="-1" role="dialog" aria-labelledby="remarksModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document"> <!-- modal-lg to fit the table -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="remarksModalLabel">Remarks of the supervisor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-hover table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Status</th>
              <th>Remarks</th>
            </tr>
          </thead>
          <tbody id="remarksBody">
       
        </tbody>
            
        </table>
      </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>        
        </div>
    </div>
  </div>
</div>
<!-- end here remarks modal -->


</body>

</html>

<script>
    $(document).ready(function() {
        function loadDataTable(service = '', office = '') {
            $('#reviewPage').DataTable({
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
                    url: "{{ route('HR_Services_Director.index') }}",
                    data: {
                        serviceType: service
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'id', name: 'id' },
                    {
                        data: 'serviceType',
                        name: 'serviceType'
                    },
                    // {
                    //     data: 'createdBy',
                    //     name: 'createdBy'
                    // },
                    // { data: 'empName', name: 'empName' },
                    {
                        data: null,  
                        render: function(data, type, row) {
                            return `${row.createdBy} (${row.empName})`;  
                        },
                       
                    },

                    { data: 'officeDetails', name: 'officeDetails' },                   

                    {
                        data: 'justification',
                        name: 'justification'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {

                        return `
                        <div style="white-space: nowrap;">
                            <button class="btn btn-outline-success btn-sm remarks-btn" style="color: black;  margin-right: 10px;" data-id="${row.id}">View Remarks</button>
                        </div>
                            `;
                        }
                       
                    },
                    {
                        data: null, // We'll render the buttons here
                        render: function(data, type, row) {

                            return `
                              <div style="white-space: nowrap;">
                                <button class="btn btn-outline-success btn-sm approve-btn" data-id="${row.id}"   style="color: black;  margin-right: 10px;"> Approve</button>
                                <button class="btn btn-outline-info btn-sm recommend-btn" data-id="${row.id}"   style="color: black;  margin-right: 10px;"> Recommend</button>                                
                                <button class="btn btn-outline-danger btn-sm reject-btn"  data-id="${row.id}"  style="color: black;"> Reject</button>
                             </div>
                                `;
                        }
                    }

                ]
            });
        }
        loadDataTable();
        $('#filter').click(function() {
            loadDataTable($('#serviceType').val());
        });
        $('#reset').click(function() {
            $('#serviceType').val('');
            // $('#office_name').val('');
            loadDataTable();
        });
    });
  

    let empId = $('#empId').val();  //auth user empId

     // 1.Approve button click handler
     $(document).on('click', '.approve-btn', function() {
    var rowId = $(this).data('id');  
     $('#approvalRemarks').val(''); // Clear old remarks 
     $('#approvalModal').data('rowId', rowId).modal('show');
    });
  
    // When the "Approve" button in the modal is clicked
    $('#confirmApproval').on('click', function() {
    var rowId = $('#approvalModal').data('rowId');   
    var remarks = $('#approvalRemarks').val().trim(); 

    if (remarks === "") {
        alert("Please enter a remarks before approving.");
        return;
    }

    $(`.approve-btn[data-id="${rowId}"]`).prop('disabled', true);
    $(this).prop('disabled', true).text('Processing...'); 
    
    $.ajax({
        url: "{{ route('HR_Services_Director.Director_hrservice') }}", 
        method: 'POST',
        data: {
            id: rowId,  
            empId: empId,          
            status: 'Approved',  
            remarks: remarks,  
            _token: '{{ csrf_token() }}'  
        },
       
        success: function(response) {
            const msgBox = $('#statusMessage');
            if (response.success) {
                msgBox.removeClass('alert-danger')
                      .addClass('alert-success')
                      .text('You have approved the request successfully!')
                      .show().delay(3000).fadeOut();

                $('#approvalModal').modal('hide');
                $('#reviewPage').DataTable().ajax.reload();
            } else {
                msgBox.removeClass('alert-success')
                      .addClass('alert-danger')
                      .text('Failed to update status.')
                      .show().delay(3000).fadeOut();
            }
        },
        error: function(xhr, status, error) {
            $('#statusMessage')
                .removeClass('alert-success')
                .addClass('alert-danger')
                .text("Server error. Please try again.")
                .show().delay(3000).fadeOut();
        }
    });

});


// 2 recommended
$(document).on('click', '.recommend-btn', function() {
    var rowId = $(this).data('id');
    $('#recommendRemarks').val('');
    $('#recommendModal').data('rowId', rowId).modal('show');
    });
  
    // When the "recommend" button in the modal is clicked
    $('#confirmRecommend').on('click', function() {
    var rowId = $('#recommendModal').data('rowId');   
    var remarks = $('#recommendRemarks').val().trim(); 

    if (remarks === "") {
        alert("Please enter a remark before recommending.");
        return;
    }

    $(`.recommend-btn[data-id="${rowId}"]`).prop('disabled', true);
    $(this).prop('disabled', true).text('Processing...');
    
    $.ajax({
        url: "{{ route('HR_Services_Director.Director_hrservice') }}", 
        method: 'POST',
        data: {
            id: rowId,  
            empId: empId,          
            status: 'Recommended',  
            remarks: remarks,  
            _token: '{{ csrf_token() }}'  
        },
       
        //     success: function(response) {
        //     const msgBox = $('#statusMessage');
        //     msgBox.text(response.success ? 'You have recommended the request successfully!' : 'Failed to update status.')
        //         .show().delay(3000).fadeOut();

        //     if (response.success) {
        //         $('#recommendModal').modal('hide');
        //         $('#reviewPage').DataTable().ajax.reload();
        //     }
        // }
        success: function(response) {
            const msgBox = $('#statusMessage');
            if (response.success) {
                msgBox.removeClass('alert-danger')
                      .addClass('alert-success')
                      .text('You have approved the request successfully!')
                      .show().delay(3000).fadeOut();

                $('#recommendModal').modal('hide');
                $('#reviewPage').DataTable().ajax.reload();
            } else {
                msgBox.removeClass('alert-success')
                      .addClass('alert-danger')
                      .text('Failed to update status.')
                      .show().delay(3000).fadeOut();
            }
        },
        error: function(xhr, status, error) {
            $('#statusMessage')
                .removeClass('alert-success')
                .addClass('alert-danger')
                .text("Server error. Please try again.")
                .show().delay(3000).fadeOut();
        }

    });

});

//3 reject modal script
$(document).on('click', '.reject-btn', function() {
    var rowId = $(this).data('id');
    $('#rejectRemarks').val('');
    $('#rejectModal').data('rowId', rowId).modal('show');
    });
  
    // When the "reject" button in the modal is clicked
    $('#confirmReject').on('click', function() {
    var rowId = $('#rejectModal').data('rowId');   
    var remarks = $('#rejectRemarks').val().trim(); 

    if (remarks === "") {
        alert("Please enter a remark before rejecting.");
        return;
    }

    $(`.reject-btn[data-id="${rowId}"]`).prop('disabled', true);
    $(this).prop('disabled', true).text('Processing...'); 
    
    $.ajax({
        url: "{{ route('HR_Services_Director.Director_hrservice') }}", 
        method: 'POST',
        data: {
            id: rowId,  
            empId: empId,          
            status: 'Rejected',  
            remarks: remarks,  
            _token: '{{ csrf_token() }}'  
        },
       
        success: function(response) {
            const msgBox = $('#statusMessage');
            if (response.success) {
                msgBox.removeClass('alert-danger')
                      .addClass('alert-success')
                      .text('You have rejected the request!')
                      .show().delay(3000).fadeOut();

                $('#rejectModal').modal('hide');
                $('#reviewPage').DataTable().ajax.reload();
            } else {
                msgBox.removeClass('alert-success')
                      .addClass('alert-danger')
                      .text('Failed to update status.')
                      .show().delay(3000).fadeOut();
            }
        },
        error: function(xhr, status, error) {
            $('#statusMessage')
                .removeClass('alert-success')
                .addClass('alert-danger')
                .text("Server error. Please try again.")
                .show().delay(3000).fadeOut();
        }

    });

});

   // show remarks modal
   $(document).on('click', '.remarks-btn', function() {
    var serviceId = $(this).data('id');

    $.ajax({
        url: `/get-remarks/${serviceId}`,  // create this route
        type: 'GET',
        success: function(data) {
            let tbody = $('#remarksModal tbody');
            tbody.empty(); // Clear previous

            if (data.length > 0) {
                data.forEach(row => {
                    tbody.append(`
                        <tr>
                            <td>${row.noteId}</td>
                            <td>${row.modifier}</td>
                            <td>${row.modiType}</td>
                            <td>${row.remarks}</td>
                        </tr>
                    `);
                });
            } else {
                tbody.append('<tr><td colspan="3" class="text-center">No remarks found.</td></tr>');
            }

            $('#remarksModal').modal('show');
        }
    });
});


</script>