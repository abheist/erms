<?php
	$reqlogin=true;
	$css="form";
	require_once ('header.php');
	require_once 'db/connectvars.php';
	$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	if(!$dbc)
	{
		echo '<h2>Error in loading page. Redirecting....</h2>';
		header('refresh:2;url=.');
	}
	//-------------------------------------------------------------------------------------------
	$_SESSION['active']=false;
	$form=true;
	$error="";
	//-------------------------------------------------------------------------------------------
	if(isset($_POST['submit']))
	{
		$form=false;
		$sql_error=false;
		$user_id=$_SESSION['user_id'];
		$job_title=mysqli_real_escape_string($dbc,trim($_POST['job_title']));
		$client_id=mysqli_real_escape_string($dbc, trim($_POST['client_id']));
		$primary_contact=mysqli_real_escape_string($dbc, trim($_POST['primary_contact']));
		$job_owner=mysqli_real_escape_string($dbc, trim($_POST['job_owner']));
	//-------------------------------------------------------------------------------------------
		if(empty($job_title) || !ctype_alpha(str_replace(' ', '', $job_title)) || $client_id<1 || empty($primary_contact))
		{
			$error="Complete Mandatory Fields";
			$form=true;
		}
		else
		{
			if($job_owner>0)
				$job_owner_id=$job_owner;
			else
			{
				if($job_owner==-1 && isset($_POST['owner_name']))
				{
					$owner_name=mysqli_real_escape_string($dbc, trim($_POST['owner_name']));
					$owner_phnno=mysqli_real_escape_string($dbc, trim($_POST['owner_phnno']));
					$owner_email=mysqli_real_escape_string($dbc, trim($_POST['owner_email']));
					$owner_desig=mysqli_real_escape_string($dbc, trim($_POST['owner_desig']));
					if(empty($owner_name) || empty($owner_desig) || empty($owner_phnno) || empty($owner_email))
					{
						$error="Add Job Owner Details";
						$form=true;
					}
					else
					{	
						$check_query="select owner_email from job_owner_details";
						$check_result=mysqli_query($dbc, $check_query) or die('Error');
						while($check_row=mysqli_fetch_array($check_result,MYSQL_ASSOC))
							array_push($oemails,$row['owner_email']);
						if(in_array($owner_email, $oemails))
						{	
							$error="Job Owner Exist with same email address";
							$form=true;
						}
						else
						{
							$own_query="insert into job_owner_details(owner_name,owner_phnno,owner_desig,client_id,owner_email) 
										values('$owner_name','$owner_phnno','$owner_desig',$client_id,'$owner_email')";
							$own_result=mysqli_query($dbc,$own_query);
							if($own_result)
							{
								$own_query="select owner_id from job_owner_details where owner_email='$owner_email'";
								$own_result=mysqli_query($dbc,$own_query) or die('Error 1');
								if(mysqli_num_rows($own_result)==1)
								{
									$own_row=mysqli_fetch_array($own_result,MYSQL_ASSOC);
									$job_owner_id=$own_row['owner_id'];
								}
								else
									$sql_error=true;
							}
							else
								$sql_error=true;
						}
					}
				}
				else
				{
					$form=true;
					$error="Please enter job owner details";
				}
			}
			if(!$form)
			{
				$ins_query="insert into job_opp(job_title,client_id,job_owner,primary_contact,user_id,added_on) 
							values('$job_title',$client_id,$job_owner_id,$primary_contact,$user_id,NOW())";
				$ins_result=mysqli_query($dbc, $ins_query) or die($ins_query);
				if($ins_result)
				{
					$job_id=mysqli_insert_id($dbc);
					$up_query="update job_opp set ";
					if(isset($_POST['job_location']))
					{
						$job_location=mysqli_real_escape_string($dbc, trim($_POST['job_location']));
						$up_query.="job_location='$job_location',";
					}
					if(isset($_POST['job_exprnc']))
					{
						$job_exprnc=mysqli_real_escape_string($dbc, trim($_POST['job_exprnc']));
						$up_query.="job_exprnc='$job_exprnc',";	
					}
					if(isset($_POST['job_qty']))
					{
						$job_qty=mysqli_real_escape_string($dbc, trim($_POST['job_qty']));
						$up_query.="job_qty='$job_qty',";	
					}
					if(isset($_POST['salary']))
					{
						$salary=mysqli_real_escape_string($dbc, trim($_POST['salary']));
						$up_query.="salary='$salary',";	
					}
					if(isset($_POST['not_period']))
					{
						$not_period=mysqli_real_escape_string($dbc, trim($_POST['not_period']));
						$not_period_dm=mysqli_real_escape_string($dbc, trim($_POST['not_period_dm']));
						$up_query.="job_not_period='$not_period', not_period_dm=$not_period_dm,";
					}
					if(isset($_POST['priority']))
					{
						$priority=mysqli_real_escape_string($dbc, trim($_POST['priority']));
						$up_query.="priority=$priority,";
					}
					if(isset($_POST['job_desc']))
					{
						$job_desc=trim($_POST['job_desc']);
						$filename=$job_id.'.txt';
						$path='desc/'.$filename;
						$job_point=fopen($path,"w+") or die("Error in posting");
						fputs($job_point,$job_desc);
						fclose($job_point);
						$up_query.="job_desc='txt',";
					}
					if(isset($_POST['job_other']))
					{
						$job_other=trim($_POST['job_other']);
						$filename=$job_id.'.txt';
						$path='other/'.$filename;
						$job_point=fopen($path,"w+") or die("Error in posting");
						fputs($job_point,$job_other);
						fclose($job_point);
						$up_query.="job_other='txt',";
					}
					if(isset($_POST['qualif']))
					{
						$qualif=trim($_POST['qualif']);
						$up_query.="qualif='$qualif',";
					}
					$up_query=substr($up_query, 0,-1)." where job_id=$job_id";
					$up_result=mysqli_query($dbc, $up_query);
					if($up_result)
					{
						echo 'Posting.....';
						header('refresh:3;url=.');
					}
					else
						$sql_error=true;
				}
				else
					$sql_error=true;
			}//form is false
			if($sql_error)
			{
				$error= 'Error in posting job.';
				$form=true;	
			}
		}//else
	}//form submitted
	if($form)
	{
		$query1="select client_id,client_name from client_details";
		$result=mysqli_query($dbc,$query1);
		if(mysqli_num_rows($result)>0)
		{
			$clients=array();
			while($row1=mysqli_fetch_array($result))
				array_push($clients,$row1);	
			echo '<script type="text/javascript">';
			echo 'function configureDropDownLists(cl,cp,pc,jo){' ;
			foreach($clients as $cl)
			{
				$client_id=$cl['client_id'];
				
				
				$declare='var c'.$client_id.' = new Array(';
				$valdeclare='var cv'.$client_id.' = new Array(';
				$query2="select cp_id,cp_name,cp_desig from contact_person_details where client_id=$client_id";
				$result2=mysqli_query($dbc,$query2);
				if(mysqli_num_rows($result2)>0)
				{
					while($row2=mysqli_fetch_array($result2))
					{
						$declare.="'".$row2['cp_name']." (".$row2['cp_desig'].")', ";
						$valdeclare.="'".$row2['cp_id']."', ";
					}
					$declare=substr($declare,0,-2).");";
					$valdeclare=substr($valdeclare,0,-2).");";
				}
				else
				{
					$declare.="'No Clients Available');";
					$valdeclare.="'-1');";
				}
				echo $declare;
				echo $valdeclare;
			
				
				$jdeclare='var j'.$client_id.' = new Array(';
				$jvaldeclare='var jv'.$client_id.' = new Array(';
				$query3="select owner_id,owner_name,owner_desig from job_owner_details where client_id=$client_id";
				$result3=mysqli_query($dbc,$query3);
				if(mysqli_num_rows($result3)>0)
				{
					while($row3=mysqli_fetch_array($result3))
					{
						$jdeclare.="'".$row3['owner_name']." (".$row3['owner_desig'].")', ";
						$jvaldeclare.="'".$row3['owner_id']."', ";
					}
					$jdeclare=substr($jdeclare,0,-2).");";
					$jvaldeclare=substr($jvaldeclare,0,-2).");";
				}
				else
				{
					$jdeclare.="'No Owners Available');";
					$jvaldeclare.="'-1');";
				}
				echo $jdeclare;
				echo $jvaldeclare;
			}
			echo 'switch (cl.value){'; 
    		foreach($clients as $cl)
    		{
    			echo "case '".$cl['client_id']."':";
            	echo "cp.options.length = 0;";
            	echo "pc.options.length = 0;";
            	echo "jo.options.length = 0;";
            	echo "for (i = 0; i < c".$cl['client_id'].".length; i++) {";
	            echo "createOption(cp, c".$cl['client_id']."[i], cv".$cl['client_id']."[i]);";
	            echo "createOption(pc, c".$cl['client_id']."[i], cv".$cl['client_id']."[i]);}";
	            echo "for (i = 0; i < j".$cl['client_id'].".length; i++) {";
	            echo "createOption(jo, j".$cl['client_id']."[i], jv".$cl['client_id']."[i]);}";
            	echo 'break;';
    		}
        	echo " }}";
    		echo 'function createOption(ddl, text, value){';
        	echo "var opt = document.createElement('option');";
        	echo "opt.value = value;";
        	echo "opt.text = text;";
        	echo "ddl.options.add(opt);}";
    		echo '</script>';
    	}
?>
		<h2 id="jobhead">Job Opportunity</h2>


		<?php echo $error; ?>


		<div id="formbox1">
			<div id="formbox2">
				<div id="formbox13">
					<div id="formbox4" class="firstex">
						<h3 id="secjobhead">Job Description</h3>
						<form method="post" action="form">
						<select class="form-control" name="client_id" id="cl" onchange="configureDropDownLists(this,document.getElementById('cp'),document.getElementById('pc'),document.getElementById('jo'))">
							<option value="0" selected> Choose Client* </option>
							<?php
								if(!isset($clients))
									echo '<option value=-1>None(Add New)</option>';
								else
									foreach($clients as $cl)
										echo '<option value='.$cl['client_id'].'>'.$cl['client_name'].'</option>';
							?>
						</select>
						<select multiple class="form-control" name="cp[]" id="cp">
						<option value="-1" selected> No Contact Person</option>
						</select>
						<a href="add_cp" id="adclientbut">Add Client </a>
					</div>

				</div>
			</div>
		</div>
		
		<div id="formbox1">
			<div id="formbox2">
				<div id="formbox3">
					<div id="formbox4">
						<div id="jobdet">		
							<h3 id="secjobhead">Job Details</h3>
								<b>Job Title*:</b><br><input type="text" placeholder="Software Engineer" name="job_title" class="jobtit" required><br>

								<b>Job Location:</b><br><textarea placeholder="Mountain View" name="job_location" class="jobtit"></textarea><br>

								<b>Experience:(in yrs)</b><br><input type="number" class="jobtit" placeholer="2" name="job_exprnc"><br>

								<b>Qunatity:</b><br><input type="text" placeholder="10" class="jobtit" name="job_qty"><br>

								<b>Salary:</b><br><input type="text" placeholder="10 Lacs" class="jobtit" name="salary"><br>

								<b>Notice Period:</b><br><input type="text" name="not_period" name="job_not_period" placeholder="Notice Period" class="jobtit" id="leba"><br/>
								<span id="labspan"><b>in:</b></span>
								<select name="not_period_dm" class="form-control" class="jobtit" id="labela">
										<option value="0" selected>Day(s)</option>
										<option value="1">Month(s)</option>
									</select>
								
								
								
						</div>		
					</div>
				</div>
			</div>
		</div>	
		
		<div id="formbox1">
			<div id="formbox2">
				<div id="formbox3">
					<div id="formbox4">
						<h3 id="secjobhead">Qualification</h3>
						<textarea id="jobsummary" placeholder="B.Tech, M.Tech, MBA" name="qualif"></textarea>
					</div>
				</div>
			</div>
		</div>

		<div id="formbox1">
			<div id="formbox2">
				<div id="formbox3">
					<div id="formbox4">
						<h3 id="secjobhead">Job Description</h3>
						<textarea id="jobsummary" placeholder="Job Description..." name="job_desc"></textarea>			
					</div>
				</div>
			</div>
		</div>
	
		<div id="formbox1">
			<div id="formbox2">
				<div id="formbox3">
					<div id="formbox4">
						<h3 id="secjobhead">Any Other Details(if any)</h3>
						<textarea id="jobsummary" placeholder="Other Details..." name="job_other"></textarea>
					</div>
				</div>
			</div>
		</div>
		
		<div id="formbox1">
			<div id="formbox2">
				<div id="formbox3">
					<div id="formbox4">
						<h3 id="secjobhead">Client Contact Details</h3>
						<b>Primary Contact Person: </b>
						<select id="pc" class="form-control" name="primary_contact">
							<option value="-1" selected>None</option>
						</select>
						<b>Priority: </b>
						<select class="form-control" name="priority">
							<option value="1" selected>ASAP</option>
							<option value="2">1 Week</option>
							<option value="3">2 Week</option>
							<option value="4">3 Week</option>
						</select>
					</div>
				</div>
			</div>
		</div>
					
		<div id="formbox1">
			<div id="formbox2">
				<div id="formbox3">
					<div id="formbox4">
						<h3 id="secjobhead">Job Owner Details</h3>
						<b>Job Owner Name: </b>
						<select class="form-control" name="job_owner" id="jo">
						<option value="-1" selected> None </option>
						</select>
						
						<div class="form-group">						
							<input type="text" class="form-control" placeholder="Kapil Agrawal" name="owner_name"><br/>
							<input type="text" class="form-control" placeholder="9837449449" name="owner_phnno"><br/>
							<input type="text" class="form-control" placeholder="kapil.agrawal947@gmail.com" name="owner_email"><br/>
							<input type="text" class="form-control" placeholder=" HR Manager" name="owner_desig"><br/>
						</div>
						<input type="submit" class="btn-success" name="submit" value="Add Job"/>
					</div>
				</div>
			</div>
		</div>
	
		</body>
		</html>

<?php
	}
?>
