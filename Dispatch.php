<?php 
// make sure people cant access this page instantly
    if (!isset($_POST['btnProcessCall'])){
           header("Location: logcall.php");
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Dispatch Patrol Care</title>
<?php
	// connect to database  
	if(isset($_POST["btnSubmit"])) 
	{
		//connect to database
		$con=mysql_connect("localhost","Jonathan","123456789");
	
	if(!$con)
	{
		die('Cannot connect to database: '.mysql_error());
	}
	
	mysql_select_db("27_kaiyang_pessdb",$con);
	
	//update patrolcarstatus table and dispatch table
	$patrolcarDispatched = $_POST["chkPatrolcar"];
	
	$c = count($patrolcarDispatched);
	
	//insert a new incident
	$status;
	if($c > 0){
		$status='2';
	} else{
		$status='1';
	}

	$sql="INSERT INTO incident(callerName,phoneNumber,incidentTypeId,incidentLocation,incidentDesc,incidentStatusId)
	
	VALUES('".$_POST['callerName']."','".$_POST['contactNo']."','".$_POST['incidentType']."','".$_POST['location']."','".$_POST['incidentDesc']."','$status')";
	
	if(!mysql_query($sql,$con))
	{
		die('Error1:'.mysql_error());                        
	}
	
	//retrieve new incremental key for incidentId
	$incidentId=mysql_insert_id($con);
	
	for($i=0;$i < $c; $i++)
	{
		$sql="UPDATE patrolcar SET patrolcarStatusId='1' WHERE patrolcarId='$patrolcarDispatched[$i]'";
		
		if(!mysql_query($sql,$con))
		{
			die('Error2:'.mysql_error());
		}
		
		$sql="INSERT INTO dispatch(incidentId,patrolcarid,timeDispatched)VALUES('$incidentId','$patrolcarDispatched[$i]',NOW())";
		if(!mysql_query($sql,$con))
		{
			die('Error3:'.mysql_error());
		}
	}
	mysql_close($con);
	}
?>
</head>

<body>
	<?php
	
	
	include "header.php";
	
	$con= mysql_connect("localhost","Jonathan","123456789");
	if(!$con)
	{
		die('Cannot connect to database: '.mysql_error());
	}
	
	mysql_select_db("27_kaiyang_pessdb",$con);
	
	$sql="SELECT patrolcarId,statusDesc FROM patrolcar JOIN patrolcar_status ON patrolcar.patrolcarStatusId=patrolcar_status.statusId WHERE patrolcar.patrolcarStatusId='2' OR patrolcar.patrolcarStatusId='3'";
	
	$result=mysql_query($sql,$con);
	
	$incidentArray;
	$count=0;
	
	while($row =mysql_fetch_array($result))
	{
		$patrolcarArray[$count]=$row;
		$count++;
	}
	if(!mysql_query($sql,$con))
	{
		die('Error:'.mysql_error());
	}
	
	
	mysql_close($con);
	?>
	
	<form name="frmLogCall" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"> 
	<fieldset>
	<legend>Dispatch Patrol Care</legend>
		<table width="40%" border="0" align="center" cellpadding="4" cellspacing="8">
		<tr>
			
			<td>
				Caller's Name:
				<?php echo $_POST["callerName"];?>
			</td>
		</tr>
		<tr>
			<td>
				Contact No:
				<?php echo $_POST["contactNum"];?>
			</td>
		</tr>
		<tr>
			<td>
				Location
				<?php echo $_POST["location"];?>
			</td>
		</tr>
		<tr>
			<td>
				Incident Type:
				<?php echo $_POST["incidentType"];?>
			</td>
		</tr>
		<tr>
			
			<td>
				Desciption:
				<?php echo $_POST["incidentDesc"];?>
			</td>
		</tr>
		</table>
		
		
	<table width="40%" border="1" align="center" cellpadding="4" cellspacing="8">
	<tr>
		<td width="20%">&nbsp;</td>
		<td width="51%">Patrol Car ID</td>
		<td width="29%">Status</td>
	</tr>
		
	<?php
	$i=0;
	while($i< $count){
	?>	
	<tr>
		<td class="td_label">
			<input type="checkbox" name="chkPatrolcar[]" value="<?php echo $patrolcarArray[$i]['patrolcarId']?>"</td>
			
		 <td><?php echo $patrolcarArray[$i]['patrolcarId']?></td>
		
		<td><?php echo $patrolcarArray[$i]['statusDesc']?></td>
			
	</tr>
	<?php $i++;
	} ?>
	</table>
	
	<table width="50%" border="0" align="center" cellpadding="4" cellspacing="4">
	
		<td width="46%" class="td_label">
			
		<input type="reset" name="btnCancel" id="btnCancel" value="Reset">
			
		</td>
		
		<td width="54%" class="td_Data">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btnSubmit" id="btnSubmit" value="Submit">
			
		</td>
	
	</table>
	</fieldset>
	</form>
	</body>