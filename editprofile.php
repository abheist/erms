<?php
$reqlogin=true;
$css='add_candy';
$js="add_candy";
require_once 'header.php';
if(isset($_SESSION['user_right']))
	if($_SESSION['user_right']>1)
		header('Location: .');
//--------------------------------UNAUTHORIZED ACCESS PROHIBITED---------------------------------------------------
require_once('db/connectvars.php');
$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
//--------------------------------DATABASE CONNECTION ESTABLISHED--------------------------------------------------
$error="";
$form=true;
//--------------------------------VARIABLES INITIALIZED------------------------------------------------------------
$query="select field_title,field_name from candi_field_title"; 
$result=mysqli_query($dbc, $query) or die('Error in setting up');
if(mysqli_num_rows($result)>0)
{
	$user_fields=array();
	while($row=mysqli_fetch_array($result, MYSQL_ASSOC))
		array_push($user_fields, $row);
}
//--------------------------------USER DEFINED FIELDS LOADED-------------------------------------------------------
if(isset($_GET['id']))
{
	if(!empty($_GET['id']))
	{
		$form=true;
		$enc_cid=$_GET['id'];
	}
}
else if(isset($_POST['submit']))
	$enc_cid=$_POST['user'];
else
	header('Location:.');
//--------------------------------ACTIVE CANDIDATE ENC_ID TAKEN----------------------------------------------------
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
//--------------------------------FORM DATA TAKEN------------------------------------------------------------------
	if(empty($name) || empty($contactno) || empty($ca_email) || empty($exp_ctc) || strlen($contactno)!=10)
	{
			$form=true;
			$error="Please fill out all valid entries";
	}
	else if(!ctype_alpha(str_replace(' ', '',$name)))
	{
		$form=true;
		$error='Invalid Characters in name';
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
//--------------------------------FORM CHECKED FOR ERRORS EXCEPT E-MAIL and ADDED QUALIFICATION (IF ANY)-------------------------
	if(!$form)
	{
		$upquery="update candidate_details set ";
//--------------------------------QUERY TO UPDATE INITIALIZED------------------------------------------------------
		$user_email=strtolower($ca_email);
		$query="select ca_email from candidate_details where ca_email= '$user_email' and SHA(candid_id)!='$enc_cid'";
		$result=mysqli_query($dbc,$query) or die('Error in querying');
		$emails=array();
		while($row=mysqli_fetch_array($result))
			array_push($emails,$row['ca_email']);
		if(in_array($user_email,$emails))
		{
			$form=true;
			$error=$query;
		}
//--------------------------------E-MAIL VERIFIED------------------------------------------------------------------
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
//--------------------------------ADDED QUALIFICATION VERIFFIED----------------------------------------------------
		if(!$form)
		{
			if($ca_check==1)
			{
					$cur_org="Not Working";
					$exprnc=0;
					$cur_ctc=0;
					$not_period=0;
					$not_period_dm=0;
			}
			else if($ca_check==0)
			{
				$cur_org="Fresher";
				$exprnc=0;
				$cur_ctc=0;
				$not_period=0;
				$not_period_dm=0;
			}
//--------------------------------CHECKED FOR FRESHER OR NOT WORRKING------------------------------------------------------------
			$upquery.=" name='$name' , contactno='$contactno' , ca_email='$ca_email' , cur_org='$cur_org' , exp_ctc=$exp_ctc , exprnc=$exprnc , cur_ctc=$cur_ctc , not_period=$not_period , not_period_dm=$not_period_dm where SHA(candid_id)='$enc_cid'";
			mysqli_query($dbc,$upquery) or die($upquery);
//--------------------------------QUERY EXECUTED FOR UPDATION EXCEPT QUALIFICATION-----------------------------------------------
			$query="select candid_id from candidate_details where ca_email='$ca_email'";
			$result=mysqli_query($dbc,$query) or die('Error in querying');
			$row=mysqli_fetch_array($result);
			$canid=$row['candid_id'];
//--------------------------------ACTIVE CANDIDATE ID TAKEN----------------------------------------------------------------------
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
//--------------------------------ADDED QUALIFICATION UPDATED IN DATABASE--------------------------------------------------------
			if(isset($_POST['qual']))
			{
				$query="select qid from candid_qualif where SHA(candid_id)='$enc_cid'";
				$result1=mysqli_query($dbc, $query) or die('Error');
				if(mysqli_num_rows($result1)>0)
				{
					$cur_qual=array();
					while($row=mysqli_fetch_array($result1,MYSQL_ASSOC))
						array_push($cur_qual,$row['qid']);
				}	
//--------------------------------GET QUALIFICATONS INITIALY TAKEN BY USER-----------------------------------------
				$upqual=false;
				$query="insert into candid_qualif(candid_id,qid) values ";
				foreach($_POST['qual'] as $q)
					if(!in_array($q, $cur_qual))
					{
						$query.="($canid,$q),";
						$upqual=true;
					}
				if($upqual)
					mysqli_query($dbc, substr($query,0,-1)) or die($query);
				$delqual=false;
				$query="delete from candid_qualif where qid in(";
				foreach ($cur_qual as $cur) 
						if(!in_array($cur, $_POST['qual']))
						{
							$query.=$cur.",";
							$delqual=true;
						}
				if($delqual)
				{
					$query=substr($query, 0,-1).")";
					mysqli_query($dbc,$query) or die($query);
				}	
			}
//--------------------------------QUALIFICATIONS ADDED OR REMOVED--------------------------------------------------
			if(isset($user_fields))
			{
				$query="update candidate_details set ";
				foreach($user_fields as $ufield)
				{
					$value=mysqli_real_escape_string($dbc, trim($_POST[substr($ufield['field_title'], 0,4)]));
					$query.=$ufield['field_name']."='".$value."' , " ;
				}
				$query=substr($query,0,-2)."where SHA(candid_id)='$enc_cid'";
				mysqli_query($dbc,$query) or die($query);
			}
//--------------------------------ENTRIES IN USER DEFINED FIELDS UPDATED--------------------------------------------------
			header('Location: viewcand');
		}// Form is False
	}// Form is False
}// Form is submitted
//--------------------------------FORM SUBMITTED-------------------------------------------------------------------
if($form)
{
	$query="select * from candidate_details where SHA(candid_id)='$enc_cid'";
	$result=mysqli_query($dbc,$query) or die($query);
	if(mysqli_num_rows($result)==1)
	{
		$row=mysqli_fetch_array($result, MYSQL_ASSOC);
		$cid=$row['candid_id'];
		$name=$row['name'];
		$contactno=$row['contactno'];
		$ca_email=$row['ca_email'];
		$cur_org=$row['cur_org'];
		$exp_ctc=$row['exp_ctc'];
		if($row['cur_org']=='Fresher')	
		{			
			$org=0;
			unset($cur_org);
		}
		else if($row['cur_org']=='Not Working')
		{
			$org=1;
			unset($cur_org);
		}
		else
		{
			$org=2;
			$exprnc=$row['exprnc'];
			$not_period_dm=$row['not_period_dm'];
			$not_period=$row['not_period'];
			$cur_ctc=$row['cur_ctc'];
		}
		$query="select qid from candid_qualif where candid_id=$cid";
		$result1=mysqli_query($dbc, $query) or die('Error');
		if(mysqli_num_rows($result1)>0)
		{
			$cur_qual=array();
			while($row=mysqli_fetch_array($result1,MYSQL_ASSOC))
				array_push($cur_qual,$row['qid']);
		}
		$qual=array();
		$query="select qid,qname from qualif";
		$result=mysqli_query($dbc,$query) or die('Error in querying');
		while($row=mysqli_fetch_array($result))
			array_push($qual,$row);
	}
?>
	<div id="can1">
		<div id="can2">
			<div id="can3">
				<div id="can4">
					<h3 id="secjobhead" class="editcandyview">Edit Candidate Profile </h3>
					<?php 
						echo $error;	
					?>
				 	<form name="add_candy" method="post" action="editprofile">
						<input type="text" placeholder="Name" class="inputv" name="name" value="<?php if(isset($name)) echo $name;?>" required /><br/>
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
									echo '<option value="2" selected>Working </option>';
								echo '</select></label>';
							}
						}
								echo '<input type="text" name="cur_org" placeholder="Current Organisation" class="inputv" readonly="true" onclick="add_org()"';
								if(isset($cur_org))
									echo ' value="'.$cur_org.'" ';
								echo '/><br/>';
								echo '<input type="text" name="exprnc" placeholder="Experience" class="inputv"'; 
								if(isset($exprnc))
									echo ' value="'.$exprnc.'" ';
								echo '/><br/>';
								echo '<input type="text" name="cur_ctc" placeholder="Current CTC" class="inputv" readonly="true" onclick="add_ctc()"';
								if(isset($cur_ctc))
									echo ' value="'.$cur_ctc.'" ';
								echo '/><br/>';  
								echo '<input type="text" name="exp_ctc" placeholder="Expected CTC" class="inputv"  onclick="check_exp()" value="'.$exp_ctc.'"><br>';
								echo '<input type="text" name="not_period" placeholder="Notice Period" class="inputv"  readonly="true" onclick="add_nop()"';
								if(isset($not_period))
									echo ' value="'.$not_period.'" ';
								echo '/><br/>';  
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
						echo '<label>Qualifications:</label>';
						echo '<div>';
								foreach($qual as $q)
								{
									echo'<erms><input type="checkbox" name="qual[]" value="'.$q['qid'].'"';
									if(isset($cur_qual))
									{
										if(in_array($q['qid'], $cur_qual))
											echo ' checked';
									}
									echo '/><span id="ermsid">'.$q['qname'].'</span></erms>';
						 		}
						echo '</div>';
					?>
					<div style="clear:both;height:20px;"></div>
					<input type="checkbox" name="qualif" value="-1"/> Add one (If not listed)
					<input type="text" name="addqualif" class="inputv" placeholder="Add Qualification" readonly="readonly" onclick="add_qual()" <?php if(isset($add_qualif)) echo "value=$add_qualif";?>/>
					<?php
						if(isset($user_fields))
						{
							foreach($user_fields as $ufield)
								echo '<input type="text" class="inputv" placeholder="'.$ufield['field_title'].'" name="'.substr($ufield['field_title'],0,4).'"/>';
						}
						echo '<input type="hidden" name="user" class="inputv" id="submitbutton" value="'.$enc_cid.'">';
						echo '<input type="submit" name="submit" class="inputv" id="submitbutton" value="Update Details">';
					echo '</form>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
	echo'</body>';
	echo '</html>';
}
						?>