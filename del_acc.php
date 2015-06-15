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
		echo "Error in Deletion. Come back later1.";
		header('refresh:2;url=viewrec');
	}
	$query="update user_details set active=0,del_on=NOW() where user_id=$recid";
	$result=mysqli_query($dbc, $query);
	if($result)
	{
		session_destroy();
		echo '<h1 id="reddel">Your has been successfully deleted. Redirecting ....</h1>';
		$submit=true;
		header('refresh:2; url=.');
	}
	else
	{
		echo "Error in Deletion. Come back later2.";
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
	if(!empty($_GET['code']))
	{
		$reqlogin=true;
		require_once 'header.php';
		$code=$_GET['code'];
		require_once 'db/connectvars.php';
		$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
		$query="select user_id from user_details where user_id=$code";
		$result=mysqli_query($dbc, $query) or die($query);
		if(mysqli_num_rows($result)!=1)
			header('Location:.');
		$row=mysqli_fetch_array($result,MYSQL_ASSOC);
		$recid=$row['user_id'];
		echo '<div id="deldiv"><h1 id="delname">Are you sure to want to DEACTIVATE your account? *Superuser can active your account.</h1>';
		echo '<form method="post" action="del_acc">';
		echo '<input type="hidden" name="recid" value="'.$recid.'"/>';
		echo '<input type="submit" id="delyes" name="yes" value="Yes"/>';
		echo '<input type="submit" id="delno" name="no" value="No"/></div>';
	}
}
?>