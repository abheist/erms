<?php
function error($str)
{
	echo '<center><h1>SQL Error:</h1><br/> '.$str;
	echo '<h1>Redirecting...</center></h1>';
	$_SESSION['active']=true;
	header('refresh:3;url=addfield_cand');
}
?>