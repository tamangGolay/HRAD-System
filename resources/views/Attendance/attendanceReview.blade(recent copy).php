<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <style>
        .ghbheading {
            font-family: "Times New Roman", Times, serif;
            font-size: 25px;
        }

        .textfont {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
        }
    </style>
</head>

<body>


    <div class="container-fluid" style="margin-right:20%;width:95%;">
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
                            @foreach($offices as $office)
                            <option value="{{ $office->longOfficeName }}">{{ $office->longOfficeName }}</option>
                            @endforeach
                        </select>
                    </div>


                </div>

                <div class="form-group textfont" align="center">
                    <button type="button" style="width:90px" name="filter" id="filter" class="btn btn-success">Filter</button>

                    <button type="button" style="width:90px" name="reset" id="reset" class="btn btn-warning">Reset</button>
                </div>
            </div>

        </div>

        <br />
        <div class="card-header bg-green">
            <div class="col text-center">
                <h5>
                    <b>Attendence Review</b>
                </h5>
            </div>
        </div>

        <div class="table-responsive textfont">
            <table id="att_data" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-nowrap">
                        <th>sl.no</th>
                        <th>Emp ID</th>
                        <th>Name</th>
                        <th>Office Name</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Checkin Address</th>
                        <th>Action</th>
                        <th>
                            <div class="d-flex align-items-center">
                                <input type="checkbox" id="select_all" class="mr-2">
                                <button type="button" id="update_status" class="btn btn-success">Check</button>
                            </div>
                        </th>
                        <!-- Checkbox for selecting all rows -->

                    </tr>
                </thead>
            </table>
        </div>

        <br />
        <br />
    </div>

</body>

</html>

<script>
    $(document).ready(function() {

        var filterApplied = false;
        var authUserOfficeId = '{{ Auth::user()->office }}';
       

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
                    //checkbox in first col                  
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
                        data: 'longOfficeName',
                        name: 'longOfficeName'
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
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: null,
                        name: 'checkbox',
                        // render: function(data, type, row, meta) {
                        //     return `<input type="checkbox" class="checkbox" data-id="${row.id}">`; // Add checkbox for each row
                        // },
                        render: function(data, type, row, meta) {

                            if (row.reportToOffice != authUserOfficeId) {
                            return '';  // Hide checkbox
                        }

                            return `<input type="checkbox" class="checkbox" data-id="${row.id}">`;
                        },
                        orderable: false,
                        searchable: false
                    },
                ],
                rowCallback: function(row, data, index) {
                    $('td:eq(0)', row).html(index + 1); // Update Sl No in the first column

                    if (!filterApplied) {

                    if (data.reportToOffice != authUserOfficeId) {
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

        // all for checkbox 
        // Select/Deselect all checkboxes
        $('#select_all').click(function() {
            var isChecked = this.checked;
            $('.checkbox').each(function() {
                this.checked = isChecked;
            });
        });

        // Update Status for selected checkboxes
        $('#update_status').click(function() {
            var selectedIds = [];
            $('.checkbox:checked').each(function() {
                selectedIds.push($(this).data('id')); // Get the ids of the selected rows
            });

            if (selectedIds.length > 0) {
                // Show confirmation dialog
                var confirmation = confirm("Do you want to update the status?");

                if (confirmation) {
                    // If the user clicks 'Yes', perform the Ajax request to update the status Approved
                    $.ajax({
                        url: "{{ route('attendanceReview.updateStatus') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: selectedIds
                        },
                        success: function(response) {
                            // alert('Status Updated Successfully');
                            var successMessage = $('<div class="alert alert-success">Status Updated Successfully</div>');
                            $('body').append(successMessage);
                            successMessage.fadeIn();
                            // Hide the success message after 3 seconds

                            setTimeout(function() {
                                successMessage.fadeOut(function() {
                                    successMessage.remove();
                                });
                            }, 10000);

                            $('#att_data').DataTable().ajax.reload(); // Reload the table after updating status
                        },
                        error: function(error) {
                            alert('Failed to update status');
                        }
                    });
                } else {
                    // If the user clicks 'No', do nothing
                    return false;
                }
            } else {
                alert('Please select at least one row');
            }
        });

    });
</script>