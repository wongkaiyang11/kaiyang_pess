<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Update</title>
	<script>
function validateForm() 
		{
var patrolCarId = document.forms["form1"]["patrolCarId"].value;
		 if (patrolCarId == "") {
		alert("ID must be filled out");
		return false;
		 		}
		}		
	</script>
<?php
	if(isset($_SESSION)==false){
    session_start();}
    if(!isset($_SESSION['username'])) {
    header('Location: Signin.php');
    }
	
	if(isset($_POST["btnUpdate"])){
			$con = mysql_connect("localhost","Jonathan","123456789");
			
		if(!$con)
		{
			die('Cannot connect to database :'.mysql_error());
		}
		
		mysql_select_db("27_kaiyang_pessdb",$con);
		
		$sql = "UPDATE patrolcar SET patrolcarStatusId='".$_POST["patrolcarStatus"]."'WHERE patrolcarId='".$_POST["patrolCarId"]."' ";
		
		if(!mysql_query($sql,$con))
		{
			die('Error4:'.mysql_error());
		}
		
		if($_POST["patrolCarStatus"]=='4'){
				
				$sql = "UPDATE dispatch SET timeArrived=NOW() WHERE timeArrived is NULL AND patrolCarId='".$_POST["patrolCarId"]."' ";
		
		if(!mysql_query($sql,$con))
		{
			die('Error4: '.mysql_error());
		}
		} elseif($_POST["patrolCarStatus"]=='3'){ //else if patrol car status is FREE then capture the time of completion
			
//Receive the incident ID from dispatch table handled by that patrol car 
				$sql = "SELECT incidentId FROM dispatch WHERE timecompleted IS NULL AND patrolcarId='".$_POST["patrolCarId"]."'";
				
				$result = mysql_query($sql,$con);
				
				$incidentId;
				
				while($row = mysql_fetch_array(result))
				{
					//patrolcarId,patrolCarStatusId
					$incidentId = $row['incidentId'];
				}
				
				echo $incidentId;
				
				//now update the dispatch
				
				$sql = "UPDATE dispatch SET timeCompleted=NOW() WHERE timeCompleted is NULL AND patrolCarId='".$_POST["patrolCarId"]."' ";
				
				if(!mysql_query($sql,$con))
				{
					die('Error4: '.mysql_error());
				}
				
				//lastly, update incident in incident table 
				
				$sql = "UPDATE incident SET incidentStatusId='3' WHERE incidentId='$incidentId' AND incidentId NOT IN (SELECT incidentId FROM dispatch WHERE timeCompleted IS NULL)";
				
				if(!mysql_query($sql,$con))
				{
					die('Error4: '.mysql_error());
				}
				
		}
		mysql_close($con);
		
		?>
		<script type="text/javascript">window.location="./logcall.php";</script>
		<?php } ?>
</head>
<body>
<?php
	include "header.php";
	if(!isset($_POST["btnSearch"])){	
?>
<fieldset>
<legend><h1>Update Patrol Care</h1></legend>
<form name="form1" onsubmit="return validateForm()" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
	
	<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">
	
		<tr>
		
	<td width="25%" class="td_label">Patrol Car ID:</td>
	<td width="25%" class="td_Data"><input type="text" name="patrolCarId" id="patrolCarId"> </td>
		
<!-- MUST validate for empty entry at the client side -->
	<td class="td_Data"><input type="submit" name="btnSearch" id="btnSearch" value"Search"></td>
	
		</tr>
	</table>
</form>
</fieldset>
<?php		

	
	}else{
		//echo $_post["patrolcarId"];
		//retrieve patrol car status and patrolcarstatus
		//connect to database
	$con=mysql_connect("localhost","Jonathan","123456789");
	if(!$con)
	{
		die('Cannot connect to database: '.mysql_error());
	}
	//select a table in the database
	mysql_select_db("27_kaiyang_pessdb",$con);
	//retrieve patrol car status
	$sql="SELECT * FROM patrolcar WHERE patrolcarId='".$_POST['patrolCarId']."'";
	
	$result=mysql_query($sql,$con);
		
	$patrolcarId;
		
	$patrolcarStatusId;
		
	while($row = mysql_fetch_array($result))
	{
		$patrolCarId= $row['patrolcarId'];
		$patrolcarStatusId=$row['patrolcarStatusId'];
	}
		//retrieve patrolcarstatus master table
		$sql="SELECT * FROM patrolcar_status";
		$result= mysql_query($sql,$con);
		
		$patrolCarStatusMaster;
		
		while($row= mysql_fetch_array($result))
		{
		$patrolCarStatusMaster[$row['statusid']]= $row['statusDesc'];	
		}
		mysql_close($con);
?>
	<fieldset>
	<legend>Update Patrol Care</legend>
	<form name="form2" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
	
		<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">	
			<tr>
				<td width="25%" class="td_label">ID :</td>
				<td width="25%" class="td_Data"> <?php echo $_POST["patrolCarId"]?> 
				<input type="hidden" name="patrolCarId" id="patrolCarId" value="<?php echo $_POST["patrolCarId"]?>">
				</td>
				
			</tr>
				<tr>
					<td class="td_label">Status : </td>
					<td class="td_Data"> <select name="patrolcarStatus" id="$patrolcarStatus"> 
						<?php foreach( $patrolCarStatusMaster as $key => $value)
						{?>
								<option value="<?php echo $key?>"
								<?php if ($key==$patrolcarStatusId) { ?> selected="selected"
								<?php }?>>
								<?php echo $value ?>
								</option>
						<?php } ?>
						</select>
					</td>
				</tr>
		</table>
			<br/>
			<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">
					<tr>
				<td width="46%" class="td_label"> <input type="reset" name="btnCancel" id="btnCancel" value="Reset"> </td>
				
				<td width="54%" class="td_Data"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" name="btnUpdate" id="btnUpdate" value="Update">
				</td>
					</tr>
				</table>
		 	</form>
	</fieldset>
	<?php }?>	
</body>
</html>