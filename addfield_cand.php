<?php
	$reqlogin=true;
	$css="viewrec";
	$form=true;
	$error="";
	require_once 'header.php';
	require_once 'db/connectvars.php';
	require_once 'function.php';
	if(isset($_SESSION['active']))
		if($_SESSION['active'])
			$form=false;
	$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
	if(isset($_POST['submit']) || !$form)
	{
		$form=false;
		$form2=true;
		if(isset($_POST['add']))
		{
			$form2=false;
			$col_name=mysqli_real_escape_string($dbc,trim($_POST['col_name']));
			$col_title=mysqli_real_escape_string($dbc,trim($_POST['col_title']));
			$col_type=mysqli_real_escape_string($dbc, trim($_POST['col_type']));
			$null=mysqli_real_escape_string($dbc, trim($_POST['null']));
			$default=mysqli_real_escape_string($dbc, trim($_POST['default']));
			if(empty($col_name) || empty($col_type) || empty($col_title)) 
			{
				$form2=true;
				$error="Please Fill all entries!!";
			}
			if(!$form2)
			{
				$query="alter table candidate_details add column ".$col_name." ".$col_type;
				if($null)
					$query.=" not null";
				if(!empty($default))
					$query.=" default $default";	
				mysqli_query($dbc, $query) or die(error(mysqli_error($dbc)));
				$query="insert into candi_field_title(field_title,field_name) values('$col_title','$col_name')";
				mysqli_query($dbc, $query) or die('Error in updating');
			}
		}
		if(!isset($_SESSION['active']))
		{
			$pass=mysqli_real_escape_string($dbc, trim($_POST['pass']));
			$query="select user_name from user_details where user_pass=SHA('$pass')";
			$result=mysqli_query($dbc,$query) or die('Error in querying');
			if(mysqli_num_rows($result)==1)
			{
				$_SESSION['active']=true;
			}
			else
			{
				$form=true;
				$error="Incorrect Password";
			}
		}
		if(!$form)
		{
			$query= "select column_name as col from information_schema.columns where table_schema='".DB_NAME."' and table_name='candidate_details' and column_name not in (select field_name from candi_field_title)";
			$result=mysqli_query($dbc,$query) or die($query);
			$no_cols=mysqli_num_rows($result);
			if($no_cols>0)
			{
				echo '<h1><center>Pre-Defined Fields for candidate form('.$no_cols.')</center></h1>';
				echo '<table border="1">';
				echo '<tr><th> S.No. </th> <th> Field Name </th> </tr>';
				$i=1;
				while($row=mysqli_fetch_array($result,MYSQL_ASSOC))
					echo '<tr><td>'.$i++.'</td><td>'.$row['col'].'</td></tr>';
				echo '</table>';
			}
			$query= "select field_name from candi_field_title";
			$result=mysqli_query($dbc,$query) or die($query);
			if(mysqli_num_rows($result)>0)
			{
				echo '<h1><center>User-defined Fields for candidate form('.mysqli_num_rows($result).')</center></h1>';
				echo '<table border="1">';
				echo '<tr><th> S.No. </th> <th> Field Name </th> <th> Action </th></tr>';
				$i=1;
				while($row=mysqli_fetch_array($result,MYSQL_ASSOC))
				{				
					$col_no=$no_cols+$i;
					echo '<tr><td>'.$i++.'</td><td>'.$row['field_name'].'</td><td><a href="delfield_cand?val='.$col_no.'">Delete</a></td></tr>';
				}
				echo '</table>';
			}
			if($form2)
			{
				echo '<h1><center>Add Fields</center></h1>';
				echo $error;
				echo '<center><form method="post" action="addfield_cand">';
				echo '<input type="hidden" name="submit" value="true" id="addfieldname1"/>';
				echo '<input type="text" name="col_name" placeholder="Field Name" id="addfieldname2" required/>';
				echo '<br/><input type="text" name="col_title" placeholder="Field Title for user" id="addfieldname3" required/>';
				echo '<br/><input type="text" name="col_type" placeholder="Valid Field Type and Size e.g. varchar(10) etc." id="addfieldname4" required/>';
				echo '<br/> <input type="radio" name="null" value="0" checked/> Null <input type="radio" name="null" id="addfieldname5" value="1"/> Not Null ';
				echo '<br/> Default Value(if any): <input type="text" name="default" placeholder="Default Value" id="addfieldname6" />';
				echo '<br/><input name="add" type="submit" value="Add Field" id="subbutt" />';
				echo '</form></center>';
			}
		}
	}
	if($form)
	{
		echo $error;
		echo '<center><form method="post" action="addfield_cand">';
		echo 'Password: <input type="password" name="pass"/>';
		echo '<input type="submit" name="submit" value="Submit"/>';
		echo '</form></center>';
	}
?>