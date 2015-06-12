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
				echo '<h6 id="canstatus">Status: Working in '.$row['cur_org'].'</h6>';
				echo '<h6 id="canstatus">Experience: '.$row['exprnc'].' years</h6>';
				if($row['not_period_dm'])
					$duration="Month(s)";
				else
					$duration="Day(s)";
				echo '<h6 id="canstatus">Notice Period: '.$row['not_period'].' '.$duration.'</h6>';
				echo '<h6 id="canstatus">Current CTC: Rs. '.number_format($row['cur_ctc']).'</h6>';
			}
			echo '<h6 id="canstatus">Expected CTC: Rs. '.number_format($row['exp_ctc']).'</h6>';
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
		}
	}
}
?>
<div id="lovvy">
</div>