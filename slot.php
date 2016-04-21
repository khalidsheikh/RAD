<?php
	session_start();
	if(!isset($_SESSION['username']))
	{
		header('Location login.php');
	}
	else
	{
		set_time_limit(0);
		$successMsg = "";
		$errorMsg = "";
		$user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

		if(isset($_POST['name']) && isset($_POST['timeStart']) && isset($_POST['timeStop']) && isset($_POST['date']) && isset($_POST['notes']) && isset($_POST['recurringWeekly']) && isset($_POST['bookable']) && isset($_POST['username']))
		{
			$name = $_POST['name'];
			$timeStart = $_POST['timeStart'];
			$timeStart = str_replace(':','',$timeStart);
			$timeStop = $_POST['timeStop'];
			$timeStop = str_replace(':','',$timeStop);
			$date = $_POST['date'];
			$notes = $_POST['notes'];
			$username = $_SESSION['email'];
			$recurringWeekly = $_POST['recurringWeekly'];
			$bookable = $_POST['bookable'];
			
			$data = array('username'=>$username, 'name'=>$name, 'timeStart'=>$timeStart, 'timeStop'=>$timeStop, 'date'=>$date, 'notes'=>$notes, 'recurringWeekly'=>$recurringWeekly, 'bookable'=>$bookable);	
			$json = json_encode($data);
			
			//exit;
			$url = "http://cortexapi.ddns.net:8080/api/addNewAvailability";
			
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
				'Content-Length: ' . strlen($json),
				'token:' . $_SESSION['token'])
			);
			$content = curl_exec( $ch );
			$err     = curl_errno( $ch );
			$errmsg  = curl_error( $ch );
			$header  = curl_getinfo( $ch );
			curl_close( $ch );

			$response = json_decode($content);
			print_r($response);
			if($response->status == 'success')
			{
				$successMsg = "Availability Created Successfully";
			}
			else
			{
				$errorMsg = $response->message;
			}
		}
		$username = $_SESSION['username'];
		$email = $_SESSION['email'];
		/*$appArray = array();
		$url = "http://cortexapi.ddns.net:8080/api/getAvailabilityByPerson/$username";
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
		var_dump($response);
		if($response->status == 'success')
		{
			$appArray = $response->data;
		}
		*/
	}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>MAJOR KEY | Dasboard </title>
		<link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
		<link rel="stylesheet" href="css/jquery-clockpicker.min.css">
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/font-awesome.min.css" >
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
				<div class='col-md-12' style='position:relative'>
					<h1>Add New Availability</h1>
					<form role='form' id='slotForm' method='post' action='slot.php' >
						<?php if(isset($errorMsg) && !empty($errorMsg)) { ?>
							<p class='alert alert-danger'><?php echo $errorMsg; ?></p>
						<?php } ?>
						<?php if(isset($successMsg) && !empty($successMsg)) { ?>
							<p class='alert alert-success'><?php echo $successMsg; ?></p>
						<?php } ?>
						<input type='hidden' id='username' name='username' value="<?php echo $username; ?>"/>
						<div class="form-group">
							<label for="name">Name *</label>
							<input type="text" class="form-control" name="name" id="name" placeholder="Name">
							<p id='nameAlert' class='text text-danger hidden'></p>
						</div>
						<div class="form-group">
							<label for="slotDate">Date *</label>
							<div class="input-group">
								<input class='form-control' type='text' id='slotDate' placeholder='Date MMDDYYYY' name='date' />
								<span class="input-group-addon  text-white"><i class="fa fa-calendar"></i></span>
							</div>
							<p id='slotDateAlert' class='text text-danger hidden'></p>
						</div>
						<div class="form-group">
							<label for="starttime">Start Time *</label>
							<div class="input-group">
								<input class='form-control' type='text' id='starttime' placeholder='HH:MM' name='timeStart' />
								<span class="input-group-addon text-white"><i class="fa fa-clock-o"></i></span>
							</div>
							<p id='starttimeAlert' class='text text-danger hidden'></p>
						</div>
						<div class="form-group">
							<label for="endtime">End Time *</label>
							<div class="input-group">
								<input class='form-control' type='text' id='endtime' placeholder='HH:MM' name='timeStop' />
								<span class="input-group-addon text-white"><i class="fa fa-clock-o"></i></span>
							</div>
							<p id='endtimeAlert' class='text text-danger hidden'></p>
						
						</div>
						<div class="form-group">
							<label for="notes">Notes *</label>
							<input type="text" class="form-control" name="notes" id="notes" placeholder="Notes">
							<p id='notesAlert' class='text text-danger hidden'></p>
						</div>
						<div class="form-group">
							<label for="recurringWeekly">Recurring Weekly *</label>
							<select class='form-control' id='recurringWeekly' name='recurringWeekly'>
								<option value=true>Yes</option>
								<option value=false>No</option>
							</select>
							<p id='recurringWeeklyAlert' class='text text-danger hidden'></p>
						</div>
						<div class="form-group">
							<label for="bookable">Bokable *</label>
							<select class='form-control' id='bookable' name='bookable'>
								<option value=true>Yes</option>
								<option value=false>No</option>
							</select>
							<p id='recurringWeeklyAlert' class='text text-danger hidden'></p>
						</div>
						<img id='loader' src="images/gears.gif" class='hidden' />
						<button id='submit' type="submit" class="btn btn-primary btn-lg"><i class=""></i>Create Availability</button>
					</form>
				</div>
			</div>
			
		</div>
	</body>
</html>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/moment.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/jquery-clockpicker.min.js"></script>
<script type='text/javascript'>
	$(document).on('ready',function(){
		$('#slotDate').datepicker({
			autoclose: true,
			todayHighlight: true,
			'format':'yyyymmdd'
		});
		$('#starttime').clockpicker({
			placement: 'bottom',
			align: 'left',
			autoclose: true,
			'default': 'now'
		});
		$('#endtime').clockpicker({
			placement: 'bottom',
			align: 'left',
			autoclose: true,
			'default': 'now'
		});
		$('#slotForm').on('submit',function(){
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
		if(!$('#slotDate').val()) {
			$('#slotDateAlert').removeClass('hidden').text('* Date is required');
			$('#slotDate').addClass('error');
			flag = false;
		}
		
		if(!$('#starttime').val()) {
			$('#starttimeAlert').removeClass('hidden').text('* Start Time is required');
			$('#starttime').addClass('error');
			flag = false;
		}
		if(!$('#endtime').val()) {
			$('#endtimeAlert').removeClass('hidden').text('* End Time is required');
			$('#endtime').addClass('error');
			flag = false;
		}
		if(!$('#notes').val()) {
			$('#notesAlert').removeClass('hidden').text('* Notes is skill');
			$('#notes').addClass('error');
			flag = false;
		}
		return flag;
	}
</script>