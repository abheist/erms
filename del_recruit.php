<?php
$css = "delrec";
if(isset($_POST['yes']))
{
	$reqlogin=true;
	require_once 'header.php';
	$recid=$_POST['recid'];
	require_once 'db/connectvars.php';
	$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
	$query="delete from temp where actual_id=$recid";
	$result=mysqli_query($dbc, $query);
	if(!$result)
	{
		echo "Error in Deletion. Come back later.";
		header('refresh:2;url=viewrec');
	}
	$query="delete from user_details where user_id=$recid";
	$result=mysqli_query($dbc, $query);
	if($result)
	{
		echo '<h1 id="reddel">Recruiter has been successfully deleted. Redirecting ....</h1>';
		$submit=true;
		header('refresh:2; url=viewrec');
	}
	else
	{
		echo "Error in Deletion. Come back later.";
		header('refresh:3;url=viewrec');
	}
}
if(isset($_POST['no']))
{	
	$submit=true;
	header('Location: viewrec');
}
if(isset($_GET['code']))
{
	if(!empty($_GET['code']) && strlen($_GET['code'])==40)
	{
		$reqlogin=true;
		require_once 'header.php';
		$code=$_GET['code'];
		require_once 'db/connectvars.php';
		$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
		$query="select user_id from user_details where SHA(user_id)='$code'";
		$result=mysqli_query($dbc, $query) or die($query);
		if(mysqli_num_rows($result)!=1)
			header('Location:.');
		$row=mysqli_fetch_array($result,MYSQL_ASSOC);
		$recid=$row['user_id'];
		echo '<div id="deldiv"><h1 id="delname">Are you sure to want to delete this recruiter?</h1>';
		echo '<form method="post" action="del_recruit">';
		echo '<input type="hidden" name="recid" value="'.$recid.'"/>';
		echo '<input type="submit" id="delyes" name="yes" value="Yes"/>';
		echo '<input type="submit" id="delno" name="no" value="No"/></div>';
	}
}
?>