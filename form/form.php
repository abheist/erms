<?php
$reqlogin=true;
$css="form";
require_once ('header.php');
$_SESSION['active']=false;
?>	
	<h2 id="jobhead">Job Opportunity</h2>
	<div id="formbox1">
		<div id="formbox2">
			<div id="formbox13">
				<div id="formbox4" class="firstex">
					<select class="form-control">
						<option>Google Inc.</option>
						<option>Microsoft</option>
						<option>Apple Inc.</option>
					</select>
					<div id="checking"><input type="checkbox"><span> Client</span></div>
				</div>
			</div>
		</div>
	</div>


	<div id="formbox1">
		<div id="formbox2">
			<div id="formbox3">
				<div id="formbox4">
					<div id="jobdet">		
						<h3 id="secjobhead">Job Details</h3>
							Job Title: <input type="text" placeholder="Software Engineer"><br>
							Location: <input type="text" placeholder="Mountain View"><br>
							Experience:(in years) <input type="number" placeholer="2"><br>
							Qunatity: <input type="text" placeholder="10"><br>
							<label>Qualifications:</label>
						<?php
							foreach($qual as $q)
							{
								echo '<erms><input type="checkbox" name="qual[]" value="'.$q['qid'].'"><span id="ermsid">'.$q['qname'].'</span></erms>';
						 	}
						?>
					<br/>
					<div style="clear:both;height:20px;"></div>
					<input type="checkbox" name="qualif" value="-1"/> Add one (If not listed)
					<input type="text" name="addqualif" class="inputv" placeholder="Add Qualification" readonly="readonly" onclick="add_qual()" <?php if(isset($add_qualif)) echo "value=$add_qualif";?>/>
					Notice Period: <input type="text" name="not_period" placeholder="Notice Period" class="inputv" required readonly="true" onclick="add_nop()"><br>
					<label>Notice Period in:
					<select name="not_period_dm">
						<option value="0" selected>Day(s)</option>
						<option value="1">Month(s)</option>
					</select></label><br/>
					</div>		
				</div>
			</div>
		</div>
	</div>	



	<div id="formbox1">
		<div id="formbox2">
			<div id="formbox3">
				<div id="formbox4">
				<h3 id="secjobhead">Job Description</h3>
					<Textarea id="jobsummary" placeholder="Job Summary..."></textarea>
					
				</div>
			</div>
		</div>
	</div>
		
		

	<div id="formbox1">
		<div id="formbox2">
			<div id="formbox3">
				<div id="formbox4">
					<h3 id="secjobhead">Client Contact Details</h3>
						Contact Person: <select>
							<option>1st Person</option>
					</select>
						Priority: <select>
							<option>ASAP</option>
							<option>1 Week</option>
							<option>2 Week</option>
							<option>3 Week</option>
						</select>
				</div>
			</div>
		</div>
	</div>
					

</body>
</html>