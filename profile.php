<?php
$reqlogin=true;
$css="profile";
require_once ('header.php');
if(isset($_GET['id']))
{
	if(!empty($_GET['id']))
	{
		$enc_cid=$_GET['id'];
		require_once 'db/connectvars.php';
		$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
		$query="select * from candidate_details where SHA(candid_id)='$enc_cid'";
		$result=mysqli_query($dbc,$query) or die($query);
		if(mysqli_num_rows($result)==1)
		{
			$row=mysqli_fetch_array($result, MYSQL_ASSOC);
?>		<h3 id="secjobtitle">Candidate Profile (<a href="editprofile?id=<?php echo $enc_cid; ?>">Edit</a>)</h3>
		<div id="can1">
			<div id="can2">
				<div id="can3">
					<div id="can4">
						

<?php
			echo '<h6 id="canname">'.$row['name'].'</h6>';
			echo '<h6 id="cancontact">contact No : '.$row['contactno'].'&nbsp&nbsp|&nbsp&nbsp</h6>';
			echo '<h6 id="canmail">'.$row['ca_email'].'</h6>';
			if(($row['cur_org']=='Fresher')||($row['cur_org']=='Not Working'))
				echo '<h6 id="canstatus">Status: '.$row['cur_org'].'</h6>';
			else
			{
				echo '<h6 id="canstatus">Status: Working with '.$row['cur_org'].'</h6>';
				echo '<h6 id="canstatus">Experience: '.$row['exprnc'].' years</h6>';
				if($row['not_period_dm'])
					$duration="Month(s)";
				else
					$duration="Day(s)";
				echo '<h6 id="canstatus">Notice Period: '.$row['not_period'].' '.$duration.'</h6>';
				echo '<h6 id="canstatus">Current CTC (INR in Lacs): '.number_format($row['cur_ctc']).'</h6>';
			}
			echo '<h6 id="canstatus">Expected CTC (INR in Lacs): '.number_format($row['exp_ctc']).'</h6>';
			if(!empty($row['resext']))
			{
				echo '<h6 id="canstatus">Resume: 
						<form method="post" action="resumeviewer" target="_blank">
							<input type="hidden" name="candid" value="'.$row['candid_id'].'"/>
							<input type="hidden" name="file" value="'.$row['resext'].'"/>
							<input type="submit" value="View Resume" name="submit"/>
						</form>
						<form method="post" action="download">
							<input type="hidden" name="candid" value="'.$row['candid_id'].'"/>
							<input type="hidden" name="file" value="'.$row['resext'].'"/>
							<input type="hidden" name="candidate" value="'.$row['name'].'"/>
							<input type="submit" value="Download Resume" name="submit"/>
						</form>
					</h6>';
			}
			$cid=$row['candid_id'];
			$query="select qname from candid_qualif inner join qualif using(qid) where candid_id=$cid";
			$result1=mysqli_query($dbc, $query) or die('Error');
			if(mysqli_num_rows($result1)>0)
			{
				$cur_qual=array();
				while($row1=mysqli_fetch_array($result1,MYSQL_ASSOC))
					array_push($cur_qual,$row1);
			}
			echo '<h6 id="canqual">Qualifications:</h6>';
			foreach ($cur_qual as $cqual) 
				echo '<div id="canstatus"><br/>'.$cqual['qname'].'</div>';
			$query="select field_title,field_name from candi_field_title";
			$result2=mysqli_query($dbc, $query) or die('Error in setting up');
			if(mysqli_num_rows($result2)>0)
			{
				$user_fields=array();
				while($row2=mysqli_fetch_array($result2, MYSQL_ASSOC))
					array_push($user_fields, $row2);
			}
			if(isset($user_fields))
			{
				foreach($user_fields as $ufield)
				{
					$value=$ufield['field_name'];
					echo '<h6 id="canstatus">'.$ufield['field_title'].' : '.$row[$value].'</h6>';
				}
			}
		}
	}
}
?>
<div id="lovvy">
</div>