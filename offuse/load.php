<?php
session_start();
if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name']) || !isset($_SESSION['user_right']))
	header('Location: .');
if(isset($_GET['val']))
{
	if($_GET['val']=='out')
	{
?>
<html>
<head>
	<title>Redirecting..</title>
</head>
<body>
	<div style="margin: 250px 0px 0px 600px;">
		<div>
			<img src="img/301.gif">
		</div>
	</div>
</body>
</html>
<?php
	header("refresh:5;url=logout");
	}
}
else
	header('Location:.');
?>
