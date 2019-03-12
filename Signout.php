<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sign Out</title>
</head>

<body>
	<?php
		session_start();
		session_destroy();
	
		header('location: Signin.php'); 
	?>
</body>
</html>