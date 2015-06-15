<?php
  $reqlogin=true;
  $css="viewrec";
  require_once ('header.php');
  echo '<h1><center>Deactivated Recuiters</center></h1>';
  echo '<table border="1" cellpadding="10" ><tr>';
  echo '<th><a href="viewdel?val=1" style="text-decoration:none; color:white;"> Name </a> </th>';
  echo '<th> <a href="viewdel?val=2" style="text-decoration:none; color:white;">Email </a></th>';
  echo '<th> <a href="viewdel?val=3" style="text-decoration:none; color:white;">Deactivated On </a></th>';
  if($_SESSION['user_right']==0)
    echo '<th> Action </th>';
  echo '</tr>';
  require_once('db/connectvars.php');
  $dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
  if(isset($_GET['code']))
  {
    if(!empty($_GET['code']))
    {
      $enc_uid=$_GET['code'];
      $query="update user_details set active=1 where SHA(user_id)='$enc_uid'";
      $result=mysqli_query($dbc, $query);
      echo '<script>alert("Activated Successfully");</script>';
    }
  }
  $query="select SHA(user_id) as enc_id,user_id,user_name, user_email, user_right,del_on from user_details where active=0 order by";
  if(isset($_GET['val']))
    if($_GET['val']==1)
      $query.=" user_name";
    else if($_GET['val']==2)
      $query.=" user_email";
    else if($_GET['val']==3)
      $query.=" del_on";
    else
      header('Location:viewdel');
  else
    $query.=" user_name";
  $result=mysqli_query($dbc,$query) or die('Error in querying');
  if(mysqli_num_rows($result)>0)
  {
    require_once('search.php');
    while($row=mysqli_fetch_array($result))
    { 
        echo '<tr><td><abhiypad>'.$row['user_name'].'<abhiypad></td>';
        echo '<td>'. $row['user_email'].'</td><td>'.$row['del_on'].'</td>';
        if($row['user_id']!=$_SESSION['user_id'])
        {
          $code=$row['enc_id'];
          echo '<td><a href="#">Delete</a>';
          echo'/<a href="viewdel?code='.$code.'">Activate</a></td>';
        }
        echo '</tr>';
    } // end of while
  }
  else
    header('Location: .');
  echo '</table>';
?>

