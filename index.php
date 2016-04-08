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
	<form action="teachers.php" method="post" name="form" id="form">
		<div style="margin-top:35px;">
			<div class="left">
				<span>Course:</span>
				<select id="course" name="course">
						<?php 
			$course=mysql_query("SELECT id_course,name_course FROM course",$conexion);
			while($row = mysql_fetch_array($course))
			{
				echo'<option value="'.$row['id_course'].'">'.$row['name_course'].'</option>';
			}
						 ?>
				</select>
			</div>
			<div class="left">
				<span>Subject</span>	
				<select id="subject" name="subject">
						<?php 
			$subject=mysql_query("SELECT id_subject,name_subject FROM subject",$conexion);
			while($row = mysql_fetch_array($subject))
			{
				echo'<option value="'.$row['id_subject'].'">'.$row['name_subject'].'</option>';
			}
						 ?>
				</select>
			</div>

			<div class="clear"></div>
			<div style="margin-top:15px;" class="right">			
				<a href="#" onclick="form.submit();">
					<span class="btn">GO</span>	
				</a>
			</div>
		</div>
	</form>
</div>

</body>
</html>