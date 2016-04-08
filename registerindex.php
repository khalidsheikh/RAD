<?php
include ("includes/conexion.php");
?>
<html>
    <head>
        <title>Project T</title>
		<link type="text/css" href="style.css" rel="stylesheet" />
    </head>
<body>
<div class="left" id="header">
	<div class="left">
		<img src ="../img/logo.png" style="border:1px solid black;"/>
	</div>
</div>

<div class="clear"></div>

<div id="body">
	<form action="register.php" method="post" name="form" id="form">
		<div style="margin-top:35px;">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="2">
						<span>Name</span><span class="required">*</span>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" name="fname" style="input-text-medium"/>
						<br/>
						<span>First</span>
					</td>
					<td>
						<input type="text" name="lname" style="input-text-medium"/>
						<br/>
						<span>Last</span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<span>Student ID</span><span class="required">*</span>
						<br/>
						<input type="text" name="id" style="input-text-medium"/>
						<br/>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<span>Course</span>
						<br/>
						<input type="text" name="course" style="input-text-medium"/>
						<br/>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<span>Faculty</span>
						<br/>
						<input type="text" name="faculty" style="input-text-medium"/>
						<br/>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<span>Year Level</span><span class="required">*</span>
						<br/>
						<input type="text" name="year" style="input-text-medium"/>
						<br/>
					</td>
				</tr>
			</table>
			<div class="left" style="margin-top: 25px;">
				<a href="#" onclick="form.submit();">
					<span class="btn">REGISTER</span>	
				</a>
			</div>
		</div>
	</form>
</div>

</body>
</html>