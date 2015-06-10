
<?php
session_start();
if(isset($_SESSION['user_name']) || isset($_SESSION['user_id']) || isset($_SESSION['user_right']))
	session_destroy();
header('Location: .');
?>