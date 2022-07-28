<?php
	include ('connect.php');
	$empid = $_GET['EID'];
    $sql =  "SELECT empId, empName, cIdNo, designation, grade, office, employmentType, superNumber, superEmailId" .
			" FROM employee4twimc" .
			" where empId = " . $empid .";";
    $result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($result)
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRIS Information System</title>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
	<link rel='icon' href='images/favicon.ico' type='image/x-icon'/>       
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
         <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <script src="scripts/toword.js"></script>

    </head>
    <body>
    <div class="w3-border w3-content w3-margin-top w3-card-4 bgReceipt" id="nodetoprint">
            <img src="images/Header.jpg" alt="Header Picture" class="images">
			<p id=todayDate></p>
           <div class="w3-container w3-margin w3-padding">
               <h2 id="center">To Whom It May Concern</h2>
            <table id="table" class=bodytext>
                <tr><td colspan="2"><span class="labelReceipt">This certificate is to indicate that the following employee is working in BPC as of the above date:</span></td></tr>
                <tr><td colspan="2"> <span class="labelReceipt"> &nbsp; </span> </td></tr>
                <tr><td width="200px"><span class="labelReceipt">Employee Id:</span> </td><td><span class="dataReceipt"><?php echo $row["empId"]; ?> </span></td></tr>
                <tr><td width="200px"><span class="labelReceipt"> Employee Name:</span> </td><td><span class="dataReceipt"> <?php echo $row["empName"]; ?> </span></td></tr>
                <tr><td width="200px"><span class="labelReceipt"> CID No:</span> </td><td><span class="dataReceipt"> <?php echo $row["cIdNo"]; ?> </span></td></tr>
                <tr><td width="200px"><span class="labelReceipt"> Designation: </span> </td><td><span class="dataReceipt"> <?php echo $row["designation"]; ?></span></td></tr>
                <tr><td width="200px"><span class="labelReceipt"> Grade: </span> </td><td><span class="dataReceipt"> <?php echo $row["grade"]; ?></span></td></tr>
				<tr><td width="200px"><span class="labelReceipt"> Office: </span> </td><td><span class="dataReceipt"> <?php echo $row["office"]; ?></span></td></tr>
				<tr><td width="200px"><span class="labelReceipt"> Employment Type: </span> </td><td><span class="dataReceipt"> <?php echo $row["employmentType"]; ?></span></td></tr>
            </table>
        <br>
		<div id="note">This is a system generated document and you may call <?php echo $row["superNumber"]; ?> or email <?php echo $row["superEmailId"]; ?> to authenticate the same.</div>
        <br>
		<form id ="printing">
            <input id = "print" type="button" title="Choose save as pdf for saving" value="Print/Save" onclick="printReceipt()"/>
        </form>
      </div>
        <footer class="w3-green w3-container w3-center">
                <p>©2019 <a href = "http://www.bpc.bt"> Bhutan Power Corporation Limited</a></p>
            </footer>
    </div>
    <script>
		const d = new Date();
		dateT = formatDate(d)
		document.getElementById("todayDate").innerHTML = dateT;
		
		function printReceipt(){
            document.getElementById('printing').innerHTML = ('');
            window.print();
        }
		function formatDate(date) {
		  return [
			padTo2Digits(date.getDate()),
			padTo2Digits(date.getMonth() + 1),
			date.getFullYear(),
		  ].join('/');
		}
		function padTo2Digits(num) {
		  return num.toString().padStart(2, '0');
		}
</script>
    </script>
    </body>
</html>