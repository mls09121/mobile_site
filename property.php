<?php 
require_once('Assets/phpFunctions.php');

$userAddress="";
$isPostBack=false;
$pageSize=5;
$currentPage=getCurrentPage();

//defaults
$orderBy="PropHouseNumeric";
$sortDirection="ASC";

if(getVariable("txtAddress") != ""){
	$isPostBack=true;
	//this needs to be sanitized
	$userAddress=getVariable("txtAddress");
	$orderBy=getVariable("orderBy");
	$sortDirection=getVariable("sortDirection");
}


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
    <script type="text/javascript">
		function jumpToPage(p){
			$("#pageNumber").val(p);
			$("#frmSearch").submit();
		}
		
		function propertyDetails(id){
			window.location='propertyDetail.php?propertyRSN=' + id;
		}
		
		function sortColumn(field, direction){
			$("#orderBy").val(field);
			$("#sortDirection").val(direction);
			$("#frmSearch").submit();
		}
	</script>
	<style type="text/css">
		td {cursor: pointer;}
	</style>
</head>
<body>
	<?php 
	include('/Assets/navMenu.php');
	?>
	<div class="container">
		<h1>Search By Property Address</h1>
		<form id="frmSearch" name="frmSearch" method="post" action="property.php">
			<input type="hidden" name="orderBy" id="orderBy" value="<?php echo $orderBy; ?>" />
			<input type="hidden" name="sortDirection" id="sortDirection" value="<?php echo $sortDirection; ?>" />
			<input type="hidden" name="pageNumber" id="pageNumber" value="<?php echo $currentPage; ?>" />
			<h3>Enter the House Number and St. Name of a Property</h3>
			<div><input type="text" name="txtAddress" maxlength="50" value="<?php echo $userAddress; ?>" />&nbsp;
			<input type="submit" class="btn btn-primary" name="btnSubmit" value="Search" /></div>
		</form>
	</div>
	<?php
	if($isPostBack==true && $userAddress != ""){
		SetSessionData('PropertySearchValue', $userAddress);
	
		if($currentPage<=1){
			$startPage = 0;
		}
		else{
			$startPage = $currentPage * $pageSize - $pageSize;
		}

		$sql = "{call www_GetTotalRecords(?)}";
		$params = array($userAddress, SQLSRV_PARAM_IN);
		$tr = getRecordset($sql, $params);

		$totalRecords = $tr[0][0];
	
		$sql = "{call www_GetProperties(?, ?, ?, ?, ?)}";
		$params = array(array($userAddress, SQLSRV_PARAM_IN), array($currentPage, SQLSRV_PARAM_IN), array($pageSize, SQLSRV_PARAM_IN), array($orderBy, SQLSRV_PARAM_IN), array($sortDirection, SQLSRV_PARAM_IN));
		$rs = getRecordset($sql, $params);
		
		
		if($totalRecords==0) {
			?>
			<div class="container">No Results Found</div>
			<?php
		}
		else {
			?>
	
			<div class="container">
				<table class="table table-hover table-rounded table-striped">
					<thead>
						<tr>
							<th><a href="#" onclick="sortColumn('ParcelId', '<?php if($orderBy!="ParcelId"){echo "ASC";}else{if($sortDirection=="ASC"){echo "DESC";}else{echo "ASC";}}?>');">Parcel ID</a></th>
							<th><a href="#" onclick="sortColumn('PropHouseNumeric', '<?php if($orderBy!="PropHouseNumeric"){echo "ASC";}else{if($sortDirection=="ASC"){echo "DESC";}else{echo "ASC";}}?>');">Address</a></th>
							<th>Property Image</th>
						</tr>
					</thead>
					<tbody>
						<?php
						for($i=0; $i<sizeof($rs)-1; $i++){ 
	
							$parcelId=$rs[$i]['ParcelId'];
							$propertyRSN=$rs[$i]['PropertyRSN'];
	
							if(substr($rs[$i]['PropAddress'],0)!=0)
							{	
							?>
								<tr onclick="javascript:propertyDetails(<?php echo $propertyRSN; ?>);">
									<td><?php echo $rs[$i]["ParcelId"]; ?></td>
									<td><?php echo $rs[$i]["PropAddress"]; ?></td>
									<td><img src="<?php echo $rs[$i]['ImageUrl']; ?>" alt="" border="1" height="100" width="100"></td>
								</tr>
							<?php
							}	
						}
						?>
					</tbody>
				</table>
				
				<?php
				$totalPages = ceil($totalRecords / $pageSize);
				
				if($totalPages > 1){
					?>
					<div>
						<div>Jump to Page</div>
						<div>
						<ul class="pagination pagination-lg">
							<?php
							
							
							for($i=0; $i<$totalPages; $i++) {
								if($i==($currentPage-1))
								{
									echo "<li class= 'active'><a href=\"javascript:jumpToPage(" . ($i + 1) . ");\">" . ($i + 1) . "</a></li>&nbsp;\r\n";
								}
								else{
									echo "<li><a href=\"javascript:jumpToPage(" . ($i + 1) . ");\">" . ($i + 1) . "</a></li>&nbsp;\r\n";
								}
								if($i>=9){
									echo "<li class='disabled'><a href='#'>...</a></li>";
									echo "<li><a href=\"javascript:jumpToPage(".$totalPages.");\">".$totalPages. "</a></li>&nbsp;\r\n";
									die;
								}
							}
							?>
						</ul>
						</div>	
					</div>
					<?php
				}
				?>
				
				
			</div>
			<?php
		} 
	}
	?>

</body>
</html>


