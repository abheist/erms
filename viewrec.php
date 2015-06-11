<?php
  $reqlogin=true;
  $css="viewrec";
  require_once ('header.php');
  echo '<h1><center>Recuiters</center></h1>';
  echo '<table border="1" cellpadding="10" ><tr>';
  echo '<th><a href="viewrec?val=1" style="text-decoration:none; color:white;"> Name </a> </th>';
  echo '<th> <a href="viewrec?val=2" style="text-decoration:none; color:white;">Email </a></th>';
  echo '<th> <a href="viewrec?val=3" style="text-decoration:none; color:white;">Status </a></th>';
  if($_SESSION['user_right']==0)
    echo '<th> Action </th>';
  echo '</tr>';
  require_once('db/connectvars.php');
  $dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
  $query="select SHA(user_id) as enc_id,user_id,user_name, user_email, user_right from user_details order by";
  if(isset($_GET['val']))
    if($_GET['val']==1)
      $query.=" user_name";
    else if($_GET['val']==2)
      $query.=" user_email";
    else if($_GET['val']==3)
      $query.=" user_right";
    else
      header('Location:viewrec');
  else
    $query.=" user_name";
  $result=mysqli_query($dbc,$query) or die('Error in querying');
  if(mysqli_num_rows($result)>0)
  {
    while($row=mysqli_fetch_array($result))
    {
      echo '<tr><td><abhiypad>'.$row['user_name'].'<abhiypad></td>';
      echo '<td>'. $row['user_email'].'</td><td>';
      switch ($row['user_right']) 
      {
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
        if($row['user_id']!=$_SESSION['user_id'])
        {
          $code=$row['enc_id'];
          echo '<td><a href="del_recruit?code='.$code.'">Delete</a></td>';
        }
        else
        {
         echo '<td>Request Admin to Delete</td>'; 
        }
      }
      echo '</tr>';
    } // end of while
  }
  else
    header('Location: .');
  echo '</table>';
?>

