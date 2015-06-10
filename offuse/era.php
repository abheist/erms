
<?php
session_start();
if(!isset($_SESSION['email']) || !isset($_SESSION['username']))
	header('Location: .');
?>
<html>
<head>
	<title>Erasmith | Home</title>
	<link rel="stylesheet" type="text/css" href="css/era.css">
</head>
<body>
	<h1 id="heading">Erasmith<span id="hiuser">Hi <?php echo $_SESSION['username']?></span></h1>
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
			<a href="load?val=out">
			<div id="post3">
				<div id="post4">
					<h3 id="posthead2">Account<br>Setting</h3>
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
					<h3 id="posthead2">Add Recruit</h3>
				</div>
			</div>
			</a>
		</div>
	</div>

</body>
</html>