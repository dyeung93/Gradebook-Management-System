<?php
	include ('includes/functions.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title> CIS 4301</title>
<!--Bootstrap-->
<link href="css/bootstrap.css" rel="stylesheet" media="screen">
<link href="css/bootstrap-theme.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/my_functions.js"></script>

</head>
<body>
<?php
	$username = $_SESSION["username"];
	$conn=connect();
	$query = "SELECT distinct UFID FROM student WHERE student.gatorLink = '$username'";
	$stid=oci_parse($conn,$query);
	oci_execute($stid);
	$row=oci_fetch_row($stid);
	$_SESSION["UFID"] = $row[0];

	if ($_SESSION["viewType"] == "student") {
		$query="SELECT distinct course_name FROM student,course WHERE student.UFID=course.student_ID AND student.gatorLink='$username'";
	}
	$stid=oci_parse($conn,$query);
	oci_execute($stid);
?>

<?php include 'navbar.php' ?>
    
    <!--SIDE MENU-->
    <div class ="container-fluid">
    	<div class ="row">
       		<div class = "col-md-3">
	    		<ul class="nav nav-pills nav-stacked" id = "main_side_menu">
	  				<li role="presentation"><a href="#" id = "Home">Home</a></li>
	  				<li role="presentation"><a href="#" id = "Course">Courses</a></li>
	 	 			<li role="presentation"><a href="#" id = "Grades">Grades</a></li>
				</ul>
			</div>
			<div class = "col-md-7">
				<div id ="main_body">
					<div class ="list-group">
	    				<h4 class="list-group-item-heading">Announcements</h4>
						<div id = "Announcements">
		    				<table class="table table-striped">
		    					<tr> <th> Date and Time </th> <th> Course </th> <th> Message </th></tr>
		    				<?php 
		    					$query = "SELECT distinct time, course, message FROM ANNOUNCEMENTS 
								INNER JOIN Course
								ON Course.course_name = announcements.course
								INNER JOIN Student
								ON student.ufid = course.student_id
								ORDER BY time DESC";
		    					$conn=connect();
		    					$stid = oci_parse($conn,$query);
								oci_execute($stid);
								while(($row = oci_fetch_array($stid)) != false) {
									echo '<tr> ';
									echo '<td> ' . $row[0] . '</td>';
									echo '<td> ' . $row[1] . '</td>';
									echo '<td> ' . $row[2] . '</td>';
									echo '</tr>';
								}

		    				?>
		    				</table>

		    			</div>
		    		</div>
	    		</div>

    		</div>

		</div>
    </div>

</body>
</html>


