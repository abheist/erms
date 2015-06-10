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
$form=true;
if(isset($_POST['submit']))
{
	$form=false;
	$add=false;
	$name=mysqli_real_escape_string($dbc,trim($_POST['name']));
	$contactno=mysqli_real_escape_string($dbc,trim($_POST['contactno']));
	$ca_email=mysqli_real_escape_string($dbc,trim($_POST['ca_email']));
	$ca_check=mysqli_real_escape_string($dbc,trim($_POST['org']));
	$cur_org=mysqli_real_escape_string($dbc,trim($_POST['cur_org']));
	$exprnc=mysqli_real_escape_string($dbc,trim($_POST['exprnc']));
	$cur_ctc=mysqli_real_escape_string($dbc,trim($_POST['cur_ctc']));
	$exp_ctc=mysqli_real_escape_string($dbc,trim($_POST['exp_ctc']));
	$not_period=mysqli_real_escape_string($dbc,trim($_POST['not_period']));
	if(empty($name) || empty($contactno) || empty($ca_email) || empty($exp_ctc) || strlen($contactno)!=10)
	{
			$form=true;
			$error="Please fill out all valid entries";
	}
	else
	{
			if($ca_check==2 && (empty($cur_org) || empty($cur_ctc) || empty($not_period)))
			{
					$form=true;
					$error="Please fill your current organisation's details";
			}
			if($ca_check<2 && (!empty($cur_org) || !empty($cur_ctc) || !empty($not_period)) )
			{
					$form=true;
					$error="You have to be working for current organisations details";
			}
			if($exprnc!=0 && empty($exprnc))
			{
				$form=true;
				$error="Experince field empty";
			}
	}
	if(!$form)
	{
		$user_email=strtolower($ca_email);
		$query="select ca_email from candidate_details where ca_email	= '$ca_email'";
		$result=mysqli_query($dbc,$query) or die('Error in querying');
		$emails=array();
		while($row=mysqli_fetch_array($result))
			array_push($emails,$row['ca_email']);
		if(in_array($user_email,$emails))
		{
			$form=true;
			$error="Email Already Registered";
		}
		else if(isset($_POST['qualif']))
				if($_POST['qualif']==-1)
				{
					$add_qualif=mysqli_real_escape_string($dbc,trim($_POST['addqualif']));
					$add_qualif_arr=explode('.', $add_qualif);
					$addarr=array();
					foreach($add_qualif_arr as $addq)
						array_push($addarr,ucwords(strtolower($addq)));
					$add_qualif=implode('.', $addarr);
					$query="select qname from qualif where qname='$add_qualif'";
					$result=mysqli_query($dbc,$query) or die('Error in querying');
					if(mysqli_num_rows($result)==1)
					{
						$form=true;
						$error=" Added qualification already exists.";
					}
					else {
						$add=true;
					}
				}
		if(!$form)
		{
			if($ca_check==1)
			{
					$cur_org="Not Working";
					$cur_ctc=0;
					$not_period=0;
			}
			else if($ca_check==0)
			{
				$cur_org="Fresher";
				$cur_ctc=0;
				$not_period=0;
			}
			$query="insert into candidate_details(name,contactno,ca_email,cur_org,exp_ctc,exprnc,cur_ctc,not_period) values('$name',$contactno,'$ca_email','$cur_org',$exp_ctc,$exprnc,$cur_ctc,$not_period)";
			mysqli_query($dbc,$query) or die($query);
			$query="select candid_id from candidate_details where ca_email='$ca_email'";
			$result=mysqli_query($dbc,$query) or die('Error in querying');
			$row=mysqli_fetch_array($result);
			$canid=$row['candid_id'];
			if($add)
			{
				$query="insert into qualif(qname) values('$add_qualif')";
				mysqli_query($dbc,$query) or die('Error in querying');
				$query="select qid from qualif where qname='$add_qualif'";
				$result=mysqli_query($dbc, $query) or die('Error in querying');
				if(mysqli_num_rows($result)==1)
				{
					$row=mysqli_fetch_array($result);
					$qid=$row['qid'];
				}
				$query="insert into candid_qualif(candid_id,qid) values($canid,$qid)";
				mysqli_query($dbc, $query) or die('Error in querying');
			}
			if(isset($_POST['qual']))
			{
				$query="insert into candid_qualif(candid_id,qid) values ";
				foreach($_POST['qual'] as $q)
					$query.="($canid,$q),";
				mysqli_query($dbc, substr($query,0,-1)) or die($query);
			}
			header('Location: viewcand');
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
					<h3 id="secjobhead">Add Candidate</h3>

					<?php echo $error;	?>

				 <form name="add_candy" method="post" action="add_candy">
					<input type="text" placeholder="Name" class="inputv" name="name" required <?php if(isset($name)) echo "value=$name";?> ><br/>
					<input type="text" placeholder="Contact No." maxlength="10" size="10" class="inputv" name="contactno" required <?php if(isset($contactno)) echo "value=$contactno";?>><br/>
					<input type="email" placeholder="E-Mail" class="inputv" name="ca_email" required <?php if(isset($ca_email)) echo "value=$ca_email";?>><br/>
					<label>Current Status: <select name="org">
						<option value="0">Fresher</option>
						<option value="1">Not Working</option>
						<option value="2">Working </option>
					</select></label>
					<input type="text" name="cur_org" placeholder="Current Organisation" class="inputv" readonly="true" onclick="add_org()" /><br/>
					<input type="text" name="exprnc" placeholder="Experience" class="inputv" required ><br>
					<input type="text" name="cur_ctc" placeholder="Current CTC" class="inputv" required readonly="true" onclick="add_ctc()"><br>
					<input type="text" name="exp_ctc" placeholder="Expected CTC" class="inputv" required onclick="check_exp()"><br>
					<input type="text" name="not_period" placeholder="Notice Period" class="inputv" required readonly="true" onclick="add_nop()"><br>
					Qualifications:
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
					<input type="submit" name="submit" class="inputv" id="submitbutton" value="Add Candidate">
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
