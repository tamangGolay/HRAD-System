<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Certificate Data Report</title>

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
    <!-- Message Box -->
    <div id="statusMessage" class="alert" style="display: none;"></div>
    <br>

    <!-- Dropdown -->
    <div class="row mb-3">
        <div class="col-md-12 d-flex justify-content-center">
            <div class="form-group row align-items-center" style="gap: 15px;">
                <div class="col-auto">
                    <label for="certificateType" class="mb-0">Select Certificate Type:</label>
                </div>

                <div class="col-auto">
                    <select name="certificateType" id="certificateType" class="form-control" required style="min-width: 250px;">
                        <option value="">Select Type</option>
                        @foreach([                            
                            'Completion' => 'Completion',
                            'Appreciation' => 'Appreciation',
                            'Participation' => 'Participation'
                        ] as $key => $cerType)
                            <option value="{{ $key }}">{{ $cerType }}</option>
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
            </div>
        </div>
    </div>

    <!-- Hidden Emp ID -->
    <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId">

    <!-- Title -->
    <div class="reviewTitle card-header bg-green text-center mb-3">
        <h5><b>Certificate Data Report</b></h5>
    </div>

    <!-- DataTable -->
    <div class="table-responsive">
        <table id="reportPage" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Certificate Id</th>
                    <th>Certificate Type</th>
                    <th>Title</th>
                    <th>Name</th>
                    <th>CID</th>
                    <th>EID</th>
                    <th>Office</th>
                    <th>Designation</th>
                    <th>Training Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Institute</th>
                    <th>Place</th>
                    <th>Signer1 Name</th>
                    <th>Signer1 Designation</th>
                    <th>Signer2 Name</th>
                    <th>Signer2 Designation</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


<script>
$(document).ready(function() {
    function loadDataTable(cerType = '') {
        $('#reportPage').DataTable({
            "aLengthMenu": [[20, 40, 60, 100, -1], [20, 40, 60, 100, "All"]],
            dom: 'Blfrtip',
            buttons: ['copy', 'excel', 'csv', 'print'],
            processing: true,
            serverSide: true,
            destroy: true,
            scrollX: true,
           
            order: [[1, 'desc']],
            ajax: {
                url: "{{ route('CertificateData.getData') }}", // your route
                data: function(d) {
                    // Only send certificateType if user selected something
                    let cerType = $('#certificateType').val();
                    if (cerType) {
                        d.certificateType = cerType;
                    } else {
                        d.certificateType = '___empty___'; // something your server can detect to return zero rows
                    }
                }
    
            },
            
            columns: [
                { 
                    data: null,
                    render: function(data, type, row, meta) { return meta.row + 1; }
                },
                { data: 'certificateId', name: 'certificateId' },
                { data: 'cerType', name: 'cerType' },
                { data: 'title', name: 'title' },
                { data: 'name', name: 'name' },
                { data: 'CID', name: 'CID' },
                { data: 'EID', name: 'EID' },
                { data: 'Office', name: 'Office' },
                { data: 'designation', name: 'designation' },
                { data: 'trainingName', name: 'trainingName' },
                { data: 'startDate', name: 'startDate' },
                { data: 'endDate', name: 'endDate' },
                { data: 'instituteName', name: 'instituteName' },
                { data: 'place', name: 'place' },
                { data: 'signer1Name', name: 'signer1Name' },
                { data: 'signer1Designation', name: 'signer1Designation' },
                { data: 'signer2Name', name: 'signer2Name' },
                { data: 'signer2Designation', name: 'signer2Designation' }
            ]
        });
    }

    loadDataTable();

    $('#filter').click(function() {
        loadDataTable($('#certificateType').val());
    });

    $('#reset').click(function() {
        $('#certificateType').val('');
        loadDataTable();
    });
});
</script>
