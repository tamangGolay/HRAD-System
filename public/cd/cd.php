<?php
    include ('connect.php');
    $sql = "SELECT users.empID AS EmployeeID, " .
			"users.empName as Name, " .
			"designationmaster.desisNameLong as Designation, " . 
			"officename.longOfficeName as Office, " . 
			"office_address.Address as place, " . 
			"users.fixedNo as telephone, " . 
			"users.mobileNo as Mobile, " . 
			"users.extension as extension, " .
			"users.emailId as Emailid " . 
			"FROM users, designationmaster, officemaster, officename, office_address " . 
			"WHERE users.designationId = designationmaster.id " . 
			"AND users.office = officemaster.id " .
			"AND officemaster.officeName = officename.id " .
			"AND officemaster.officeAddress = office_address.placeId " . 
			"ORDER BY 1;";
    $result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BPC Contact Directory</title>
    <link rel='icon' href='images/favicon.ico' type='image/x-icon'/> 
    <link rel="stylesheet" type="text/css" href="css/style.css"/>      
    <script type="text/javascript" src="scripts/javascript.js"></script>
</head>
<body class="main">
<div class="page-header" >BPC Contact Directory</div>
    <br><br>
    <table id="searchlink"><tr>
            <td><input type="text" id="myInput" onkeyup="myFunction()" placeholder="Type search term here.." title="Search"></td>
    </tr></table>
<table id="myTable">
    <tr class="tablehead">
        <th style="width:5%;">Picture</th>
	<th style="width:7%;">EmpID</th>
        <th style="width:12%;">Name</th>
        <th style="width:13%;">Designation</th>
	<th style="width:15%;">Office</th>
	<th style="width:8%;">Place</th>
        <th style="width:7%;">Telephone</th>
	<th style="width:7%;">Mobile</th>
	<th style="width:5%;">Extension</th>
	<th style="width:19%;">Email</th>
    </tr>
  <?php
    while ($row = mysqli_fetch_array($result)){
        $img="images/" . $row["EmployeeID"] . ".jpg";
  ?>
  <tr class="tablebody">
        <td style="width:5%;"><img style="display:block;" width="100%" height="70px" src="<?php echo $img ?>" alt="No Pic"/></td>
        <td style="width:7%;"><?php echo $row["EmployeeID"] ?></td>
        <td style="width:12%;"><?php echo $row["Name"] ?></td>
        <td style="width:13%;"><?php echo $row["Designation"] ?></td>
        <td style="width:15%;"><?php echo $row["Office"] ?></td>
        <td style="width:8%;"><?php echo $row["place"] ?></td>
        <td style="width:7%;"><?php echo $row["telephone"] ?></td>
        <td style="width:7%;"><?php echo $row["Mobile"] ?></td>
        <td style="width:5%;"><?php echo $row["extension"] ?></td>
        <td style="width:19%;"><?php echo $row["Emailid"] ?></td>
  </tr>
  <?php } ?>
</table>
<div class="footer">
    <p>BPC Contact Directory ©2019 <a href = "http://www.bpc.bt"> Bhutan Power Corporation Limited</a></p>
</div>
<noscript>
You have no java script enabled so search function is not available.
</noscript>

</body>
</html>
