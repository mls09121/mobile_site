<?php 
require_once('Assets/phpFunctions.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Amanda Mobile</title>

    <link href="/Assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">

    <script src="/Assets/js/jquery-1.11.3.min.js"></script>
    <script src="/Assets/bootstrap/js/bootstrap.min.js"></script>

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

    <!-- Page Content -->
    <div class="container">
	<h3>Deficiency Info</h3>
	<?php
	$DeficiencyCode = 9905;
	$ProcessRSN = 16352623;
	$sql = "{Call www_GetDeficiencyReport(?,?)}";
	$params = array(array($ProcessRSN, SQLSRV_PARAM_IN), array($DeficiencyCode, SQLSRV_PARAM_IN));	
	$rs = getRecordset($sql, $params);	
	?>
	<table class='table'>
	<thead>
	<tbody>
		<tr>
			<th>Cat</th>
			<td><?php echo $rs[0]['CategoryDesc'] ?></td>
			<th>SubCat</th>
			<td><?php echo $rs[0]['SubCategoryDesc'] ?></td>
		<th>Deficiency Code</th>	
			<td><?php echo $rs[0]['DeficiencyCode']; ?></td>

		</tr>
		<tr>
			<th>Deficiency</th>
			<td colspan ="2"><?php echo $rs[0]['DeficiencyDesc']; ?></td>
			<th>Remedy</th>
			<td><?php echo $rs[0]['RemedyDesc']; ?></td>
			<td></td>
		</tr>
		<tr>

		<td colspan = "2" rowspan ="2"><?php echo $rs[0]['DeficiencyText']; ?></td>
		<td></td>
		<td colspan = "3" rowspan ="3"><?php echo $rs[0]['RemedyText']; ?></td>
		</tr>
		<tr></tr>
		<tr></tr>
		<tr>
			<th>In Date</th>
			<td><?php echo $rs[0]['InsertDate']; ?></td>
			<th>Comply By</th>
			<td><?php echo $rs[0]['ComplyByDate']; ?></td>
				<th>Complied</th>
			<td><?php echo $rs[0]['DateComplied']; ?></td>
			<th>Reference Num</th>
			<td><?php echo $rs[0]['ReferenceNum']; ?></td>
		</tr>
		<tr>
			
			<th>Severity</th>
			<td><?php echo $rs[0]['SeverityDesc']; ?></td>
			<th>Status</th>
			<td><?php echo $rs[0]['StatusDesc']; ?></td>
		</tr>	
		<tr>
			<th>User</th>
			<td><?php echo $rs[0]['UserName']; ?></td>
			<th>Location</th>
			<td><?php echo $rs[0]['LocationDesc']; ?></td>
			<th>Sub</th>
			<td><?php echo $rs[0]['SubLocationDesc']; ?></td>
			<th>Occurances</th>
			<td><?php echo $rs[0]['OccuranceCount']; ?></td>
		</tr>
		</thead>
		</tbody>
	</table>
			
	
	
	
	
	
	
	    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="/bootstrap/js/jquery-1.11.3.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>