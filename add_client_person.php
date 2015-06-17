<?php	
if(!isset($_GET['id']))
	$val=1;
else
	$val= $_GET['id'];
$sendid=$val+1;
$ajaxid="ajax".$val;
?>
<script>
    $(function(){$('#add_person<?php echo $val; ?>').click(function(){$('#ajax<?php echo $val; ?>').load('add_client_person.php?id=<?php echo $sendid; ?>')})})
</script>
<div class="form-group">
	<label for="client_name">Contact Person <?php echo $val; ?> Details: </label>
	<input type="text" class="form-control" placeholder="Kapil Agrawal" name="cp_name<?php echo $val; ?>" required><br/>
	<input type="text" class="form-control" placeholder="9837449449" name="cp_phnno<?php echo $val; ?>" required><br/>
	<input type="text" class="form-control" placeholder="kapil.agrawal947@gmail.com" name="cp_email<?php echo $val; ?>" required><br/>
	<input type="text" class="form-control" placeholder=" HR Manager" name="cp_desig<?php echo $val; ?>" required><br/>
</div>
<span style="cursor:pointer"><p id="add_person<?php echo $val; ?>" class="well well-sm"> Add Another Contact Person </p></span>
<div id="<?php echo $ajaxid; ?>">
</div>