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
?>
		<div id="can1">
			<div id="can2">
				<div id="can3">
					<div id="can4">
						<h3 id="secjobtitle">Candidate Profile (<a href="editprofile">Edit</a>)</h3>

<?php
			echo '<h6 id="secjobhead">Name: '.$row['name'].'</h6>';
			echo '<h6 id="secjobhead">Contact No. : '.$row['contactno'].'</h6>';
			echo '<h6 id="secjobhead">E-mail: '.$row['ca_email'].'</h6>';
			if(($row['cur_org']=='Fresher')||($row['cur_org']=='Not Working'))
				echo '<h6 id="secjobhead">Status: '.$row['cur_org'].'</h6>';
			else
			{
				echo '<h6 id="secjobhead">Status: Working in '.$row['cur_org'].'</h6>';
				echo '<h6 id="secjobhead">Experience: '.$row['exprnc'].' years</h6>';
				echo '<h6 id="secjobhead">Notice Period: '.$row['not_period'].' months</h6>';
				echo '<h6 id="secjobhead">Current CTC: Rs. '.number_format($row['cur_ctc']).'</h6>';
			}
			echo '<h6 id="secjobhead">Expected CTC: Rs. '.number_format($row['exp_ctc']).'</h6>';
		}
	}
}
?>