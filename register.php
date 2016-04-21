<!DOCTYPE html>
<?php
	set_time_limit(0);
	$successMsg = "";
	$errorMsg = "";
	$user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

	if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['lecturer']))
	{
		$name = $_POST['name'];
		$email = $_POST['email'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$lecturer = $_POST['lecturer'];
		if(isset($_POST['skills']))
		{
			$skills = isset($_POST['skills']);
			$data = array('username'=>$username, 'name'=>$name, 'email'=>$email, 'password'=>$password, 'skills'=>$skills, 'lecturer'=>$lecturer);	
		}
		else
		{
			$data = array('username'=>$username, 'name'=>$name, 'email'=>$email, 'password'=>$password, 'lecturer'=>$lecturer);	
		}
		
		$json = json_encode($data);
		$url = "http://cortexapi.ddns.net:8080/api/addNewPerson";
		
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
		
		curl_setopt_array( $ch, $options );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(    //<--- Added this code block
			'Content-Type: application/json',
			'Content-Length: ' . strlen($json))
		);
		$content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$header  = curl_getinfo( $ch );
		curl_close( $ch );
		//var_dump($content);
		$response = json_decode($content);
		if($response->status == 'success')
		{
			$successMsg = "Person Created Successfully";
		}
		else
		{
			$errorMsg = $response->message;
		}
	}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>PMAJOR KEY | Register</title>
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
			<?php 
				$flag = 'false';
				$heading = "Student Registration Form";
				if(isset($_GET['type']))
				{
					$type = $_GET['type'];
					if($type == 'teacher')
					{
						$flag = 'true';
						$heading = "Teacher Registration Form";
					}
					else
					{
						$flag = 'false';
					}
				}
				
			?>
			<div class='row'>
				<div class='col-md-12'>
					<h1><?php echo $heading; ?></h1>
					<form role='form' id='registerForm' method='post' action='register.php' >
						<?php if(isset($errorMsg) && !empty($errorMsg)) { ?>
							<p class='alert alert-danger'><?php echo $errorMsg; ?></p>
						<?php } ?>
						<?php if(isset($successMsg) && !empty($successMsg)) { ?>
							<p id='signupSuccess' class='alert alert-success'>You have successfully sign up, please visit <a href='login.php'>Login</a> to login </p>
						<?php } ?>
						<input type='hidden' id='lecturer' name='lecturer' value="<?php echo $flag; ?>"/>
						<div class="form-group">
							<label for="name">Name *</label>
							<input type="text" class="form-control" name="name" id="name" placeholder="Name">
							<p id='nameAlert' class='text text-danger hidden'></p>
						</div>
						<div class="form-group">
							<label for="email">Email *</label>
							<input type="text" class="form-control" name="email" id="email" placeholder="Email">
							<p id='emailAlert' class='text text-danger hidden'></p>
						</div>
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
						<?php if ($flag === 'false') { ?>
						<div class="form-group">
							<label for="skills">Skills *</label>
							<select multiple class='form-control' id='skills' name='skills[]'>
								<option value="C++">C++</option>
								<option value="C">C</option>
								<option value="SQL">SQL</option>
							</select>
							<p id='skillsAlert' class='text text-danger hidden'></p>
						</div>
						<?php } ?>
						<img id='loader' src="images/gears.gif" class='hidden' />
						<button id='submit' type="submit" class="btn btn-primary btn-lg"><i class=""></i>Signup</button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type='text/javascript'>
	$(document).on('ready',function(){
		$('#registerForm').on('submit',function(){
			return validateForm();
		});
	});
	function validateForm() {
		$('.text.text-danger').addClass('hidden');
		$('.error').removeClass('error');
		var flag = true;
		if(!$('#name').val()) {
			$('#nameAlert').removeClass('hidden').text('* Name is required');
			$('#name').addClass('error');
			flag = false;
		}
		if(!$('#email').val()) {
			$('#emailAlert').removeClass('hidden').text('* Email Address is required');
			$('#email').addClass('error');
			flag = false;
		}
		else if(!isValidEmailAddress($('#email').val())) {
			$('#emailAlert').removeClass('hidden').text('* Valid Email Address is required');
			$('#email').addClass('error');
			flag = false;
		}
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
		if($('#skills').length && !$('#skills').val()) {
			$('#skillsAlert').removeClass('hidden').text('* Select atleast one skill');
			$('#skills').addClass('error');
			flag = false;
		}
		return flag;
	}
	function isValidEmailAddress(emailAddress) {
		var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
		return pattern.test(emailAddress);
	}
</script>