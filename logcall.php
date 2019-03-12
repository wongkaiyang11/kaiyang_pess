<!doctype html>
<head>
<meta charset="utf-8">
<title>PESS</title>
	
<script>
	function validateForm() {
	  var callerName = document.forms["frmLogCall"]["callerName"].value;
	  var contactNum = document.forms["frmLogCall"]["contactNum"].value;
	  var location = document.forms["frmLogCall"]["location"].value;
	  var incidentDesc = document.forms["frmLogCall"]["incidentDesc"].value;
	  if (callerName == "") {
		alert("Name must be filled out");
		return false;
	  }
	  else  if (contactNum == "") {
		alert("Contact Number must be filled out");
		return false;
	  }
	  else  if (location == "") {
		alert("Location must be filled out");
		return false;
	  }
	  else  if (incidentDesc == "") {
		alert("Description must be filled out");
		return false;
	  }
	}
</script>
	
</head>

<body>
<?php
	if(isset($_SESSION)==false)
    session_start();
    if(!isset($_SESSION['username'])) {
    header('Location: Signin.php');
    }
	
	include "header.php";
	if (isset($_POST["btnProcessCall"]))
	{
		$con =mysql_connect("localhost","Jonathan","123456789");
		if(!$con)
		{
			die('Cannot Connect to database: '.mysql_error());
		}

		mysql_select_db("27_kaiyang_pessdb",$con);

		$sql="INSERT INTO incident(callerName,phonenumber,incidentTypeId,incidentLocation,incidentDesc,incidentStatusId) VALUES('$_POST[callerName]','$_POST[contactNum]','$_POST[incidentType]','$_POST[location]','$_POST[incidentDesc]','1')";

		if(!mysql_query($sql,$con))
		{
			die('Error:'.mysql_error());
		}
		mysql_close($con);
	}
	
	$con =mysql_connect("localhost","Jonathan","123456789");
	if(!$con)
	{
		die('Cannot connect to database :'.mysql_error());
	}

	mysql_select_db("27_kaiyang_pessdb",$con);

	$result = mysql_query("SELECT * FROM incidenttype");

	$incidentType;

	while($row = mysql_fetch_array($result))
	{
		$incidentType[$row['incidentTypeID']] = $row['incidentTypeDesc'];
	}

	mysql_close($con);
?>
<form name="frmLogCall" onsubmit="return validateForm()" method="post" action="Dispatch.php">
	<fieldset>
		<legend><h1>Log Call</h1></legend>
		
 <table>
	  <tr>
		   <td align="left">Caller's Name:</td> 
		   <td><p><input type="text" name="callerName"></p></td>
	  </tr>
	  <tr>
		   <td align="left">Contact Number:</td> 
		   <td><p><input type="text" name="contactNum"></p></td>
	  </tr>
	  <tr>
		   <td align="left">Location</td> 
		   <td><p><input type="text" name="location"></p></td>
	  </tr>
	  <tr>
	 			<td align="left" class="td_label">Incident Type:</td>
				<td class="td_Date">
					<p>
						<select name="incidentType" id="incidentType">
							<?php foreach($incidentType as $key => $value) {?>
							<option value="<?php echo $key ?>"><?php echo $value ?></option>
							<?php }?>
						</select>					
					</p>
				</td>
	 </tr>
	<tr></tr>
		<tr>
			<td align="left">Desciption:</td>
			<td>
				<p>
					<textarea rows="4" cols="50" name="incidentDesc"></textarea>
				</p>
			</td>
		</tr>
		<tr>
			<td align="left"><input type="reset" /></td>
			<td align="left"><input type="submit" name="btnProcessCall" value="Process Call"></td>
		</tr>
		</table>	
	</fieldset>
</form>
</body>
</html>