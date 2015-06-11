<?php
	$reqlogin=true;
	require_once 'header.php';
	if(isset($_GET['val']))
	{
		if($_GET['val']>0)
		{
			require_once 'db/connectvars.php';
			$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
			$limit=$_GET['val']-1;
			$query="select column_name as col from information_schema.columns where table_schema='".DB_NAME."' and table_name='candidate_details' limit $limit, 1";
			$result=mysqli_query($dbc, $query) or die('Error in querying');
			if(mysqli_num_rows($result)!=1)
				header('Location:.');
			$row=mysqli_fetch_array($result);
			$col_name=$row['col'];
			$query="alter table candidate_details drop column $col_name";
			mysqli_query($dbc, $query) or die($query);
			$query="delete from candi_field_title where field_name='$col_name'";
			mysqli_query($dbc, $query) or die($query);
			echo 'Requested Column has been deleted. Redirecting.....';
			header('refresh:2;url=addfield_cand');
		}
	}
?>