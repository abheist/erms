<?php
$css = "delrec";
if(isset($_POST['yes']))
{
	$reqlogin=true;
	require_once 'header.php';
	$recid=$_POST['recid'];
	require_once 'db/connectvars.php';
	$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
	$query="delete from user_details where user_id=$recid";
	mysqli_query($dbc, $query) or die($query);
	echo '<h1 id="reddel">Recruiter has been successfully deleted. Redirecting ....</h1>';
	$submit=true;
	header('refresh:2; url=viewrec');
}
if(isset($_POST['no']))
{	
	$submit=true;
	header('Location: viewrec');
}
if(isset($_GET['id']))
{
	if(!empty($_GET['id']) && strlen($_GET['id'])==41)
	{
		$reqlogin=true;
		require_once 'header.php';
		$recid=substr($_GET['id'],-1,1);
		echo '<div id="deldiv"><h1 id="delname">Are you sure to want to delete this recruiter?</h1>';
		echo '<form method="post" action="del_recruit">';
		echo '<input type="hidden" name="recid" value="'.$recid.'"/>';
		echo '<input type="submit" id="delyes" name="yes" value="Yes"/>';
		echo '<input type="submit" id="delno" name="no" value="No"/></div>';
	}
	else if(!$submit)
		header('Location:.');
}
else if(!$submit)
	header('Location:.');
?>