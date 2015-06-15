<?php
$reqlogin=true; 
$css="viewrec";
require_once 'header.php';
if(isset($_POST['submit']) || isset($_GET['search']))
{
	require_once 'db/connectvars.php';
	$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error in searching');
	if(isset($_GET['search']))
		$search=$_GET['search'];
	else
		$search=mysqli_real_escape_string($dbc, $_POST['search']);
	require_once 'search.php';
	$query=search($search)." order by ";
	if(isset($_GET['val']))
    	if($_GET['val']==1)
      		$query.=" name";
    	else if($_GET['val']==2)
      		$query.=" ca_email";
      	else if($_GET['val']==4)
      		$query.=" added_by";
    	else
    		$query.=" name";
  	else
	    $query.=" name"; 
	$result=mysqli_query($dbc, $query) or die("Error in searching");
	if(mysqli_num_rows($result)>0)
	{
		echo '<table border="1" cellpadding="10"><tr>';
	?>
  		<th><a href="cansearch?search=<?php echo $search; ?>&val=1" style="text-decoration:none; color:white;"> Name </a> </th>
  		<th> <a href="cansearch?search=<?php echo $search; ?>&val=2" style="text-decoration:none; color:white;">Email </a></th>
  		<th> Conatct No. </th>
  		<th>  <a href="cansearch?search=<?php echo $search; ?>&val=4" style="text-decoration:none; color:white;"> Added By </a></th>
  		<?php
  		
		while($row=mysqli_fetch_array($result))
    	{
      		echo '<tr><td><a href="profile?id='.$row['cid'].'" target="_blank">'.$row['name'].'</a></td>';
      		echo '<td>'.$row['ca_email'].'</td>';
      		echo '<td>'. $row['contactno'].'</td>';
      		echo '<td>'. $row['user_name'].'</td></tr>';
		}
	}
	else
		echo 'No Results Found';
}
?>
<form method="post" action="cansearch">
	<input type="search" name="search" placeholder="Search" value="<?php if(isset($search)) echo $search; ?>" id="inputsearchfield" /><br>
	<input type="submit" value="Search" name="submit" id="subbutti"/>
</form>
