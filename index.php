<?php
	session_start();
	if(isset($_SESSION['username']))
	{
		header('Location: dashboard.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>MAJOR</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/app.css">
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php">T Project</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					
				</div><!--/.navbar-collapse -->
			</div>
		</nav>

		<!-- Main jumbotron for a primary marketing message or call to action -->
		<div class="jumbotron">
			<div class="container">
				<h1>MAJOR KEY THETA</h1>
				<p>This is a website that lets Students book appoitments with teachers for Theta sessions and also allows Teachers to make available slots</p>
			</div>
			 
		</div>

		<div class="container">
		<!-- Example row of columns -->
			<div class="row">
				<div class="col-md-4">
					<h2>Student Signup</h2>
					<p>Student can sign up by lciking the signup button below</p>
					<p><a class="btn btn-primary" href="register.php?type=student" role="button">Student Signup &raquo;</a></p>
				</div>
				<div class="col-md-4">
					<h2>Teacher Signup</h2>
					<p>Teacher can sign up by lciking the signup button below</p>
					<p><a class="btn btn-primary" href="register.php?type=teacher" role="button">Teacher Signup &raquo;</a></p>
				</div>
				<div class="col-md-4">
					<h2>Login</h2>
					<p> Students and Tecaher can login using their username and password by clicking login button below</p>
					<p><a class="btn btn-primary" href="login.php" role="button">Login &raquo;</a></p>
				</div>
			</div>

			<hr>
			<footer>
				<p>&copy; 2015 Company, Inc.</p>
			</footer>
		</div> <!-- /container -->
	</body>
</html>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>