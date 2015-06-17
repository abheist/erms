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
		$query="(select SHA(j.job_id) as col1, 
						j.job_title as col2, 
						cd.client_name as col3, 
						j.assign_to as col4,
						jd.owner_name as col5, 
						cp.cp_name as col6, 
						jd.owner_phnno as col7,
						jd.owner_email as col8,
						cp_email as col9, 
						cp_phnno as col10,
						j.added_on as col11,
						j.job_location as col12,
						j.job_qty as col13,
						j.job_exprnc as col14,
						j.salary as col15,
						j.job_id as col16
						from job_opp as j, client_details as cd, job_owner_details as jd, contact_person_details as cp where SHA(j.job_id)='$enc_jobid' and cd.client_id=j.client_id and  jd.owner_id=j.job_owner and j.primary_contact=cp.cp_id and j.assign_to is NULL)
						UNION
						(select SHA(j.job_id) as col1, 
								j.job_title as col2, 
								cd.client_name as col3, 
								u.user_name as col4, 
								jd.owner_name as col5, 
								cp.cp_name as col6, 
								jd.owner_phnno as col7,
								jd.owner_email as col8,
								cp_email as col9, 
								cp_phnno as col10,
								j.added_on as col11,
								j.job_location as col12,
								j.job_qty as col13,
								j.job_exprnc as col14,
								j.salary as col15,
								j.job_id as col16
						from job_opp as j, client_details as cd,user_details as u, job_owner_details as jd, contact_person_details as cp where SHA(j.job_id)='$enc_jobid' and u.user_id=j.assign_to)
				";
		$result=mysqli_query($dbc, $query) or die($query);
		if(mysqli_num_rows($result)==1)
		{

			?>

			<div id="viewjo1">
				<div id="viewjo2">



			<?php
			
			$row=mysqli_fetch_array($result,MYSQL_ASSOC);
			echo '<h1>Job Title: '.$row['col2'].'</h1>';
			echo '<h5 id="postedon"> Posted On: '.$row['col11'].'</h5>';
			echo '<h3 id="emp"> Employer: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			 &nbsp; &nbsp; &nbsp; &nbsp;'.$row['col3'].'</h3>';
			 echo '<h3 id="emp" title="Email: '.$row['col8'] .' and  Contact No.: '.$row['col7'].'"> Job Owner: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			 &nbsp; &nbsp; &nbsp;'.$row['col5'].'</h3>';
			 echo '<h3 id="emp"> Owner\'s Email : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			'.$row['col8'].'</h3>';
			  echo '<h3 id="emp"> Owner\'s Contact No. :  &nbsp; 
			 '.$row['col7'].'</h3>';
			echo '<h3 id="joblocation"> Job Location: &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;';
			if(!empty($row['col12']))
				echo $row['col12'].'</h3>';
			else
				echo 'Not Available</h3>';
			echo '<h3> Quantity:  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;';
			if(!empty($row['col13']))
				echo $row['col13'].'</h3>';
			else
				echo 'Not Available</h3>';
			echo '<h3>Experience: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;';
			if(!empty($row['col14']))
				echo $row['col14'].' years</h3>';
			else
				echo 'Not Available</h3>';
			echo '<h3> Salary: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;';
			if(!empty($row['col15']))
				echo $row['col15'].'</h3>';
			else
				echo 'Not Available</h3>';
			echo '<h3> Assigned To: ';
			if(!empty($row['col4']))
				echo '&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;'.$row['col4'].'</h3>';
			else
				echo ' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href="assign?assign='.$row['col1'].'" id="assignbut">Assign Now</a></h3>';
			echo '<h3> Job Description: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;';
			if(!empty($row['job_desc']))
			{
				$file=fopen('desc/'.$row['col16'].'.txt','r');
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