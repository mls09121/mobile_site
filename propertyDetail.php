<?php 
require_once('Assets/phpFunctions.php');
?>
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
	<style type="text/css">
		td {cursor: pointer;}
	</style>
	<script type="text/javascript">
		function folderDetails(id){
			window.location='propertyInfo.php?id=' + id;
		}
	</script>

</head>
<body>
<?php
	include('/Assets/navMenu.php');

	$PropertyRSN=$_GET['propertyRSN'];
	$sql = "{call www_GetPropertiesStep2(?)}";
	$params = array($PropertyRSN, SQLSRV_PARAM_IN);
	$rs = getRecordset($sql, $params);
?>
<!-- Page Content -->
<div>&nbsp;</div>
 <div class="container">
 	<input type="button" class="btn btn-primary" onClick="location.href='property.php';" value="Go Back" />
 	<h2>Property RSN / Address</h2>
	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<th colspan="2">Folder Type</th>
				<th>Folder Date / Sequence/ Section/ Revision</th>
				<th>Reference File</th>
				<th>InDate</th>
				<th>Status Desc</th>
				<th>Sub Code</th>
				<th>Work Code</th>
				<th>Folder Name</th>
			</tr>
		</thead>
		<tbody>
		<?php
		for($i=0; $i<sizeof($rs)-1; $i++){ 
			?>
			<tr onclick="folderDetails(<?php echo $rs[$i]["FolderRSN"]; ?>);">
				<td style="width: 4px;" bgcolor="#<?php echo dechex($rs[$i]["Colour"]); ?>"></td>
				<td><?php echo $rs[$i]['FolderType']; ?></td>
				<td><?php echo $rs[$i]['FolderDate'] . '   ' . $rs[$i]['FolderSequence'] . '   ' . $rs[$i]['FolderSection'] . '   ' . $rs[$i]['FolderRevision']; ?></td>
				<td><?php echo $rs[$i]['ReferenceFile']; ?></td>
				<td><?php echo date_format($rs[$i]['Indate'], 'm-d-Y'); ?></td>
				<td><?php echo $rs[$i]['StatusDesc']; ?></td>
				<td><?php echo $rs[$i]['SubCode']; ?></td>
				<td><?php echo $rs[$i]['WorkCode']; ?></td>
				<td><?php echo $rs[$i]['FolderName']; ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>

  </div>
</body>
</html>