<?php
  $reqlogin=true;
  $css="viewrec";
  $search="";
  require_once('db/connectvars.php');
  $dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
  $query="select SHA(candid_id) as cid,name,contactno,ca_email,user_name from candidate_details inner join user_details on candidate_details.added_by=user_details.user_id order by";
  if(isset($_POST['submit']))
  {
    require_once 'search.php';
    $search=$_POST['search'];
    $query=search($_POST['search'])." order by";
  }
  require_once ('header.php');
  echo '<h1><center>Candidates</center></h1>';
  echo '<form method="post" action="viewcand">';
  echo '<input type="search" name="search" placeholder="Search" value="'.$search.'" id="inputsearchfield" class="subbu" /><a href="viewcand" id="subbu">View All</a>';
  echo '';
  echo '<input type="submit" value="Search" name="submit" id="subbutti"/>';
  echo '</form>';
  echo '<table border="1" cellpadding="10" ><tr>';
  echo '<th><a href="viewcand?val=1" style="text-decoration:none; color:white;"> Name </a> </th>';
  echo '<th> <a href="viewcand?val=2" style="text-decoration:none; color:white;">Email </a></th>';
  echo '<th> Conatct No. </th>';
  echo '<th>  Added By </th>';
	echo '</tr>';
  
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
  {
    while($row=mysqli_fetch_array($result))
    {
      echo '<tr><td><a href="profile?id='.$row['cid'].'">'.$row['name'].'</a></td>';
      echo '<td>'.$row['ca_email'].'</td>';
      echo '<td>'. $row['contactno'].'</td>';
      echo '<td>'. $row['user_name'].'</td></tr>';
		}
  }
  else
    echo '<td colspan="4" align="center" >No Candidates Available</td>';
?>
</table>
