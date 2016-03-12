
<?php

/**************************************************************************************************************************/
function get_PropertyTable($PropertyRSN) {
	$sql = "{Call www_GetPropertyInfo(?)}";
	$params = array(array($PropertyRSN, SQLSRV_PARAM_IN));	
	$rs2 = getRecordset($sql, $params);	
	$address = implode(' ', array($rs2[0]['PropHouse'],  $rs2[0]['PropStreet'], $rs2[0]['PropStreetType'], $rs2[0]['PropStreetPrefix'], $rs2[0]['PropStreetDirection']));
	$unit =$rs2[0]['PropUnit'].' '.$rs2[0]['PropUnitType'];
	?>
	<table class='table' id='clickable'>
		<tr>
			<th>Address</th>
			<td><?php echo $address ?></td>
			<td><?php echo $unit ?></td>
		</tr>
		<tr>
			<th>City</th>
			<td><?php echo $rs2[0]['PropCity']; ?></td>
			<th>Zip</th><td><?php echo $rs2[0]['PropPostal']; ?></td>
		</tr>
		<tr>
			<th>Tax ID</th>
			<td><?php echo $rs2[0]['PropertyRoll']; ?></td>
			<th>Voting District</th>
			<td><?php echo $rs2[0]['PropPlan']; ?></td>
			<td><?php echo $rs2[0]['PropLot']; ?></td>
			<td><?php echo $rs2[0]['PropBlock']; ?></td>
		</tr>
		<tr>
			<th>Name</th>
			<td><?php echo $rs2[0]['PropertyName']; ?></td>
			<th>Prop X</th>
			<td><?php echo $rs2[0]['PropX']; ?></td>
			<th>Prop Y</th>
			<td><?php echo $rs2[0]['PropY']; ?></td>
		</tr>
		<tr>
			<th>Legal Description</th><td><?php echo $rs2[0]['LegalDesc']; ?></td>
		</tr>
		<tr>
			<th>Area SF</th><td><?php echo $rs2[0]['PropArea']; ?></td>
			<th>Frontage FT</th><td><?php echo $rs2[0]['PropFrontage']; ?></td>
			<th>Impervious FT</th><td><?php echo $rs2[0]['PropDepth']; ?></td>
		</tr>
		<tr>
			<th>Zoning</th>
			<td><?php echo $rs2[0]['ZoneType1']; ?></td>
			<td><?php echo $rs2[0]['ZoneType2']; ?></td>
			<td><?php echo $rs2[0]['ZoneType3']; ?></td>
			<td><?php echo $rs2[0]['ZoneType4']; ?></td>
			<td><?php echo $rs2[0]['ZoneType5']; ?></td>
		</tr>
		<tr>
			<th>Parent ID</th>
			<td><?php echo $rs2[0]['ParentPropertyRSN']; ?></td>
			<th>Row ID</th><td><?php echo $rs2[0]['PropertyRSN']; ?></td>
			<th>Family RSN</th><td><?php echo $rs2[0]['FamilyRSN']; ?></td>
		</tr>
		<tr>
			<th>Notes</th>
			<td colspan="3"><?php echo $rs2[0]["PropDesc"]; ?></td>
		</tr>
	</table>
<?php
	}
/**************************************************************************************************************************/
function get_FolderFeesTable($FolderRSN){
	?>
	<table class="table table-rounded table-striped">
		<thead>
			<tr>
				<th colspan="2">Fee Description</th>
				<th>Fee Amount</th>
				<th>Mandatory</th>
				<th>Bill Num</th>
				<th>Paid in Full?</th>
				<th>Comments</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$sql = "{Call www_GetFees(?)}";
			$params = array(array($FolderRSN, SQLSRV_PARAM_IN));	
			$rs = getRecordset($sql, $params);	
			$RunningTotal=0;
			$CanceledTotal=0;

			for($i=0; $i<sizeof($rs); $i++){
				?>
				<tr>
					<td colspan= "2"><?php echo $rs[$i]['FeeDesc']; ?></td>
					<td><?php echo $rs[$i]['FeeAmount']; ?></td>
					<td <?php if($rs[$i]['MandatoryFlag'] == 'Y'){ ?> class="danger" <?php }?>><input type="checkbox" disabled="disabled" <?php if($rs[0]['MandatoryFlag'] == 'Y'){ ?> checked <?php } ?>/></td>
					<td><?php echo $rs[$i]['BillNumber']; ?></td>
					<td><?php echo $rs[$i]['PaidInFullFlag']; ?></td>
					<td><?php echo $rs[$i]['FeeComment']; ?></td>
				</tr>
				<?php 
				if($rs[$i]['PaidInFullFlag']!='C'){
					$CanceledTotal+=$rs[$i]['FeeAmount'];
				}
				else{
					$CanceledTotal+=$rs[$i]['FeeAmount'];
				}
			
				$RunningTotal+=$rs[$i]['FeeAmount'];
			}
			?>
				
			<tr>
				<td></td>
				<td colspan="3"><b>Total: $<?php echo $RunningTotal; ?></b></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="3"><b>Excluding Canceled and Excluded Bills: $<?php echo $CanceledTotal; ?></b></td>
			</tr>
		</tbody>
	</table>
	<?php
}
/**************************************************************************************************************************/
function get_FolderPeopleTable($FolderRSN){
	$sql = "{Call www_GetPeopleInfo(?)}";
	$params = array(array($FolderRSN, SQLSRV_PARAM_IN));	
	$rs3 = getRecordset($sql, $params);	
	$peopleSize = (array_sum(array_map("count", $rs3)))/165;
	?>	
	<table class="table table-hover table-striped" id='clickable'>
		<thead>
			<tr>
				<th>People RSN</th>
				<th>People Type</th>
				<th>Name</th>
				<th>Organization</th>
				<th>Address</th>
				<th>Phone</th>
			</tr>
		</thead>
		<tbody>
		<?php
		for($i=0; $i<$peopleSize; $i++){
			if($rs3[$i]['Phone1']==8020000000){ 
				$phone="";
			}
			else{
				if(strlen($rs3[$i]['Phone1']) == 10){
					$phone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $rs3[$i]['Phone1']);
				}
				else{
					$phone= $rs3[$i]['Phone1'];
				}
			}
			$PeopleRSN= $rs3[$i]['PeopleRSN'];
			?>
			<tr onclick="javascript:peopleInfo(<?php echo $PeopleRSN; ?>);">
				<td><?php echo $PeopleRSN; ?></td>
				<td><?php echo $rs3[$i]['PeopleDesc']; ?></td>
				<td><?php echo $rs3[$i]['NameFirst']." ".$rs3[$i]['NameLast']; ?></td>
				<td><?php echo $rs3[$i]['OrganizationName']; ?></td>
				<td><?php echo $rs3[$i]['AddressLine1']." ".$rs3[$i]['AddressLine2']; ?></td>
				<td><?php echo $phone; ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
	<?php
}
/**************************************************************************************************************************/
function get_FolderInfoTable($FolderRSN){
	$sql = "{Call www_GetFolderInfoValues(?)}";
	$params = array(array($FolderRSN, SQLSRV_PARAM_IN));	
	$rs = getRecordset($sql, $params);	
	?>
	<table class="table table-rounded table-striped">
		<thead>
			<tr>
				<th>Description</th>
				<th>Value</th>
				<th>Mandatory</th>
			</tr>
		</thead>
		<tbody>
			<?php
			for($i=0; $i<sizeof($rs)-1; $i++){
				?>
				<tr>
					<td><?php echo $rs[$i]['InfoDesc']; ?></td>
					<td><?php echo $rs[$i]['InfoValue']; ?></td>
					<td <?php if($rs[$i]['Mandatory'] == 'Y'){ ?> class="danger" <?php }?> colspan ="0.5"><input type="checkbox" disabled="disabled" <?php if($rs[0]['Mandatory'] == 'Y'){ ?> checked <?php } ?>/></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	<?php
}


/**************************************************************************************************************************/
function get_FolderTable($FolderRSN){
$sql = "{call www_GetFolderInfo(?)}";
$params = array(array($FolderRSN, SQLSRV_PARAM_IN));	
$rs = getRecordset($sql, $params);	

$PropertyRSN = $rs[0]['PropertyRSN'];
$FolderType=$rs[0]['FolderType'];
$sql = "{Call www_GetWorkDesc(?)}";
$params = array(array($FolderType, SQLSRV_PARAM_IN));	
$results = getRecordset($sql, $params);	
$size = (array_sum(array_map("count", $results)))/2;
$sql = "{Call www_GetSubDesc(?)}";
$params = array(array($FolderType, SQLSRV_PARAM_IN));	
$rs1 = getRecordset($sql, $params);	
$subDescSize = (array_sum(array_map("count", $rs1)))/2;
?>
<br />
<div id='topDiv'>
<table class='table'>
<thead>
	<tr>
		<th>Year</th>
		<th>Sequence</th>
		<th>Sec.</th>
		<th>Rev.</th>
		<th>Type</th>
		<th>Status</th>
	</tr>
	<tr>
		<td><?php echo $rs[0]['FolderDate']; ?></td>
		<td><?php echo $rs[0]['FolderSequence']; ?></td>
		<td><?php echo $rs[0]['FolderSection']; ?></td>
		<td><?php echo $rs[0]['FolderRevision']; ?></td>
		<td><?php echo $rs[0]['FolderDesc']; ?></td>
		<td><?php echo $rs[0]['StatusDesc']; ?></td>
	</tr>
	</thead>
	</tbody>
</table>
</div>
<div id='b'>
<table class='table'>
	<thead>
	<tr>
		<th>In Date</th><td><?php echo $rs[0]['InDate']; ?></td>
		<th>Issue/ Approval</th><td><?php echo $rs[0]['IssueDate']; ?></td>
		<th>Expires</th><td><?php echo $rs[0]['ExpiryDate']; ?></td></tr>
		<tr><th>Reference File &#35;</th><td><?php echo $rs[0]['ReferenceFile']; ?></td>
		<th>By</th><td><?php echo $rs[0]['IssueUser']; ?></td>
		<th>Final Date</th><td><?php echo $rs[0]['FinalDate']; ?></td>
	</tr>
	<tr>
		<th>Sub</th><td colspan ="2"><select>
		<option>
		<?php
		echo $rs[0]['SubDesc'];
		echo "</option>";
		for($i=0; $i<$subDescSize; $i++){
		echo "<option>";
		echo $rs1[$i]['SubDesc'];
		echo "</option>";}
		?>
		</select></td>
		<th>Proposed</th><td colspan ="2"><select>
		<option>
		<?php
		echo $rs[0]['WorkDesc'];
		echo "</option>";
		for($i=0; $i<$size; $i++){
		echo "<option>";
		echo $results[$i]['WorkDesc'];
		echo "</option>";}
		?>
		</select></td>
	</tr>
	<tr>
		<th>Name</th><td colspan ="2"><?php echo $rs[0]['FolderName']; ?></td>
		<th>Priority</th><td colspan ="2"><?php echo $rs[0]['Priority']; ?></td>
	</tr>
	<tr>
	<th>Description</th><td colspan="5"><textarea name='description' rows=3 cols=69 disabled="disabled">
 <?php echo $rs[0]["FolderDescription"]; ?>
 </textarea></td>
 </tr>
 <tr>
	<th>Conditions</th><td colspan= "5"><textarea name='conditions' rows=3 cols=69 disabled="disabled">
 <?php echo $rs[0]["FolderCondition"]; ?>
 </textarea></td>
 </tr>
<tr>
	<th>Parent ID</th><td colspan ="2"><?php echo $rs[0]['ParentRSN']; ?></a></td>
	<th>Row ID</th><td colspan ="2"><?php echo $rs[0]['FolderRSN']; ?></a></td>
	</tr>
</thead>
</tbody>
</table>
</div>

<?php
return $rs[0]['PropertyRSN'];
}
/************************************************************************************************************************************************************/
function get_FolderDocumentInfoTable($FolderRSN){
	$sql = "{Call www_GetDocumentInfo(?)}";
		$params = array(array($FolderRSN, SQLSRV_PARAM_IN));	
		$rs = getRecordset($sql, $params);	
		
		?>
		<table class='table'>
		<thead>
			<th>Document ID</th>
			<th colspan= "2">Description</th>
			<th>Generated</th>
			<th>Sent</th>
			<th>Due</th>
			<th>Reply</th>
			<th>Status</th>
		</thead>
		<tbody>
		
		<?php
			for($i=0; $i<sizeof($rs); $i++){
				
		?>
		<tr>
			<td><?php echo $rs[$i]['DocumentRSN'] ?></td>
			<td colspan ="2"><?php echo $rs[$i]['DocumentDesc'] ?></td>
			<td><?php echo $rs[$i]['DateGenerated'] ?></td>
			<td><?php echo $rs[$i]['DateSent'] ?></td>
			<td><?php echo $rs[$i]['DateDue'] ?></td>
			<td><?php echo $rs[$i]['DateReceivedReply'] ?></td>
			<td><?php echo $rs[$i]['DocumentStatus'] ?></td>
		</tr>
	
			<?php 
			}
			?>
		</tbody>
			</table>
	
	
	<?php	
}
/************************************************************************************************************************************************************/

function get_FolderProcessTable($FolderRSN){

$sql = "{Call www_GetProcessInfo(?)}";
		$params = array(array($FolderRSN, SQLSRV_PARAM_IN));	
		$rs = getRecordset($sql, $params);	
		?>
		<table class="table table-hover table-rounded" id='clickable'>
		<thead>
		<tr>
			<th>Process RSN</th>
			<th>Process</th>
			<th>Comments</th>
			<th colspan ="2">Status</th>
			<th>To Start</th>
			<th>To End</th>
			<th>Started</th>
			<th>Ended</th>
			<th>ID</th>
			<th>Mandatory</th>
			
		</tr>
		</thead>
		<tbody>
		
		<tr>
			<td><strong><?php echo $rs[0]['ProcessGroupDesc']; ?></strong></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>

		</tr>
		<?php
		$groupCode= 15;
		for($i=0; $i<sizeof($rs); $i++){
			$ProcessRSN = $rs[$i]['ProcessRSN'];
			
			if($rs[$i]['ProcessGroupCode']> $groupCode){
				$groupCode= $rs[$i]['ProcessGroupCode'];
				?>
			<tr>
				<td><strong><?php echo $rs[$i]['ProcessGroupDesc']; ?></strong></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
	
			</tr>
			<?php
			}
			?>		
			<tr onclick="javascript:processInfo(<?php echo $ProcessRSN; ?>);">
				<td><?php echo $ProcessRSN; ?></td>
				<td><?php echo $rs[$i]['ProcessDesc']; ?></td>
				<td><?php echo $rs[$i]['ProcessComment']; ?></td>
				<td colspan ="2"><?php echo $rs[$i]['StatusDesc']; ?></td>	
				<td><?php echo $rs[$i]['ScheduleDate']; ?></td>
				<td><?php echo $rs[$i]['ScheduleEndDate']; ?></td>
				<td><?php echo $rs[$i]['StartDate']; ?></td>		
				<td><?php echo $rs[$i]['EndDate']; ?></td>
				<td><?php echo $rs[$i]['UserName']; ?></td>
				<td <?php if($rs[$i]['MandatoryFlag'] == 'Y'){ ?> class="danger" <?php }?>><input type="checkbox" disabled="disabled" <?php if($rs[0]['MandatoryFlag'] == 'Y'){ ?> checked <?php } ?>/></td>		
			</tr>
		</tbody>
		<tbody class ="processIframe">
			<tr id="trProcess_<?php echo $ProcessRSN; ?>" style="display: none;">
				<td colspan="100%">
					<iframe src="processinfo.php?ProcessRSN=" id="iProcess_<?php echo $ProcessRSN; ?>" scrolling="yes" style="top: 0; right: 0; left: 0; bottom: 0; min-width: 800px; min-height: 700px;" frameborder="0" height="100%" width="100%"></iframe>
				</td>
			</tr>
			</tbody>
			<?php
		}
		?>	
		
		</table>
<?php }
/************************************************************************************************************************************************************/
function get_FolderComments($FolderRSN){
	$sql = "{Call www_GetComments(?)}";
		$params = array(array($FolderRSN, SQLSRV_PARAM_IN));	
		$rs = getRecordset($sql, $params);	
		?>
	<table class="table">
		<thead>
			<tr>
				<th>First Line of Comment</th>
				<th>Made On</th>
				<th>Made By</th>
				<th>Remind On</th>
				<th>Remind</th>
				<th>Comment Date</th>
				
			</tr>
		</thead>
		<tbody>
	<?php	
	for($i=0; $i<sizeof($rs); $i++){	
	?>
	<tr>
		<td><?php echo $rs[$i]['Comments']; ?></td>
		<td><?php echo $rs[$i]['StampDate']; ?></td>
		<td><?php echo $rs[$i]['StampUser']; ?></td>
		<td><?php echo $rs[$i]['ReminderDate']; ?></td>
		<td><?php echo $rs[$i]['UserComment']; ?></td>
		<td><?php echo $rs[$i]['CommentDate']; ?></td>
		
	</tr>
	<?php
	}
	?>
	</tbody>
</table>
<?php
}


/************************************************************************************************************************************************************/

function get_PeoplePeopleTable($PeopleRSN){
	

$sql = "{call www_GetPeopleRecords(?)}";
$params = array(array($PeopleRSN, SQLSRV_PARAM_IN));	
$rs = getRecordset($sql, $params);

if($rs[0]['Phone1']==8020000000){$phone="";}
else{
if(strlen($rs[0]['Phone1']) == 10){
$phone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $rs[0]['Phone1']);}
else{$phone= $rs[0]['Phone1'];}
}
?>
<br />

<table class="table">
<thead>
<tbody>
	<tr>
		<th>Name</th><td colspan ="2"><?php echo $rs[0]['NameFirst']. ' '. $rs[0]['NameLast']; ?></td>
		<th>Organization</th><td colspan ="2"><?php echo $rs[0]['OrganizationName']; ?></td>
	</tr>
	<tr>
		<th>Address</th><td colspan ="2"><?php echo $rs[0]['AddressLine1']; ?></td>
		<td colspan ="3"><?php echo $rs[0]['AddressLine2']. ' '.$rs[0]['AddressLine3']; ?></td>
	</tr>
	<tr>
		<th>Phone</th><td><?php echo $rs[0]['Phone1']; ?></td>
		<td colspan ="2"><?php echo $rs[0]['Phone1Desc']; ?></td>
		<td><?php echo $rs[0]['Phone2']; ?></td>
		<td><?php echo $rs[0]['Phone2Desc']; ?></td>
	</tr>
	<tr>
		<th>Email</th><td><?php echo $rs[0]['EmailAddress']; ?></td>
		<th>Licence Num.</th><td><?php echo $rs[0]['LicenceNumber']; ?></td>
		<th>People Type</th><td><?php echo $rs[0]['PeopleDesc']; ?></td>
	</tr>
	<tr>
		<th>Date of Birth</th><td colspan ="2"><?php echo $rs[0]['BirthDate']; ?></td>
		<th>Tax ID/SSN</th><td colspan ="2"><?php echo $rs[0]['ReferenceFile']; ?></td>
	</tr>
	<tr>
		<th>Family ID</th><td><?php echo $rs[0]['FamilyRSN']; ?></td>
		<th>Parent ID</th><td><?php echo $rs[0]['ParentRSN']; ?></td>
		<th>Row ID</th><td><?php echo $rs[0]['PeopleRSN']; ?></td>
	</tr>
<?php

if(isset($rs[0]['NameLast'])){
	$name =$rs[0]['NameFirst'].' '.$rs[0]['NameLast'];
}
else{$name =$rs[0]['OrganizationName'];}
	?>
	</thead>
	</tbody>
</table>




<?php

return $name;
}

/************************************************************************************************************************************************************/
function get_PeoplePropertyHistory($PeopleRSN, $name){
$sql = "{call www_GetPeopleProperties(?)}";
$params = array(array($PeopleRSN, SQLSRV_PARAM_IN));	
$rs1 = getRecordset($sql, $params);
$rs1Size = (array_sum(array_map("count", $rs1)))/30;
?>
<table class="table table-hover table-rounded table-striped" id="clickable">
<thead>
	<th>Type</th>
	<th>Name</th>
	<th colspan = "2">Address</th>
	<th>Start Date</th>
	<th>End Date</th>
</thead>
<tbody>
<?php
for($i=0; $i<$rs1Size; $i++){
$propertyRSN =$rs1[$i]['PropertyRSN'];
?>
<tr onclick="javascript:propertyDetails(<?php echo $propertyRSN; ?>);">
	<td><?php echo $rs1[$i]['PeopleDesc']; ?></a></td>
	<td><?php echo $name; ?></td>
	<td><?php echo $rs1[$i]['PropHouse']; ?></td>
	<td><?php echo $rs1[$i]['PropStreet'].' '.$rs1[$i]['PropStreetType']; ?></td>
	<td><?php echo $rs1[$i]['StartDate']; ?></td>
	<td><?php echo $rs1[$i]['EndDate']; ?></td>
</tr>
<?php
}
?>
</tbody>
</table>

<?php }

/************************************************************************************************************************************************************/
function get_PropertyOwnerHistoryTable($PropertyRSN){
$sql = "{Call www_GetOwnerHistory(?)}";
			$params = array(array($PropertyRSN, SQLSRV_PARAM_IN));	
			$rs = getRecordset($sql, $params);	
			?>
			
		<table class="table table-hover table-rounded table-striped" id='clickable'>
		<thead><tr><th>PeopleRSN</th><th>People Type</th><th>Name</th><th>Address</th><th>Start Date</th><th>End Date</th></tr></thead>
		<tbody>
		<?php
		for($i=0; $i<sizeof($rs); $i++){
		$PeopleRSN =$rs[$i]['PeopleRSN'];
			?>
		<tr onclick="javascript:peopleInfo(<?php echo $PeopleRSN; ?>);">
				<td><?php echo $PeopleRSN; ?></td>
					<td><?php echo $rs[$i]['PeopleDesc']; ?></td>
					<td><?php echo $rs[$i]['NameFirst'].' '.$rs[$i]['NameLast']; ?></td>
					<td><?php echo $rs[$i]['AddressLine1']; ?></td>
					<td><?php echo $rs[$i]['StartDate']; ?></td>
					<td><?php echo $rs[$i]['EndDate']; ?></td></a>
				</tr>		
		<?php }?>	
		</tbody></table>
		<?php }
/************************************************************************************************************************************************************/
function get_PropertyInfoTable($PropertyRSN){
?>
<table class='table'>
			<thead><th>Description</th><th>Value</th></th>
			<tbody>
			<?php
			$sql = "{Call www_GetPropertyInfoValue(?)}";
			$params = array(array($PropertyRSN, SQLSRV_PARAM_IN));	
			$rs = getRecordset($sql, $params);	
			
			for($i=0; $i<sizeof($rs); $i++){
				?>
				<tr>
					<td><?php echo $rs[$i]['PropertyInfoDesc']; ?></td>
					<td><?php echo $rs[$i]['PropInfoValue']; ?></td>
				</tr>
				<?php 
				}
			?>
			</tbody></table>
<?php }
/************************************************************************************************************************************************************/



?>
			