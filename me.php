<?php
$reqlogin=true;
$css="era";
require_once ('header.php');
$_SESSION['active']=false;
?>	
	<div id="post1">
		<div id="post2">
			<a href="form">
				<div id="post3">
					<div id="post4">
						<h3 id="posthead">Post A Job Opportunity</h3>
					</div>
				</div>
			</a>
		</div>
	</div>

	<div id="post1">
		<div id="post2">
			<a href="cansearch">
			<div id="post3">
				<div id="post4">
					<h3 id="posthead">Search a Candidate</h3>
				</div>
			</div>
			</a>
		</div>
	</div>

	

	<div id="post1">
		<div id="post2">
			<a href="viewrec">
			<div id="post3">
				<div id="post4">
					<h3 id="posthead2">View Recruiters' Info</h3>
				</div>
			</div>
			</a>
		</div>
	</div>

	<div id="post1">
		<div id="post2">
			<a href="viewcand">
			<div id="post3">
				<div id="post4">
					<h3 id="posthead2">View Candidates' Info</h3>
				</div>
			</div>
			</a>
		</div>
	</div>

	<div id="post1">
		<div id="post2">
			<a href="add_candy">
			<div id="post3">
				<div id="post4">
					<h3 id="posthead2">Add Candidate</h3>
				</div>
			</div>
			</a>
		</div>
	</div>

<?php
if($_SESSION['user_right']<2)
{
?>
	<div id="post1">
		<div id="post2">
			<a href="addfield_cand">
			<div id="post3">
				<div id="post4">
					<h3 id="posthead2">Add Fields in Candidate Form</h3>
				</div>
			</div>
			</a>
		</div>
	</div>

	<div id="post1">
		<div id="post2">
			<a href="add_client">
			<div id="post3">
				<div id="post4">
					<h3 id="posthead2">Add Client</h3>
				</div>
			</div>
			</a>
		</div>
	</div> 

<?php
}
if($_SESSION['user_right']==0)
{
?>
	<div id="post1">
		<div id="post2">
			<a href="add_recruit">
			<div id="post3">
				<div id="post4">
					<h3 id="posthead2">Add Recruiter</h3>
				</div>
			</div>
			</a>
		</div>
	</div>


<div id="post1">
		<div id="post2">
			<a href="viewdel">
				<div id="post3">
					<div id="post4">
						<h3 id="posthead">Deleted Recruiters' Info</h3>
					</div>
				</div>
			</a>
		</div>
	</div>

	

<?php
}
?>
</body>
</html>
