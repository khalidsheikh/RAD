<?php
include ("includes/conexion.php");
$course = $_POST['course'];
$subject = $_POST['subject'];
?>
<html>
    <head>
        <title>Project</title>
		<link type="text/css" href="style.css" rel="stylesheet" />
    </head>
<body>
<div class="left" id="header">
	<div class="left">
		<img src ="/img/logo.png" style="border:1px solid black;"/>
	</div>
</div>

<div class="clear"></div>

<div id="body">
	<div style="margin-top:35px;">
		 <table class="tableteachers">
		 	<tr>
		 		<th>NAME</th>
				<th>MAIL</th>
				<th>COURSE</th>
				<th>SUBJECT</th>
		 	</tr>
		 	<?php 
		 		$class=mysql_query(" SELECT DISTINCT(id_class), t.name_teacher, t.mail_teacher, c.name_course, s.name_subject 
									 FROM `class` cl 
									 LEFT JOIN course c ON cl.`id_course` = c.`id_course` 
									 LEFT JOIN subject s ON cl.`id_subject` = s.`id_subject`
									 LEFT JOIN teachers t ON cl.`id_teacher` = t.`id_teacher`
									 WHERE c.`id_course` = ".$course. " AND s.`id_subject` = ".$subject ,$conexion);
		 		while($row = mysql_fetch_array($class))
				{
		 			echo"<tr>";
		 				echo"<td>".$row['name_teacher']."</td>";
		 				echo"<td>".$row['mail_teacher']."</td>";
		 				echo"<td>".$row['name_course']."</td>";
		 				echo"<td>".$row['name_subject']."</td>";
		 			echo"</tr>";
		 		}
		 	 ?>

		 </table>

		<div style="margin-top:25px;" class="right">	
			 <a href="registerindex.php">
				<span class="btn">GO TO REGISTER</span>	
			</a>
		</div>
	</div>
</div>

</body>
</html>