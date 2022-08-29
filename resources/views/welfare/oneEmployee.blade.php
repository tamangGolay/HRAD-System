<!DOCTYPE html>

<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <title>Validate form</title>
    <!-- library bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- library js validate -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="/js/validate.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
    <style>
    
    a {
        color: black !important;
        text-decoration: none;
    }
    </style>
</head>
<body>
    <style>
        .error {
            color: red;
            border-color: red;
        }
    </style>
<div class="container-fluid">
<div class="row ">
  <div class="col">
    <div class="card ">
      <div class="card-header bg-green">
        <div class="col text-center">
          <h5>
                <b> Add Individual Employee Contribution</b>
              </h5>
			</div>
		
      </div>
        <br><br>
        <span id="message_error"></span>
        
        <form id="validate" action="save" method="post">
            @csrf  
            <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
            <!-- <input type="text" id="myInput1" onchange="myChangeFunction(this)" placeholder="type something then tab out" /> -->
            <!-- <input type="text" id="myInput2" /> -->
            <!-- <input type="text" id="myInput3" /> -->

            <table id="emptbl" class="table table-bordered border-dark">
                <thead style="background-color: #E7E7E7;">
                    <tr>
                        <th>Employee Number</th>
                        <th>Amount</th>
                        <th>Year</th> 
                        <th>Month</th> 
                        <th>Office</th> 

                    </tr>
                </thead>
                <tbody>
                <tr><input type="hidden" class="form-control" id="slno" name="slno[]" readonly></tr> 

                    <tr> 
                    <?php 
                    $empId = 3000;
                    $amount = 385;

                    ?>


                        <td id="col0"><input type="number" value="{{$empId}}" class="form-control" id="empId" name="empId[]" placeholder="Enter employee Number" required></td> 
                        <td id="col1"><input type="number" value="{{$amount}}" class="form-control" name="amount[]" required></td> 
                        <td id="col2"> 

                        <input type="hidden" class="form-control" name="contributionDate[]" id="contributionDate" >

                            <select class="form-control" name="Year[]" id="year" required> 
                                <option selected disabled>-- Select Year--</option> 
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>


                            </select> 
                        </td> 

                        <td id="col3"> 
                            <select class="form-control" name="month[]" id="month" required> 
                                <option selected disabled>-- Select Month--</option> 
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">Novemeber</option>
                                <option value="12">December</option>

                            </select> 
                        </td> 
                        <td id="col4" > 

<select class="form-control" name="officeName[]" id="officeName" required>
                     <option value="">Select Office</option>
                     @foreach($officedetails as $officedetails)
                     <option value="{{$officedetails->id}}">{{$officedetails->officeDetails}}</option>
                @endforeach
    </select>

</td>
                    </tr>
                </tbody>  
            </table> 
            <table align= "center">
                <br>
                <tr> 
                    <td><button type="button" class="btn btn-outline-info" onclick="addRows()">Add More</button></td>
                    <td><button type="button" class="btn btn-outline-danger" onclick="deleteRows()">Remove</button></td>
                    <td><button type="submit" class="btn btn-outline-success">Save Records</button></td> 
                </tr>  
            </table>
        </form>
    </div>

    </div>
    </div>
    </div>

    <script>
        function addRows()
        { 
            var table = document.getElementById('emptbl');
            var rowCount = table.rows.length;
            document.getElementById("slno").value = table.rows.length - 1;
            // document.getElementById("empId").value[0] = document.getElementById("empId").value;
            var cellCount = table.rows[0].cells.length; 
            var row = table.insertRow(rowCount);
            for(var i =0; i <=cellCount -1; i++)
            {
                // var a= document.getElementById("empId").value;
                // alert(a)

                var cell = 'cell'+i;
                cell = row.insertCell(i);
                var copycel = document.getElementById('col'+i).innerHTML;
                cell.innerHTML=copycel;
                if(i == 5)
                { 
                    var radioinput = document.getElementById('col3').getElementsByTagName('input'); 
                    for(var j = 0; j <= radioinput.length; j++)
                    { 
                        if(radioinput[j].type == 'radio')
                        { 
                            var rownum = rowCount;
                            radioinput[j].name = 'gender['+rownum+']';
                        }
                    }
                }
            }
        }

        function deleteRows()
        {
            var table = document.getElementById('emptbl');
            var rowCount = table.rows.length;

            if(rowCount >= '4')
            {
                var row = table.deleteRow(rowCount-1);
                rowCount--;
                document.getElementById("slno").value = table.rows.length - 2;

            }else{
                alert('There should be atleast one row');
            }
        }
    </script>
    <!-- alert blink text -->
    <script>
        // function blink_text()
        // {
        //     $('#message_error').fadeOut(700);
        //     $('#message_error').fadeIn(700);
        // }
        // setInterval(blink_text,1000);
    </script>
    <!-- script validate form -->
    <script>
        $('#validate').validate({
            reles: {
                'empId[]': {
                    required: true,
                },
                'amount[]': {
                    required:true,
                },
                'year[]': {
                    required:true,
                },
                'month[]': {
                    required:true,
                },
            },
            messages: {
                'empId[]' : "Please input file*",
                'amount[]' : "Please input file*",
                'year[]' : "Please input file*",
                'month[]' : "Please input file*",

            },
        });
    </script>

<script>
    var today = new Date();
	var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
	document.getElementById("contributionDate").value = date;
</script>



<!-- <script type="text/javascript">
  function myChangeFunction(empId) {
    var empId = document.getElementById('empId');

    empId.value = empId.value;

  }
</script> -->

</body>
</html>