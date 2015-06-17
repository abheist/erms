<?php
	$reqlogin=true;
	$css="viewrec";
	require_once 'header.php';
	require_once 'db/connectvars.php';
	$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('error');
	$query="select * from contact_person_details inner join client_details using(client_id)";
	if(isset($_GET['val']))
	{
		switch($_GET['val'])
		{
			case 1: $query.=" order by cp_name";
					break;
			case 2: $query.=" order by client_name";
					break;
		}
	}
	$result=mysqli_query($dbc, $query) or die('Error in Querying');
	echo '<h1><center><a href="viewclient">Clients Details</a></center></h1>';
	echo '<table border=1>';
		echo '<tr>';
			echo '<th>S.No.</th>';
			echo '<th><a href="viewclient?val=1">Contact Person</a></th>';
			echo '<th><a href="viewclient?val=2">Client</a></th>';
			echo '<th>Contact No.</th>';
			echo '<th>E-Mail</th>';
		echo '</tr>';
		$i=1;
		while($row=mysqli_fetch_array($result,MYSQL_ASSOC))
		{
			echo '<tr>';
				echo '<td>'.$i++.'</td>';
				echo '<td>'.$row['cp_name'].'</td>';
				echo '<td>'.$row['client_name'].'</td>';
				echo '<td>'.$row['cp_phnno'].'</td>';
				echo '<td>'.$row['cp_email'].'</td>';
			echo '</tr>';
		}
	echo '</table>';
?>