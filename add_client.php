
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
					<h3 id="addhead">Add Client</h3>

					<?php echo $error; ?>
					
					<form method="post" action="add_client">
						<div class="form-group">
							<label for="client_name">Client Name: </label>
							<input type="text" class="form-control" placeholder="Erasmith Technologies Pvt Ltd" name="client_name" value="<?php if(isset($client_name)) echo $client_name;?>" required><br/>
						</div>
						<div class="form-group">
							<label for="client_addr">Client Address: </label>
							<textarea class="form-control" rows="5" placeholder="Shiksha Bharti School Rd, Block C, Palam Extension, Palam Colony, New Delhi, Delhi 110077" required></textarea><br/>
						</div>
						<p id="add_person" class="well well-sm"> Add Contact Person </p>
					
					<input type="submit"  class="btn-success" name="submit" value="Add Client">
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
