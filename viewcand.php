<?php
  $reqlogin=true;
  $css="viewrec";
  require_once ('header.php');
  echo '<h1><center>Candidates</center></h1>';
  echo '<table border="1" cellpadding="10" ><tr>';
  echo '<th><a href="viewcand?val=1" style="text-decoration:none; color:white;"> Name </a> </th>';
  echo '<th> <a href="viewcand?val=2" style="text-decoration:none; color:white;">Email </a></th>';
  echo '<th> Conatct No. </a></th>';
	echo '</tr>';
  require_once('db/connectvars.php');
  $dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
  $query="select name,contactno,ca_email from candidate_details order by";
  if(isset($_GET['val']))
    if($_GET['val']==1)
      $query.=" name";
    else if($_GET['val']==2)
      $query.=" ca_email";
    else
      header('Location:viewrec');
  else
    $query.=" name"; 
  $result=mysqli_query($dbc,$query) or die('Error in querying');
  if(mysqli_num_rows($result)>0)
    while($row=mysqli_fetch_array($result))
    {
      echo '<tr><td><a href="profile?id=">'.$row['name'].'</a></td>';
      echo '<td>'.$row['ca_email'].'</td>';
      echo '<td>'. $row['contactno'].'</td></tr>';
		}
?>
</table>
