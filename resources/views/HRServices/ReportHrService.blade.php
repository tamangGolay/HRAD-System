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
    <!-- <div id="statusMessage" style="display: none; background-color:#28a745; color: white; padding: 8px 12px; border-radius: 4px; margin-top: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);"></div> -->
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
            <h5><b>Report on HR Services</b></h5>
        </div>
        <div class="table-responsive">
            <table id="reportPage" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sl.No</th>
                        <th>Service Id</th>
                        <th>Service Type</th>
                        <th>Created By</th> 
                        <th>Mail ID</th> 
                        <th>Created On</th>                     
                        <th>Office Name</th>
                        <!-- <th>Justification</th> -->
                        <th>Remarks</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

      

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
            $('#reportPage').DataTable({
                "aLengthMenu": [
                    [20, 40, 60, 100, -1],
                    [20, 40, 60, 100, "All"]
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
                order: [[1, 'desc']],  // desc order by second coulmn that id id(Service id)
                ajax: {
                    url: "{{ route('HR_Services_Report.index') }}",
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
                    
                    {
                        data: null,  
                        render: function(data, type, row) {
                            return `${row.createdBy} (${row.empName})`;  
                        },
                       
                    },
                     {
                        data: 'emailId',
                        name: 'emailId'
                    },
                     {
                        data: 'createdOn',
                        name: 'createdOn'
                    },

                    { data: 'officeDetails', name: 'officeDetails' },                   

                    // {
                    //     data: 'justification',
                    //     name: 'justification'
                    // },
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
                        data: 'status',
                        name: 'status', 
                        render: function(data, type, row) {
                            if (data === 'HRApproved') {
                                return 'Approved by HR';
                            }
                            return data; // fallback for other statuses
                        }
                    },
                   

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