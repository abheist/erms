<?php
session_start();
if(isset($_SESSION['user_id']) || isset($_SESSION['user_name']) || isset($_SESSION['user_right']))
    header('Location: .');
$form=true;
$error="";
$sqlerr=false;
require_once 'db/connectvars.php';
$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error');
if(isset($_GET['code']))
{
	if(!empty($_GET['code']))
		$code=$_GET['code'];
	else
		header('Location: .');
}
else if(!isset($_POST['submit']))
	header('Location: .');
if(isset($_POST['submit']))
{
	$form=false;
	$code=mysqli_real_escape_string($dbc, $_POST['code']);
	$pass=mysqli_real_escape_string($dbc, $_POST['pass']);
	$cnfrmpass=mysqli_real_escape_string($dbc, $_POST['cnfrmpass']);
	if(empty($pass) || empty($cnfrmpass))
	{
		$error="Empty Field(s)";
		$form=true;
	}
	else if($pass!=$cnfrmpass)
	{
		$error="Password don't match!!";
		$form=true;
	}
	else
	{
		$query="select actual_id from temp where code='$code'";
		$result=mysqli_query($dbc, $query)	or die('Error');
		if(mysqli_num_rows($result)==1)
		{
			$row=mysqli_fetch_array($result, MYSQL_ASSOC);
			$uid=$row['actual_id'];
		}
		else
		{
			$form=true;
			$error='Request for a new <a href="forget">link </a> or <a href=".">login</a>';
		}
	}
	if(!$form)
	{
		$query="update user_details set user_pass=SHA('$pass') where user_id=$uid";
		$result=mysqli_query($dbc, $query);
		if($result)
		{
			$query="delete from temp where actual_id=$uid";
			$result=mysqli_query($dbc, $query);
			if($result)
			{
				echo 'Password has been changed successfully. Redirecting....';
				header('refresh:3;url=.');
			}
			else
				$sqlerr=true;
		}
		else
			$sqlerr=true;
		if($sqlerr)
		{
			$form=true;
			$error="Failed to Update Password";
		}
	}
}
if($form)
{
?>
<html>
<head>
	<title>Erasmith | Change Password</title>
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
					<h2 id="loginheading">Change Password</h2>

					
					<div id="error"> <?php echo $error; 	?></div>

					<form method="post" action="changepass">
						<input type="password" name="pass" id="mailfield" placeholder="New Password" required><br/>
						<input type="hidden" name="code" value="<?php if(isset($code)) echo $code; ?>"/> 
						<input type="password" name="cnfrmpass" id="mailfield" placeholder="Confirm New Password" required><br/>
						<input type="submit" name="submit" value="Submit" id="submitbutton"><br><br>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
}
?>