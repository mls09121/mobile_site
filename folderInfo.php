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

	<style>
		input[disabled]{background-color:#F0F0F0; color:#303030;}
		#topDiv{    background: #E2CFB6;}
		#b{ background: #B7DBFF;}
		#c{ background: #C2F2D0;}
		#d{ background: #B5F1F1;}
		#clickable td {cursor: pointer;}
		
	</style>

    <title>Amanda Mobile</title>
	
	<link href="/Assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="/Assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
	
	<script type="text/javascript" src="/Assets/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="/Assets/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		function peopleInfo(id){
			window.location='peopleInfo.php?PeopleRSN=' + id;
		}
		
		function propertyInfo(id){
			window.location='propertyInfo.php?PropertyRSN=' + id;
		}
		
		function processInfo(id){
			if($("#lastIframe").val() != "none"){
				lastIframe = $("#lastIframe").val();
				$(lastIframe).slideUp();
			}
		
			$("#iProcess_" + id).attr("src", "processinfo.php?ProcessRSN=" + id);
			$("#trProcess_" + id).slideDown('slow');
			$("#lastIframe").val("#trProcess_" + id);
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

   
	if(!empty($_GET['FolderRSN'])){
    $FolderRSN=$_GET["FolderRSN"];}
	else{$FolderRSN = $_GET['id'];}
    ?>
<div class='container'>

<input type="hidden" id="lastIframe" value="none" />


<br />
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#folder">Folder</a></li>
    <li><a data-toggle="tab" href="#property">Property</a></li>
    <li><a data-toggle="tab" href="#people">People</a></li>
    <li><a data-toggle="tab" href="#info">Info</a></li>
	<li><a data-toggle="tab" href="#fees">Fees/ Charge</a></li>
	<li><a data-toggle="tab" href="#process">Process</a></li>
	<li><a data-toggle="tab" href="#document">Document</a></li>
	<li><a data-toggle="tab" href="#comments">Comments</a></li>
  </ul>

<div class="tab-content">
    <div id="folder" class="tab-pane fade in active">
      <h3>Folder</h3>
   
<?php
				$PropertyRSN = get_FolderTable($FolderRSN);
			?>

</div>
	
	<div id="property" class="tab-pane fade">
		<h3>Property</h3>	  
		<br />
		<div id='c' onclick="javascript:propertyInfo(<?php echo $PropertyRSN; ?>);">
			<?php
				get_PropertyTable($PropertyRSN);
			?>
		</div>
	</div>
	
	<div id="people" class="tab-pane fade">
		<h3>People</h3>
		<br />
		<div id='d'>
			<?php
				get_FolderPeopleTable($FolderRSN);
			?>
		</div>
	</div>
	
	<div id="info" class="tab-pane fade">
		<h3>Info</h3>
		<br />
		<div id='topDiv'>
			<?php
				get_FolderInfoTable($FolderRSN);
			?>
		</div>
	</div>
	
	<div id="fees" class="tab-pane fade">
		<h3>Fees</h3>
		<br />
		<<div id ="b">
			<?php
				get_FolderFeesTable($FolderRSN);
			?>
		</div>
	</div>
	<div id="process" class="tab-pane fade">
		<h3>Process</h3>
		<br />
		<div id="c">
		<?php
		get_FolderProcessTable($FolderRSN);
		?>
			</div>
		</div>
	<div id="document" class="tab-pane fade">
		<h3>Document</h3>
		<br />
		<div id="d">
		<?php
		get_FolderDocumentInfoTable($FolderRSN);
		?>
			</div>
		</div>
	<div id="comments" class="tab-pane fade">
		<h3>Comments</h3>
		<br />
		<div id="topDiv">
		<?php
		get_FolderComments($FolderRSN);
		?>
			</div>
		</div>
	
	</div>
	
	

<!-- Modal -->
<div style="min-height: 700px; min-width: 800px;" class="modal fade" id="iProcessDetails" tabindex="-3" aria-labelledby="ModalLabel" aria-hidden="true">
  <div>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="ModalLabel">Process Info</h4>
      </div>
      <div class="modal-body">
	      
	      <iframe src="processinfo.php?ProcessRSN=" id="iProcessInfo" scrolling="yes" style="top: 0; right: 0; left: 0; bottom: 0; min-width: 800px; min-height: 700px;" frameborder="0" height="100%" width="100%"></iframe>
	      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Button Label</button>
      </div>
    </div>
  </div>
</div>

<div>
	<input type="button" class="btn btn-primary" onClick="location.href='property.php';" value="Search By Property" />
	<input type="button" class="btn btn-primary" onClick="location.href='folder.php';" value="Search By Folder" />
</div>







</body>

</html>