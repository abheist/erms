<?php
	$reqlogin=true;
	$css="add_recruit";
	require_once 'header.php';
	if(isset($_SESSION['user_right']))
		if($_SESSION['user_right']>0)
			header('Location: .');
	$error="";
	$form=true;
	if(isset($_POST['submit']))
	{
		$form=false;
		require_once('db/connectvars.php');
		$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
		$client_name=mysqli_real_escape_string($dbc, $_POST['client_name']);
		$client_addr=mysqli_real_escape_string($dbc, $_POST['client_addr']);
		if(empty($client_name) || empty($client_addr))
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
			$query="insert into client_details(client_name,client_addr) values('$client_name','$client_addr')";
			$result=mysqli_query($dbc,$query);
			if($result)
			{
				$query="select client_id from client_details where client_name='$client_name' and client_addr='$client_addr'";
				$result=mysqli_query($dbc, $query);
				if(mysqli_num_rows($result)==1)
				{
					$row=mysqli_fetch_array($result,MYSQL_ASSOC);
					$client_id=$row['client_id'];
					$query="insert into contact_person_details(cp_name,cp_phnno,cp_email,cp_desig,client_id) values";
					foreach($client_details as $cd)
						$query.= "('".$cd['cp_name']."','".$cd['cp_phnno']."','".$cd['cp_email']."','".$cd['cp_desig']."',".$client_id."),";
					$result=mysqli_query($dbc,substr($query,0,-1)) or die($query);
					if($result)
						header('Location: .');
				}
				else
				{
					$error="Error in adding client details";
					$form=true;
				}
			}
			else
			{
				$error="Error in adding client details";
				$form=true;
			}
		}
	}
	if($form)
	{
?>
		
		<div id="rec1">
			<div id="rec2">
				<div id="rec3">
					<div id="rec4">
						<h3 id="addhead">Add Client</h3>
						<?php echo $error; ?>					
						<form method="post" action="add_client">
							<div class="form-group">
								<label for="client_name">Client Name: </label>
								<input type="text" class="form-control" placeholder="Erasmith Technologies Pvt Ltd" name="client_name" value="<?php if(isset($client_name)) echo $client_name;?>" required><br/>
							</div>
							<div class="form-group">
								<label for="client_addr">Client Address: </label>
								<textarea class="form-control" rows="5" placeholder="Shiksha Bharti School Rd, Block C, Palam Extension, Palam Colony, New Delhi, Delhi 110077" name="client_addr" required></textarea><br/>
							</div>
							<?php require_once 'add_client_person.php'; ?>
							<input type="submit"  class="btn-success" name="submit" value="Add Client">
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
