<?php

	include 'connect.php';
	$stmt = $con->prepare("SELECT * FROM course");
	$stmt->execute();
	$rows = $stmt->fetchAll();


	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	if ($do == 'Manage') {
?>
	<h1>Manage Courses</h1>

	<table>
		<tr>
			<td>Code</td>
			<td>Name</td>
			<td>Description</td>
		</tr>
	<tr>
<?php 
	foreach ($rows as $row) {
		echo "<tr>";
			echo "<td>" . $row['code'] . "</td>";
			echo "<td>" . $row['name'] . "</td>";
			echo "<td>" . $row['description'] . "</td>";
			echo "<td>" . "</td>";
			echo "<td>
				<a href='courses.php?do=Edit&course_code=" . $row['code'] . "''>Edit</a>
				<a href='courses.php?do=Delete&course_code=" . $row['code'] . "'>Delete</a>";
			echo"</td>";
		echo "</tr>";
	}
	?>	
	</tr>
	</table>
	<br>
	<a href="courses.php?do=Add">Add New Course</a>
<?php
	} elseif ($do == 'Add'){
?>
						<!-- HTML Add FORM -->

			<form class="login" action="<?php echo "?do=Insert"?>" method="POST" >
				<h2 class="">Add new member</h2>				
				<input type="text" name="code" autocomplete="off" required="required" />Code<br>
				<input type="text" name="name" autocomplete="off" required="required" />Name<br>
				<input type="text" name="description" autocomplete="off" required="required" />Description<br>
				<input class= "btn" type="submit" value="Add Course" />
			</form>

<?php
	} elseif ($do == 'Insert'){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){

				echo "<h1>Insert Course</h1>";

				$code 		 = $_POST['code'];
				$name 		 = $_POST['name'];
				$description = $_POST['description'];

				$stmt = $con->prepare(" INSERT INTO 
											course(code, name, description)
											VALUES (:C, :N, :D)");
				$stmt->execute(array(
									 'C' => $code,
									 'N' => $name,
									 'D' => $description));
					

				echo "Inserted Successfully";
				header('Location: http://127.0.0.1/school_system/courses.php');
				exit();
		}

	} elseif ($do == 'Edit'){
			$stmt = $con->prepare("SELECT * 
								   FROM  course 
								   WHERE code = ? 
								   LIMIT 1 ");
			$stmt->execute(array($_GET["course_code"]));
			$row = $stmt->fetch();

?>
									<!-- HTML EDIT FORM -->
		 	<form class="login" action="<?php echo "?do=Update"?>" method="POST" >
				<h2 class="">Edit Courses</h2>
				<input type="hidden" name="code" value="<?php echo $_GET["course_code"] ?>" />	
				<input class="form-control" type="text" name="name" value="<?php echo $row['name'] ?>" autocomplete="off" required="required" />Name<br>
				<input class="form-control" type="text" name="description" value="<?php echo $row['description'] ?>" autocomplete="off" required="required" />Description<br>
				<input class= "btn" type="submit" value="Update" />
			</form>

<?php
	} elseif ($do == 'Update') {
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){

				$code 		 = $_POST['code'];
				$name 		 = $_POST['name'];
				$description = $_POST['description'];
	
				$stmt = $con->prepare("UPDATE course 
								   		SET name = ?, description = ?
								    	WHERE code = ? ");
				$stmt->execute(array($name , $description, $code));

				echo "Updated Successfully";
				header('Location: http://127.0.0.1/school_system/courses.php');
				exit();
			}

	} elseif ($do == 'Delete'){

			$stmt = $con->prepare("DELETE FROM  course WHERE code = :C");
			$stmt-> bindParam(":C", $_GET["course_code"]);
			$stmt->execute();
			echo "Deleted Successfully";
			header('Location: http://127.0.0.1/school_system/courses.php');
			exit();



	}
?>