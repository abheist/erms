<?php
  $reqlogin=true;
  $css="viewrec";
  require_once ('header.php');
?>  
<table border="1">
<tr>
  <th> Name </th>
  <th> Contact No. </th>
  <th> E-mail </th>
<?php
	echo '</tr>';
  require_once('db/connectvars.php');
  $dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
  $query="select name,contactno,ca_email from candidate_details order by name";
  $result=mysqli_query($dbc,$query) or die('Error in querying');
  if(mysqli_num_rows($result)>0)
    while($row=mysqli_fetch_array($result))
    {
      echo '<tr><td><a href="profile?id=">'.$row['name'].'</a></td>';
      echo '<td>'.$row['contactno'].'</td>';
      echo '<td>'. $row['ca_email'].'</td></tr>';
		}
?>
</table>
