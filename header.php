<style>
td{
		font-size: 20px;
		border-color: black;
		color: whitesmoke;
		font-weight: 700;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}	
.formyes {
  border: none;
  color: black;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  margin: 4px 2px;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
  cursor: pointer;
}

label{
	font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	font-size: 22px;
	font-weight: 400;
}	
	
input[type=text] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 1px solid #555;
  outline: none;
}

input[type=text]:focus {
  background-color: lightblue;
}
input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 1px solid #555;
  outline: none;
}

input[type=password]:focus {
  background-color: lightblue;
}
img
{
display: block;
 
margin-right: auto;
}
body 
{
background-image:url("background.png");
color: black;
}

li:hover 
{
background-color:#D9F1F0; 	
}
h1
{
text-align: center;
color:#A6AEE3;
font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
text-decoration-style: solid;
font-weight: 700;
text-shadow: 3px 2px red;
}
.nav {
  background-color: #6167F9;
  outline-color: black;
  list-style-type: none;
  text-align: left;
}

.nav li {
  display: inline-block;
  font-size: 20px;
	font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
  padding: 20px;
}
a{
	color: black;
	text-decoration: none;
}
	legend{
		font-size: 21px;
		font-weight: 600;
		text-align: center;
		font-style: italic;
		color:black;
		outline-color: black;
	}
</style>
<a href="http://localhost/pess_kaiyang/logcall.php">
  <img src="logo.png" alt="logo" style="width:300px;height:150px;border:0">
</a>
<marquee><h1>Police Emergency Service System</h1></marquee>
<ul class="nav">
  <li><a href="logcall.php">Log Call</a></li>
  <li><a href="update.php">Update</a></li>
  <li><a href="Signin.php">Sign In</a></li>
  <li><a href="Signout.php">Sign Out</a></li>
</ul>

