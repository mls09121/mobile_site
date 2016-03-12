<?php 
require_once('Assets/phpFunctions.php');
require_once('Assets/tableFunctions.php');
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
	<?php 
	include('/Assets/navMenu.php');
	?>
    <!-- Page Content -->
    <div class="container">
<h1>Search By Folder RSN Number</h1>
<h3>Enter A Folder RSN Number to Search For</h3>
<form id="frmSearch" name="frmSearch" method="POST" action="folder.php">
<input type="text" name="FolderRSN"/>
<input type="submit" class="btn btn-primary" name="btnSubmit" value="Search" />

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="/bootstrap/js/jquery-1.11.3.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>
<?php
if(isset($_POST['btnSubmit'])){
	$FolderRSN = $_POST['FolderRSN'];
	if(!is_numeric($FolderRSN)){   	
		$errorMessage="All folder numbers contain only numeric values. Please search again.";
		echo "<div class='alert-box'><div class='alert alert-danger fade in'>";
		echo "<a href='#' class='close' data-dismiss='alert'>&times;</a>";
		echo "<strong>Error!</strong> $errorMessage</div></div>";
			}				
	if(strlen($FolderRSN)>15){		
		$errorMessage="All folder numbers are between 1 and 15 digits long. Please correct the error and search again.";
		echo "<div class='alert-box'><div class='alert alert-danger fade in'>";
		echo "<a href='#' class='close' data-dismiss='alert'>&times;</a>";
		echo "<strong>Error!</strong> $errorMessage</div></div>";
			}

	if(strlen($FolderRSN)<15 && is_numeric($FolderRSN)){
		$url = "folderInfo.php?FolderRSN=$FolderRSN";
header("Location: ".$url);
	}
}


?>
