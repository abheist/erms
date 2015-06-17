<?php
if(isset($_POST['submit']))
{
	$reqlogin=true;
	require_once('header.php');
	$name=$_POST['candid'].'.'.$_POST['file'];
?>
	<center>
		<h1> View Resume </h1>
		<object data="resumes/<?php echo $name;?>" type="application/pdf" width="80%" height="675px">
		 	<p>It appears you don't have a PDF plugin for this browser.
  				No biggie... you can 
  				<a href="resume/<?php echo $name; ?>">click here to download the PDF file.</a>
  			</p>
 		</object>
 	</center>
<?php
	}
?>
