<?php
$reqlogin=true;
$css="add_recruit";
require_once 'header.php';
if(isset($_SESSION['user_right']))
	if($_SESSION['user_right']>1)
		header('Location: .');
$error="";
$form=true;
if(isset($_POST['submit']))
{
	$form=false;
	require_once('db/connectvars.php');
	$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
	$user_name=mysqli_real_escape_string($dbc,trim($_POST['user_name']));
	$user_email=mysqli_real_escape_string($dbc,trim($_POST['user_email']));
	$user_pass=mysqli_real_escape_string($dbc,trim($_POST['user_pass']));
	$user_right=mysqli_real_escape_string($dbc,trim($_POST['user_right']));
	if(empty($user_name) || empty($user_email) || empty($user_pass))
	{
		$form=true;
		$error="Please fill out all entries";
	}
	else
	{
		$user_email=strtolower($user_email);
		$query="select user_email from user_details where user_email	= '$user_email'";
		$result=mysqli_query($dbc,$query) or die('Error in querying');
		$emails=array();
		while($row=mysqli_fetch_array($result))
			array_push($emails,$row['user_email']);
		if(in_array($user_email,$emails))
		{
			$form=true;
			$error="Email Already Registered";
		}
	}
	if(!$form)
	{
		$query="insert into user_details(user_name,user_email,user_pass,user_right) values('$user_name','$user_email',SHA('$user_pass'),'$user_right')";
		mysqli_query($dbc,$query) or die($query);
		header('Location: viewrec');
	}
}
if($form)
{
?>
	<div id="rec1">
		<div id="rec2">
			<div id="rec3">
				<div id="rec4">
					<h3 id="addhead">Add Recruit</h3>

					<?php echo $error; ?>

					<form method="post" action="add_recruit">
					<input type="text" placeholder="Name" name="user_name" value="<?php if(isset($user_name)) echo $user_name;?>" required><br>
					<input type="email" placeholder="E-Mail" name="user_email" value="<?php if(isset($user_email)) echo $user_email;?>" required><br>
					<input type="password" placeholder="Password" name="user_pass" required><br>
					<label>Level: <select name="user_right">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3" selected>3</option>
					</select></label>
					<input type="submit" id="submitbutton" name="submit">
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
