<?php
$reqlogin=true;
$css='add_candy';
$js="add_candy";
require_once 'header.php';
if(isset($_SESSION['user_right']))
	if($_SESSION['user_right']>1)
		header('Location: .');
require_once('db/connectvars.php');
$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
$error="";
$form=false;
$query="select field_title,field_name from candi_field_title";
$result=mysqli_query($dbc, $query) or die('Error in setting up');
if(mysqli_num_rows($result)>0)
{
	$user_fields=array();
	while($row=mysqli_fetch_array($result, MYSQL_ASSOC))
		array_push($user_fields, $row);
}
if(isset($_GET['id']))
{
	if(!empty($_GET['id']))
	{
		$form=true;
		$enc_cid=$_GET['id'];
		require_once 'db/connectvars.php';
		$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
		$query="select * from candidate_details where SHA(candid_id)='$enc_cid'";
		$result=mysqli_query($dbc,$query) or die($query);
		if(mysqli_num_rows($result)==1)
		{
			$row=mysqli_fetch_array($result, MYSQL_ASSOC);
			$name=$row['name'];
			$contactno=$row['contactno'];
			$ca_email=$row['ca_email'];
			$cur_org=$row['cur_org'];
			$exp_ctc=$row['exp_ctc'];
			if($row['cur_org']=='Fresher')
				$org=0;
			else if($row['cur_org']=='Not Working')
				$org=1;
			else
			{
				$org=2;
				$exprnc=$row['exprnc'];
				$not_period_dm=$row['not_period_dm'];
				$not_period=$row['not_period'];
				$cur_ctc=$row['cur_ctc'];
			}
		}
	}
}
if($form)
{
	$qual=array();
	$query="select qid,qname from qualif";
	$result=mysqli_query($dbc,$query) or die('Error in querying');
	while($row=mysqli_fetch_array($result))
		array_push($qual,$row);
?>
		<div id="can1">
			<div id="can2">
				<div id="can3">
					<div id="can4">
						<h3 id="secjobhead" class="editcandyview">Edit Candidate Profile </h3>

					<?php echo $error;	?>

				 <form name="add_candy" method="post" action="editprofile">
					<input type="text" placeholder="Name" class="inputv" name="name" required <?php if(isset($name)) echo "value=$name";?> ><br/>
					<input type="text" placeholder="Contact No." maxlength="10" size="10" class="inputv" name="contactno" required <?php if(isset($contactno)) echo "value=$contactno";?>><br/>
					<input type="email" placeholder="E-Mail" class="inputv" name="ca_email" required <?php if(isset($ca_email)) echo "value=$ca_email";?>><br/>
					
					<?php
						if(isset($org))
						{
							if(!$org)
							{
								echo '<label>Current Status: <select name="org">';
								echo '<option value="0" selected>Fresher</option>';
								echo '<option value="1">Currently Not Working</option>';
								echo '<option value="2">Working </option></select></label>';
							}
							else if($org==1)
							{	
								echo '<label>Current Status: <select name="org">';
								echo '<option value="0">Fresher</option>';
								echo '<option value="1" selected>Currently Not Working</option>';
								echo '<option value="2">Working </option></select></label>';
							}
							else if($org==2)
							{
								echo '<label>Current Status: <select name="org">';
								echo '<option value="0">Fresher</option>';
								echo '<option value="1">Currently Not Working</option>';
								echo '<option value="2" selected>Working </option></select></label>';
								echo '<input type="text" name="cur_org" placeholder="Current Organisation" class="inputv" readonly="true" onclick="add_org()" value="'.$cur_org.'" /><br/>';
								echo '<input type="text" name="exprnc" placeholder="Experience" class="inputv" value="'.$exprnc.'" required ><br>';
								echo '<input type="text" name="cur_ctc" placeholder="Current CTC" class="inputv" required readonly="true" onclick="add_ctc()" value="'.$cur_ctc.'"><br>';
								echo '<input type="text" name="exp_ctc" placeholder="Expected CTC" class="inputv" required onclick="check_exp()" value="'.$exp_ctc.'"><br>';
								echo '<input type="text" name="not_period" placeholder="Notice Period" class="inputv" required readonly="true" onclick="add_nop()" value="'.$not_period.'"><br>';
								echo '<label>Notice Period in:
										<select name="not_period_dm">';
										if(!$not_period_dm)
										{
											echo '<option value="0" selected>Day(s)</option>';
											echo '<option value="1" >Month(s)</option>';
										}
										else if($not_period_dm==1)
										{
											echo '<option value="0">Day(s)</option>';
											echo '<option value="1" selected>Month(s)</option>';
										}
										echo '</select>
										</label><br/>';
							}
						}
					?>	
					<label>Qualifications:</label>
					<div>
						<?php
							foreach($qual as $q)
							{
								echo '<erms><input type="checkbox" name="qual[]" value="'.$q['qid'].'"><span id="ermsid">'.$q['qname'].'</span></erms>';
						 	}
						?>
					</div>
					<div style="clear:both;height:20px;"></div>
					<input type="checkbox" name="qualif" value="-1"/> Add one (If not listed)
					<input type="text" name="addqualif" class="inputv" placeholder="Add Qualification" readonly="readonly" onclick="add_qual()" <?php if(isset($add_qualif)) echo "value=$add_qualif";?>/>
<?php
					if(isset($user_fields))
					{
						foreach($user_fields as $ufield)
							echo '<input type="text" class="inputv" placeholder="'.$ufield['field_title'].'" name="'.substr($ufield['field_title'],0,4).'"/>';
					}
					echo '<input type="submit" name="submit" class="inputv" id="submitbutton" value="Add Candidate">';
				echo '</form>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
	echo'</body>';
	echo '</html>';
}?>