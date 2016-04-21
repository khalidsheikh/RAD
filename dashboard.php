<?php
	session_start();
	if(!isset($_SESSION['username']))
	{
		header('Location login.php');
	}
	else
	{
		$username = $_SESSION['username'];
		$userdata = array();
		set_time_limit(0);
		$user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

		$url = "http://cortexapi.ddns.net:8080/api/lookUpPersonByUsername/$username";
		$options = array(

			CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
			CURLOPT_POST           =>false,        //set to GET
			CURLOPT_USERAGENT      => $user_agent, //set user agent
			CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
			CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => false,    // don't return headers
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 0,      // timeout on connect
			CURLOPT_TIMEOUT        => 400,      // timeout on response
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
			
		);

		$ch      = curl_init( $url );
		curl_setopt_array( $ch, $options );
		
		$content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$header  = curl_getinfo( $ch );
		curl_close( $ch );

		$response = json_decode($content);
		if($response->status == 'success')
		{
			$userdata = $response->data;
			$_SESSION['email'] = $userdata[1];
		}
	
	}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Project T | Dasboard </title>
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
		<div class='container'>
			<div class='row'>
				<div class='col-md-12'>
					<div class="jumbotron">
						<div class="container">
							<h1>Welcome <?php echo $userdata[0] ?></h1>
							<?php if(count($userdata[2]) > 0) { ?>
								<p><a class="btn btn-primary" href="appointment.php" role="button">Add Appointment &raquo;</a></p>	
							<?php } else { ?>
								<p><a class="btn btn-primary" href="slot.php" role="button">Add Empty Slot &raquo;</a></p>	
							<?php } ?>
							<p><a class="btn btn-default" href="logout.php" role="button">Logout &raquo;</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
