<?php
$reqlogin=true;
$css="era";
require_once ('header.php');
?>	
	<div id="post1">
		<div id="post2">
			<a href="form">
				<div id="post3">
					<div id="post4">
						<h3 id="posthead">Post A Job</h3>
					</div>
				</div>
			</a>
		</div>
	</div>

	<div id="post1">
		<div id="post2">
			<a href="#">
			<div id="post3">
				<div id="post4">
					<h3 id="posthead">Search</h3>
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
					<h3 id="posthead2">View Recruiters</h3>
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
					<h3 id="posthead2">View Candidates</h3>
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
}
if($_SESSION['user_right']==0)
{
?>
	<div id="post1">
		<div id="post2">
			<a href="add_recruit">
			<div id="post3">
				<div id="post4">
					<h3 id="posthead2">Add Recruit</h3>
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
