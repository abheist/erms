<?php
$reqlogin=true;
$css="viewjob";
require_once ('header.php');
if(isset($_GET['id']))
{
	if(!empty($_GET['id']))
	{
		require_once 'db/connectvars.php';
		$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		$enc_jobid=$_GET['id'];
		$query="select * from job_opp where SHA(job_id)='$enc_jobid'";
		$result=mysqli_query($dbc, $query) or die('Error in developing');
		if(mysqli_num_rows($result)==1)
		{

			?>

			<div id="viewjo1">
				<div id="viewjo2">



			<?php
			$row=mysqli_fetch_array($result,MYSQL_ASSOC);
			$client_id=$row['client_id'];
			$cl_query="select client_name from client_details where client_id=$client_id";
			$cl_result=mysqli_query($dbc,$cl_query) or die('Error');
			$cl_row=mysqli_fetch_array($cl_result,MYSQL_ASSOC);
			
			echo '<h1>Job Title: '.$row['job_title'].'</h1>';
			echo '<h5 id="postedon"> Posted On: '.$row['added_on'].'</h5>';
			echo '<h3 id="emp"> Employer: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			 &nbsp; &nbsp; &nbsp; &nbsp;'.$cl_row['client_name'].'</h3>';
			echo '<h3 id="joblocation"> Job Location: &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;';
			if(!empty($row['job_location']))
				echo $row['job_location'].'</h3>';
			else
				echo 'Not Available</h3>';
			echo '<h3> Quantity:  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;';
			if(!empty($row['job_qtty']))
				echo $row['job_qty'].'</h3>';
			else
				echo 'Not Available</h3>';
			echo '<h3>Experience: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;';
			if(!empty($row['job_exprnc']))
				echo $row['job_exprnc'].' years</h3>';
			else
				echo 'Not Available</h3>';
			echo '<h3> Salary: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;';
			if(!empty($row['salary']))
				echo $row['salary'].'</h3>';
			else
				echo 'Not Available</h3>';
			echo '<h3> Assigned To: ';
			if(!empty($row['assign_to']))
				echo $row['assign_to'].'</h3>';
			else
				echo ' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href="#" id="assignbut">Assign Now</a></h3>';
			echo '<h3> Job Description: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;';
			if(!empty($row['job_desc']))
			{
				$file=fopen('desc/'.$row['job_id'].'.txt','r');
    			while(!feof($file))
    				echo fgets($file);
			}
			else
				echo 'Not Available';
		}
	}
}
?>

			</div>
		</div>