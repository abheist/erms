<?php
  $reqlogin=true;
  $css="viewrec";
  require_once ('header.php');
  $_SESSION['active']=false;
  require_once('db/connectvars.php');
  $dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in connection');
  $query="(select SHA(j.job_id) as col1, j.job_title as col2, cd.client_name as col3, j.assign_to as col4, jd.owner_name as col5, cp.cp_name as col6, jd.owner_phnno as col7,jd.owner_email as col8,cp_email as col9, cp_phnno as col10,j.added_on as col11 from job_opp as j, client_details as cd, job_owner_details as jd, contact_person_details as cp where cd.client_id=j.client_id and  jd.owner_id=j.job_owner and j.primary_contact=cp.cp_id and j.assign_to is NULL)
UNION
(select SHA(j.job_id) as col1, j.job_title as col2, cd.client_name as col3, u.user_name as col4, jd.owner_name as col5, cp.cp_name as col6, jd.owner_phnno as col7,jd.owner_email as col8,cp_email as col9, cp_phnno as col10,j.added_on as col11  from job_opp as j, client_details as cd,user_details as u, job_owner_details as jd, contact_person_details as cp where u.user_id=j.assign_to)
";
  
  $result=mysqli_query($dbc,$query) or die($query);
  if(mysqli_num_rows($result)>0)
  {
    echo '<h1><center>Recent Job Opportunities</center></h1>';
    echo '<table border="1" cellpadding="10" >';
     echo '<tr>';
        echo '<th>S.No.</th>';
        echo '<th>Job Title</th>';
        echo '<th>Client </th>';
        echo '<th>Added On</th>';
        echo '<th>Assigned To</th>';
        echo '<th>Job Owner</th>';//col5
        echo '<th>Primary Contact</th>';//col6
      echo '</tr>';
      $i=1;
      while($row=mysqli_fetch_array($result))
      {
        echo '<tr><td>'.$i++.'</td><td><a href="viewjob?id='.$row['col1'].'">'.$row['col2'].'</a></td>';
        echo '<td>'.$row['col3'].'</td>';
        echo '<td>'. date('M j, Y g:i A', strtotime($row['col11'])).'</td>';
        if(empty($row['col4']))
          echo ' <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href="assign?assign='.$row['col1'].'" id="assignbut">Assign Now</a></h3></td>';
        else
          echo '<td>'. $row['col4'].'</td>';
          echo '<td title="Email: '.$row['col8'] .' and  Contact No.: '.$row['col7'].'">'. $row['col5'].'</td>';
          echo '<td title="Email: '.$row['col9'] .' and  Contact No.: '.$row['col10'].'">'. $row['col6'].'</td>';
		  }
    echo '</table>';
  }
  else
    echo '<h3>No Recent Jobs Available</h3>';
?>
<style>
#assignbut  {
  padding: 5px;
  color: white;
  border-radius: 4px;
  box-shadow: 0px 1px 2px grey;
  background: #009933;
}
</style>
</body>
</html>
