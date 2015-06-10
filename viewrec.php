<?php
  $reqlogin=true;
  $css="viewrec";
  require_once ('header.php');
?>  
<table border="1" cellpadding="10" >
<tr>
  <th> Name </th>
  <th> Email </th>
  <th> Status </th>
<?php
	if($_SESSION['user_right']==0)
  	echo '<th> Action </th>';
	echo '</tr>';
  require_once('db/connectvars.php');
  $dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
  $query="select SHA(user_id) as enc_id,user_id,user_name, user_email, user_right from user_details order by user_name";
  $result=mysqli_query($dbc,$query) or die('Error in querying');
  if(mysqli_num_rows($result)>0)
  {
    while($row=mysqli_fetch_array($result)){
    echo '<tr><td><abhiypad>'.$row['user_name'].'<abhiypad></td>';
    echo '<td>'. $row['user_email'].'</td><td>';
    switch ($row['user_right']) {
      case 0:
        echo 'Admin';
        break;

      case 1:
          echo 'Moderator';
          break;

      case 2:
            echo 'Content Manager';
            break;

      default:
            echo 'Member';
            break;
    }
    echo '</td>';
		if($_SESSION['user_right']==0)
    {
      $sendid=$row['enc_id'].$row['user_id'];
    	echo '<td><a href="del_recruit?id='.$sendid.'">Delete</a></td>';
    }
		echo '</tr>';
		} // end of while
  }
?>
</table>

