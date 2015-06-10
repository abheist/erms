<?php
	session_start();
	if(isset($_SESSION['user_id']) || isset($_SESSION['user_name']) || isset($_SESSION['user_right']))
		header('Location: me');
	$error="";
	if(isset($_POST['submit']))
	{
		require_once('db/connectvars.php');
		$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
		$email=mysqli_real_escape_string($dbc,trim($_POST['email']));
		$password=mysqli_real_escape_string($dbc,trim($_POST['password']));
		$query="select user_id,user_name,user_right from user_details where user_email='$email' and user_pass=SHA('$password')";
		$result=mysqli_query($dbc,$query) or die('Error in querying');
		if(mysqli_num_rows($result)==1)
		{
			$row=mysqli_fetch_array($result);
			$_SESSION['user_id']=$row['user_id'];
			$_SESSION['user_name']=$row['user_name'];
			$_SESSION['user_right']=$row['user_right'];
			header('Location: me');
		}
		else
			$error="Incorrect credentials. Please login again.";
	}
?>
<html>
<head>
	<title>Erasmith | recruit Login</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
	<div>
		<div>
			<h1 id="heading">Erasmith</h1>
		</div>
	</div>

	<div id="loginbox1">
		<div id="loginbox2">
			<div id="loginbox3">
				<div id="loginbox4">
					<h2 id="loginheading">Recruiter Login</h2>

					<div id="error"> <?php echo $error; 	?></div>

					<form method="post" action=".">
						<input type="email" name="email" id="mailfield" placeholder="E-Mail"><br><br>
						<input type="password" name="password" id="passfield" placeholder="Password"><br><br>
						<input type="submit" name="submit" id="submitbutton"><br><br>
					</form>
					<a href="#" id="forget">Forget Password</a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
