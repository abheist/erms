<?php
	$reqlogin=true;
	$css="add_recruit";
	require_once 'header.php';
	if(isset($_SESSION['user_right']))
		if($_SESSION['user_right']>0)
			header('Location: .');
	$error="";
	$form=true;
	require_once('db/connectvars.php');
	$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
	if(isset($_POST['submit']))
	{
		$form=false;
		$client_id=mysqli_real_escape_string($dbc, $_POST['client_id']);
		if($client_id<1)
		{
			$error="Please enter all details";
			$form=true;
		}
		else
		{
			$i=1;
			$client_details=array();
			while(isset($_POST['cp_name'.$i]) && !$form)	
			{
				$cp_name=mysqli_real_escape_string($dbc,$_POST['cp_name'.$i]);
				$cp_phnno=mysqli_real_escape_string($dbc,$_POST['cp_phnno'.$i]);
				$cp_email=mysqli_real_escape_string($dbc,$_POST['cp_email'.$i]);
				$cp_desig=mysqli_real_escape_string($dbc,$_POST['cp_desig'.$i]);
				if(empty($cp_name) || empty($cp_phnno) || empty($cp_email) || empty($cp_desig) || strlen($cp_phnno)!=10)
				{
					$error="Please fill all details of contact persons";
					$form=true;
				}
				else
				{
					$index=$i-1;
					$client_details[$index]['cp_name']=$cp_name;
					$client_details[$index]['cp_phnno']=$cp_phnno;
					$client_details[$index]['cp_email']=$cp_email;
					$client_details[$index]['cp_desig']=$cp_desig;
					$i++;
				}
			}
		}
		if(!$form)
		{
			$client_id=$client_id;
			$query="insert into contact_person_details(cp_name,cp_phnno,cp_email,cp_desig,client_id) values";
			foreach($client_details as $cd)
			$query.= "('".$cd['cp_name']."','".$cd['cp_phnno']."','".$cd['cp_email']."','".$cd['cp_desig']."',".$client_id."),";
			$result=mysqli_query($dbc,substr($query,0,-1)) or die($query);
			if($result)
				header('Location:.');
		}
	}
	if($form)
	{
		$query="select client_id,client_name,client_addr from client_details";
		$result=mysqli_query($dbc,$query) or die($query);
		$clients=array();
		if(mysqli_num_rows($result)>0)
			while($row=mysqli_fetch_array($result))
				array_push($clients, $row);
		else
		{
			$clients['client_id']=-1;
			$clients['client_name']='No Clients Availables';
			$clients['client_addr']='Choose client';
		}
?>
		
		<div id="rec1">
			<div id="rec2">
				<div id="rec3">
					<div id="rec4">
						<h3 id="addhead">Add Client Person</h3>
						<?php echo $error; ?>					
						<form method="post" action="add_cp">
							<div class="form-group">
								<label for="client_name">Choose Client: </label>
								<select id="client" class="form-control" name="client_id" onchange="configureaddress(this,document.getElementById('addr')">
									<option value="0"> Choose Client </option>
									<?php
										foreach($clients as $client)
											echo '<option value='.$client['client_id'].'>'.$client['client_name'].'</option>';
									?>
								</select>	
							</div>
							<?php require_once 'add_client_person.php'; ?>
							<input type="submit" class="btn-success" name="submit" value="Add Client Persons">
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
