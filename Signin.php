<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sign in</title>
<script>
	function validateForm1() {
	  var username = document.forms["frmLogCall1"]["username"].value;
	  var pass = document.forms["frmLogCall1"]["pass"].value;	
	  if (username == "") {
		alert("Username must be filled out");
		return false;
	  }
	  else  if (pass == "") {
		alert("Password must be filled out");
		return false;
	  }
	}
</script>
	
</head>

<body>
<?php include "header.php"; ?>
	
<?php
	
	if(isset($_SESSION)==false)
	{
    	session_start();
	}
    if(isset($_SESSION['username'])) 
	{
   		 header('Location: logcall.php');
    }
	
	if (isset($_POST["btnsuccess"]))
	{
		$con =mysql_connect("localhost","Jonathan","123456789");
		if(!$con)
			{
				die('Cannot Connect to database: '.mysql_error());
			}
		
		mysql_select_db("27_kaiyang_pessdb",$con);
		
		$name = $_POST['username'];
		$pass = $_POST['pass'];
		
		$sql="SELECT * from signin where username = '$name' AND pass = '$pass'";
		
		$result = mysql_query($sql,$con);
		$num = mysql_num_rows($result);
		
		if($num == 1)
		{
			$_SESSION['username'] = $_POST['username'];
			header("location: logcall.php");
		}
		else
		{
			echo 'Invalid login';
			
		}
		
		
		mysql_close($con);
	}

?>
	<form name="frmLogCall1" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
	<fieldset>
		<legend>Sign in</legend>
		<table>
		 <tr>
		   <td align="right">Username :</td> 
		   <td><p><input type="text" name="username"></p></td>
	  </tr>
	  <tr>
		   <td align="right">Password :</td> 
		   <td><p><input type="password" name="pass"></p></td>
	  </tr>
		<tr>
			<td><input type="submit" name="btnsuccess" value="Sign in"></td>
		</tr>
		</table>	
	</fieldset>
	</form>
</body>
</html>