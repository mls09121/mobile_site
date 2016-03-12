<?php 
require_once('Assets/phpFunctions.php');
require_once('Assets/tableFunctions.php');

$PropertyRSN=getVariable("PropertyRSN");
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
	<style>
	#clickable td {cursor: pointer;}
		#topDiv{    background: #E2CFB6;}
		#b{ background: #B7DBFF;}
		#c{ background: #C2F2D0;}
		#d{ background: #B5F1F1;}
	</style>
	<link href="/Assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="/Assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="/Assets/css/style.css" rel="stylesheet">
	
	<script src="/Assets/js/jquery-1.11.3.min.js"></script>
	<script src="/Assets/bootstrap/js/bootstrap.min.js"></script>
	<script>
	function peopleInfo(id){
				window.location='peopleInfo.php?PeopleRSN=' + id;
			}
	</script>
	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->
</head>
<body>
<?php 
include('/Assets/navMenu.php');
?>
<div class="container">
	
	<br />
	
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#property">Property</a></li>
		<li><a data-toggle="tab" href="#people">People</a></li>
		<li><a data-toggle="tab" href="#info">Info</a></li>
	</ul>
	
	<div class="tab-content">
		<div id="property" class="tab-pane fade in active">
		<div id="d">
			<?php
				get_PropertyTable($PropertyRSN);
			?>
			</div>
		</div>
		
		
		<div id="people" class="tab-pane fade">
		<div id="b">
		<?php
				get_PropertyOwnerHistoryTable($PropertyRSN);
			?>
		</div>
		</div>
		
		
		<div id="info" class="tab-pane fade">
		<div id="c">
		<?php
				get_PropertyInfoTable($PropertyRSN);
			?>	
		</div>
		</div>
	</div>
 
   
   <div>
	<input type="button" class="btn btn-primary" onClick="location.href='property.php';" value="Search By Property" />
	<input type="button" class="btn btn-primary" onClick="location.href='folder.php';" value="Search By Folder" />
</div>

   
   
   </div>  
   
   </body>
   </html>
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   