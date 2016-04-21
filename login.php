<?php
	session_start();
	$error = "";
	if(isset($_POST['username']) && isset($_POST['password']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		set_time_limit(0);
		$user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

		
		$url = "http://cortexapi.ddns.net:8080/api/authenticate";
		$options = array(

			CURLOPT_CUSTOMREQUEST  =>"POST",        //set request type post or get
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
		$data = array('username'=>$username, 'password'=>$password);	
		//$data = array('lecturer'=>true,'name'=>'Test Name','email'=>'test3211@test.com','username'=>'test3211', 'password'=>'123456');
		$json = json_encode($data);
		curl_setopt_array( $ch, $options );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		//curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(    //<--- Added this code block
			'Content-Type: application/json',
			'Content-Length: ' . strlen($json),
			'Authorization: Basic ' . base64_encode($username.':'.$password))
		);
		
		$content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$header  = curl_getinfo( $ch );
		curl_close( $ch );

		$response = json_decode($content);
		if($response->status == 'success')
		{
			$_SESSION['username'] = $username;
			$_SESSION['token'] = $response->data;
			header('Location: dashboard.php');
		}
		else
		{
			$error = $response->message;
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>MAJOR | Login</title>
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
					<h1>Login Form</h1>
					<?php if(isset($error) && !empty($error)) { ?>
						<p class='alert alert-danger'><?php echo $error; ?></p>
					<?php } ?>
					<form role='form' id='loginForm' method='post' action='login.php' >
						<div class="form-group">
							<label for="username">Username *</label>
							<input type="text" class="form-control" name="username" id="username" placeholder="Username">
							<p id='usernameAlert' class='text text-danger hidden'></p>
						</div>
						<div class="form-group">
							<label for="password">Password *</label>
							<input type="password" class="form-control" name="password" id="password" placeholder="Password">
							<p id='passwordAlert' class='text text-danger hidden'></p>
						</div>

						<button type="submit" class="btn btn-primary btn-lg">Login</button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js" ></script>
<script type='text/javascript'>
	$(document).on('ready',function(){
		$('#loginForm').on('submit',function(){
			return validateForm();
		});
	});
	function validateForm() {
		$('.text.text-danger').addClass('hidden');
		$('.error').removeClass('error');
		var flag = true;
		
		if(!$('#username').val()) {
			$('#usernameAlert').removeClass('hidden').text('* Username is required');
			$('#username').addClass('error');
			flag = false;
		}
		if(!$('#password').val()) {
			$('#passwordAlert').removeClass('hidden').text('* Password is required');
			$('#password').addClass('error');
			flag = false;
		}
		return flag;
	}
	
</script>