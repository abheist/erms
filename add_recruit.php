
<?php
$reqlogin=true;
$css="add_recruit";
require_once 'header.php';
	?>
	<style type="text/css">
		.tooltipsy
		{
    		padding: 10px;
    		color: white;
    		background: rgba(0,0,0,0.9);
    		border-radius: 6px;
    		font-size: 12px;
		}
		#lalaques	{
			padding: 2px 6px 2px 6px;
			color: white;
			border-radius: 100%;
			background: rgba(0,0,0,0.7);
			cursor: pointer;
		}

	</style>
	<?php
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
					<h3 id="addhead">Add Recruiter</h3>

					<?php echo $error; ?>

					<form method="post" action="add_recruit">
					<input type="text" placeholder="Name" name="user_name" value="<?php if(isset($user_name)) echo $user_name;?>" required><br>
					<input type="email" placeholder="E-Mail" name="user_email" value="<?php if(isset($user_email)) echo $user_email;?>" required><br>
					<input type="password" placeholder="Password" name="user_pass" required><br>
					<label>Level: <select name="user_right">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2" selected>2</option>
					</select></label>
					&nbsp&nbsp&nbsp&nbsp<a class="hastip" 
					title="
					<ol>
						<li>1.SuperUser: All Rights.</li>
						<li>2.Manager: All rights except managing recruiters.</li>
						<li>3.User: Rights to post a job opportunity and add candidates.</li>
					</ol>"><span id="lalaques">?</span></a>
 
					<script type="text/javascript">
					$('.hastip').tooltipsy({
    offset: [10, 0],
    css: {
        'padding': '10px 10px 0px 10px',
        'color': '#303030',
        'background-color': '#f5f5b5',
        'border': '1px solid #deca7e',
        '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'text-shadow': 'none'
    }
});
					</script>
					<input type="submit" id="submitbutton" value="Add Recruiter" name="submit">
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
