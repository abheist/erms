<?php
	$reqlogin=true;
	$css="viewrec";
	$form=true;
	$error="";
	require_once 'header.php';
	if(!isset($_GET['assign']))
		header('Location:.');
	require_once 'db/connectvars.php';
	$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in Page');
	if(isset($_POST['submit']))
	{
		$form=false;
		$assign_to=mysqli_real_escape_string($dbc, $_POST['assign_to']);
		$job_id=$_POST['job'];
		$query="update job_opp set assign_to=$assign_to where SHA(job_id)='$job_id'";
		if(mysqli_query($dbc, $query))
		{
			echo '<center><h1>Assigning.....</h1></center>';
			header('refresh:1;url=.');
		}
		else
		{
			$error="Error in assigning";
			$form=true;
		}
	}
	if($form)
	{
		$enc_job_id=$_GET['assign'];
		
		$query="select job_id,assign_to,job_title from job_opp where SHA(job_id)='$enc_job_id'";
		$result=mysqli_query($dbc, $query) or die('Error in Page');
		if(mysqli_num_rows($result)==1)
		{
			$row=mysqli_fetch_array($result,MYSQL_ASSOC);
			if(empty($row['assign_to']))
			{
				$active_id=$_SESSION['user_id'];
				echo $error;
				$query="select user_id,user_name from user_details where user_id<>$active_id";
				$result=mysqli_query($dbc, $query) or die('Error in Connection');
				if(mysqli_num_rows($result)>0)
				{
					echo '<form method="post" action="assign">';
					echo 'Assign To: <select name="assign_to">';
						while($row=mysqli_fetch_array($result,MYSQL_ASSOC))
							echo '<option value="'.$row['user_id'].'">'.$row['user_name'].'</option>';
					echo '</select>';
					echo '<input type="submit" name="submit" value="Assign">';
					echo '<input type="hidden" name="job" value="'.$enc_job_id.'">';

					echo '</form>';
				}
			}
		}
	}
?>