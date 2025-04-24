<style>
    .releaseDetails {

        font-family: "Times New Roman", Times, serif;
        font-size: 25px;
    }

    .textfont {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
    }
</style>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">


                <div class="releaseDetails card-header bg-green  d-flex justify-content-center"> <strong>Reset Device ID</strong> </div>
                <!--/card-header-->
                <div class="textfont card-body">
                    <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
                    <div class="form-group row">
                        <label for="emp_id" class="col-md-4 col-form-label text-md-right">&nbsp;&nbsp;&nbsp;Emp Id:</label>
                        <div class="col-sm-10 col-md-6 col-lg-4">

                            <input type="number" id="emp_id" class="form-control" placeholder="Employee Number" onKeyPress="if(this.value.length==8) return false;
					       if( isNaN(String.fromCharCode(event.keyCode))) return false" ; name="EmpId" value="{{ old('EmpId') }}"
                                autocomplete="EmpId" onFocusOut="checkEmployee(this.value);"
                                onKeyup=" if(this.value.length==8) getEmployeeDetails(this.value) 
							  if(this.value[0] == 3 || this.value[0] == 9) empcheck (this.value) ;" required>

                        </div>

                        <span id="info" class="text-danger text-md-right"></span>
                        <div class="col-sm-2">
                            <span id="empid" class="text-danger"></span>
                        </div>
                    </div>

                    <div class=" textfont form-group row">
                        <label class="col-md-4 col-form-label text-md-right" for="nameid">&nbsp;&nbsp;&nbsp;Name:</label>
                        <div class="col-sm-10 col-md-6 col-lg-4">
                            <input type="text" name="empName" class="form-control" id="empName" placeholder="Name" readonly required>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12 ">
                            <button id="resetBtn" class="btn btn-outline-success btn-lg">Reset</button>
                        </div>
                    </div>

                    <div id="responseMessage" style="margin-bottom: 20px; text-align: center;"></div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{URL::asset('/admin-lte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>



<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {

        document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';

    });

    function getEmployeeDetails(val) {
        //pulling records using empid from checkin table

        var csrftoken = document.getElementById('tokenid').value;

        $.get('/getValues?source=getName&info=' + val + '&token=' + csrftoken, function(data) {
            console.log(data);

            document.getElementById('empName').value = '';

            document.getElementById('empid').innerHTML = '';

            $.each(data, function(index, Employee) {


                if (Employee.empName != null) {
                    document.getElementById('empName').value = Employee.empName;

                    document.getElementById('empId').innerHTML = '';
                } else {
                    document.getElementById('empid').innerHTML = 'Please check your Employee ID!!!';
                    document.getElementById('emp_id').value = '';
                }
            })
        });
    }
</script>

<script>
    function empcheck() {

        if (document.getElementById('emp_id').value[0] == '3' || document.getElementById('emp_id').value[0] == '9') {
            document.getElementById('empid').innerHTML = '';
        }
    }

    $('#resetBtn').on('click', function(e) {
        e.preventDefault();

        const empId = $('#emp_id').val().trim();

        if (!empId) {
            document.getElementById('empid').innerHTML = 'Please enter an Employee ID.';
            return;
        }

        // Clear previous message
        document.getElementById('empid').innerHTML = '';

        $.ajax({
            url: '/reset-device', // Update this URL to your Laravel route
            method: 'POST',
            data: {
                empId: empId,
                _token: '{{ csrf_token() }}'
            },

            success: function(response) {
                document.getElementById('responseMessage').innerHTML = '<span style="color:green;">' + response.message + '</span>';
            },
            error: function(xhr) {
                document.getElementById('responseMessage').innerHTML = '<span style="color:red;">Error: ' + xhr.responseText + '</span>';
            }
        });
        setTimeout(function() {
            document.getElementById('responseMessage').innerHTML = '';
        }, 3000); // 3 sec
    });
</script>