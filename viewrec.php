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
  if(isset($_GET['code']))
  {
    if(!empty($_GET['code']))
    {
      $enc_uid=$_GET['code'];
      if(isset($_GET['down']))
      {
        if(!empty($_GET['down']))
        {
          $user_right=$_GET['down'];
          $query="update user_details set user_right=$user_right where SHA(user_id)='$enc_uid'";
          mysqli_query($dbc, $query);
        }
      }
      if(isset($_GET['up']))
      {
        if(!empty($_GET['up']) || $_GET['up']>=0)
        {
          $user_right=$_GET['up'];
          $query="update user_details set user_right=$user_right where SHA(user_id)='$enc_uid'";
          mysqli_query($dbc, $query); 
        }
      }
    }
  }
  $query="select SHA(user_id) as enc_id,user_id,user_name, user_email, user_right,active from user_details order by";
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
    require_once('search.php');
    while($row=mysqli_fetch_array($result))
    {
  
        echo '<tr><td><abhiypad>'.$row['user_name'].'<abhiypad></td>';
        echo '<td>'. $row['user_email'].'</td><td>'.getright($row['user_right']).'</td>';
        if($_SESSION['user_right']==0)
        {
          if(!$row['active'])
          {
            echo '<td><a href="viewdel"> Deactivated </a></td>';
          }
          else if($row['user_id']!=$_SESSION['user_id'])
          {
            $code=$row['enc_id'];
            echo '<td><a href="del_recruit?code='.$code.'">Delete</a>';
            if($row['user_right']>-1 && $row['user_right']!=3)
            {
              $down_right=$row['user_right']+1;
              echo'/<a href="viewrec?code='.$code.'&down='.$down_right.'">Downgrade to '.getright($down_right).'</a>';
            }  
            if($row['user_right']>-1 && $row['user_right']!=0)
            {
              $up_right=$row['user_right']-1;
              echo'/<a href="viewrec?code='.$code.'&up='.$up_right.'">Upgrade to '.getright($up_right).'</a></td>';
            }  
          }
          else
           echo '<td><a href="del_acc?code='.$_SESSION['user_id'].'">Delete Your Account</a></td>'; 
        }
        echo '</tr>';
      
    } // end of while
  }
  else
    header('Location: .');
  echo '</table>';
?>

