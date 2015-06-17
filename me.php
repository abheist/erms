<?php
$reqlogin=true;
$css="viewrec";
require_once ('header.php');
$_SESSION['active']=false;
echo '<h1><center>Recent Job Opportunities</center></h1>';
  echo '<table border="1" cellpadding="10" ><tr>';
  echo '<th>S.No.</th>';
  echo '<th><a href="#">Job Title</a></th>';
  echo '<th><a href="#">Client</a> </th>';
  echo '<th><a href="#">Added On</a></th>';
  echo '<th><a href="#">Assigned To</a></th>';
	echo '</tr>';
  require_once('db/connectvars.php');
  $dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
  $query="select SHA(job_id) as jid,job_title,client_id,added_on,assign_to from job_opp";
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
  $i=1;
  if(mysqli_num_rows($result)>0)
    while($row=mysqli_fetch_array($result))
    {
      echo '<tr><td>'.$i++.'</td><td><a href="viewjob?id='.$row['jid'].'">'.$row['job_title'].'</a></td>';
      echo '<td>'.$row['client_id'].'</td>';
      echo '<td>'. $row['added_on'].'</td>';
      echo '<td>'. $row['assign_to'].'</td></tr>';
		}
?>
</table>

</body>
</html>
