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
$query="select field_title,field_name from candi_field_title";
$result=mysqli_query($dbc, $query) or die('Error in setting up');
if(mysqli_num_rows($result)>0)
{
	$user_fields=array();
	while($row=mysqli_fetch_array($result, MYSQL_ASSOC))
		array_push($user_fields, $row);
}
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
	$not_period_dm=$_POST['not_period_dm'];
	$added_by=$_SESSION['user_id'];
	if(isset($_FILES['resume']))
	{
		$res_name=mysqli_real_escape_string($dbc, $_FILES['resume']['name']);
		$res_size=mysqli_real_escape_string($dbc, $_FILES['resume']['size']);
		$res_ext=strtolower(end(explode('.',$res_name)));
	}
	if(empty($name) || empty($contactno) || empty($ca_email) || empty($exp_ctc) || strlen($contactno)!=10)
	{
			$form=true;
			$error="Please fill out all valid entries";
	}
	else if(!ctype_alpha(str_replace(' ', '',$name)))
	{
		$form=true;
		$error="Name can not contain numeric characters";
	}
	else
	{
			if($ca_check==2 && (empty($cur_org) || empty($cur_ctc) || empty($not_period) && $not_period!=0))
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
		else
		{
			if(($res_ext=='doc')||($res_ext=='pdf')||($res_ext=='docx'))
				$form=false;
			else
				$form=true;			
		}
		if(!$form)
		{
			if($ca_check==1)
			{
					$cur_org="Not Working";
					$cur_ctc=0;
					$not_period=0;
					$not_period_dm=0;
			}
			else if($ca_check==0)
			{
				$cur_org="Fresher";
				$cur_ctc=0;
				$not_period=0;
				$not_period_dm=0;
			}
			$query="insert into candidate_details(name,contactno,ca_email,cur_org,exp_ctc,exprnc,cur_ctc,not_period,not_period_dm,added_by) values('$name',$contactno,'$ca_email','$cur_org',$exp_ctc,$exprnc,$cur_ctc,$not_period,$not_period_dm,$added_by)";	
			mysqli_query($dbc,$query) or die($query);
			$query="select candid_id from candidate_details where ca_email='$ca_email'";
			$result=mysqli_query($dbc,$query) or die('Error in querying');
			$row=mysqli_fetch_array($result);
			$canid=$row['candid_id'];
			if(isset($user_fields))
			{
				$query="update candidate_details set ";
				foreach($user_fields as $ufield)
				{
					$value=mysqli_real_escape_string($dbc, trim($_POST[substr($ufield['field_title'], 0,4)]));
					$query.=$ufield['field_name']."='".$value."' , " ;
				}
				$query=substr($query,0,-2)."where candid_id=$canid";
				mysqli_query($dbc,$query) or die($query);
			}
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
			if(isset($res_name))
			{
				$res_name=$canid.'.'.$res_ext;
				$res_path="resumes/".$res_name;
				if(move_uploaded_file($_FILES['resume']['tmp_name'], $res_path))
				{
					$query="update candidate_details set resext='$res_ext' where candid_id=$canid";
					$result=mysqli_query($dbc, $query);
				}
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

				 <form name="add_candy" method="post" action="add_candy" enctype="multipart/form-data">
					Full Name: <input type="text" placeholder="Name" class="inputv" name="name" required <?php if(isset($name)) echo "value=$name";?> ><br/>
					Contact No: <input type="text" placeholder="Contact No." maxlength="10" size="10" class="inputv" name="contactno" required <?php if(isset($contactno)) echo "value=$contactno";?>><br/>
					E-Mail: <input type="email" placeholder="E-Mail" class="inputv" name="ca_email" required <?php if(isset($ca_email)) echo "value=$ca_email";?>><br/>
					<label>Current Status: <select name="org">
						<option value="0">Fresher</option>
						<option value="1">Currently Not Working</option>
						<option value="2" selected>Working </option>
					</select></label>
					Current Organisation: <input type="text" name="cur_org" placeholder="Current Organisation" class="inputv" readonly="true" onclick="add_org()" /><br/>
					Experience: <input type="text" name="exprnc" placeholder="Experience" class="inputv" required ><br>
					Current CTC: <input type="text" name="cur_ctc" placeholder="Current CTC" class="inputv" required readonly="true" onclick="add_ctc()"><br>
					Expected CTC: <input type="text" name="exp_ctc" placeholder="Expected CTC" class="inputv" required onclick="check_exp()"><br>
					Notice Period: <input type="text" name="not_period" placeholder="Notice Period" class="inputv" required readonly="true" onclick="add_nop()"><br>
					<label>Notice Period in:
					<select name="not_period_dm">
						<option value="0" selected>Day(s)</option>
						<option value="1">Month(s)</option>
					</select></label><br/>
					<label>Qualifications:</label>
					<div>
						<?php
							foreach($qual as $q)
							{
								echo '<erms><input type="checkbox" name="qual[]" value="'.$q['qid'].'"><span id="ermsid">'.$q['qname'].'</span></erms>';
						 	}
						?>
					</div><br/>
					<label>Upload Resume:(pdf/doc only)* </label>
					<div><input type="file" name="resume"/></div>
					<div style="clear:both;height:20px;"></div>
					<input type="checkbox" name="qualif" value="-1"/> Add one (If not listed)
					<input type="text" name="addqualif" class="inputv" placeholder="Add Qualification" readonly="readonly" onclick="add_qual()" <?php if(isset($add_qualif)) echo "value=$add_qualif";?>/>
<?php
					if(isset($user_fields))
					{
						foreach($user_fields as $ufield)
							echo $ufield['field_title'].'<input type="text" class="inputv" placeholder="'.$ufield['field_title'].'" name="'.substr($ufield['field_title'],0,4).'"/>';
					}
					echo '<input type="submit" name="submit" class="inputv" id="submitbutton" value="Add Candidate">';
				echo '</form>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</body>';
echo '</html>';
}
?>
