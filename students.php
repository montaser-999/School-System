<?php

	include 'connect.php';
	$stmt = $con->prepare("SELECT * FROM student");
	$stmt->execute();
	$rows = $stmt->fetchAll();


	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	if ($do == 'Manage') {
?>
	<h1>Manage Students</h1>

	<table>
		<tr>
			<td>ID</td>
			<td>Name</td>
			<td>Age</td>
			<td>Grade</td>
			<td>Department</td>
		</tr>
	<tr>
<?php 
	foreach ($rows as $row) {
		echo "<tr>";
			echo "<td>" . $row['id'] . "</td>";
			echo "<td>" . $row['name'] . "</td>";
			echo "<td>" . $row['age'] . "</td>";
			echo "<td>" . $row['grade'] . "</td>";
			echo "<td>" . $row['dep_id'] . "</td>";
			echo "<td>" . "</td>";
			echo "<td>
				<a href='students.php?do=Edit&st_id=" . $row['id'] . "''>Edit</a>
				<a href='students.php?do=Delete&st_id=" . $row['id'] . "'>Delete</a>";
			echo"</td>";
		echo "</tr>";
	}
	?>	
	</tr>
	</table>
	<br>
	<a href="students.php?do=Add">Add New Member</a>
<?php
	} elseif ($do == 'Add'){
?>
						<!-- HTML Add FORM -->

			<form class="login" action="<?php echo "?do=Insert"?>" method="POST" >
				<h2 class="">Add new member</h2>				
				<input type="text" name="id" autocomplete="off" required="required" />ID<br>
				<input type="text" name="name" autocomplete="off" required="required" />Name*<br>
				<input type="text" name="age" autocomplete="off" required="required" />Age<br>
				<input type="text" name="grade" autocomplete="off" required="required" />Grade<br>
				<input type="text" name="dep_id" autocomplete="off" required="required" />Department<br>
				<input class= "btn" type="submit" value="Add Student" />
			</form>

<?php
	} elseif ($do == 'Insert'){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){

				echo "<h1>Insert Member</h1>";

				$id 	= $_POST['id'];
				$name 	= $_POST['name'];
				$age 	= $_POST['age'];
				$grade 	= $_POST['grade'];
				$dep_id = $_POST['dep_id'];

				$stmt = $con->prepare(" INSERT INTO 
											student(id, name, age, grade, dep_id)
											VALUES (:I, :N, :A, :G, :D )");
				$stmt->execute(array(
									 'I' => $id,
									 'N' => $name,
									 'A' => $age,
									 'G' => $grade,
									 'D' => $dep_id));
					

				echo "Inserted Successfully";
				header('Location: http://127.0.0.1/school_system/students.php');
				exit();
		}

	} elseif ($do == 'Edit'){

			$stmt = $con->prepare("SELECT * 
								   FROM  student 
								   WHERE id = ? 
								   LIMIT 1 ");
			$stmt->execute(array($_GET["st_id"]));
			$row = $stmt->fetch();

?>
									<!-- HTML EDIT FORM -->
		 	<form class="login" action="<?php echo "?do=Update"?>" method="POST" >
				<h2 class="">Edit Student</h2>
				<input type="hidden" name="id" value="<?php echo $_GET["st_id"] ?>" />	
				<input class="form-control" type="text" name="name" value="<?php echo $row['name'] ?>" autocomplete="off" required="required" />Name<br>
				<input class="form-control" type="text" name="age" value="<?php echo $row['age'] ?>" autocomplete="off" required="required" />Age<br>
				<input class="form-control" type="text" name="grade" value="<?php echo $row['grade'] ?>" autocomplete="off" required="required" />Grade<br>
				<input class="form-control" type="text" name="dep_id" value="<?php echo $row['dep_id'] ?>" autocomplete="off" required="required" />Department<br>
				<input class= "btn" type="submit" value="Update" />
			</form>

<?php
	} elseif ($do == 'Update') {
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){

				$id 	= $_POST['id'];
				$name 	= $_POST['name'];
				$age 	= $_POST['age'];
				$grade 	= $_POST['grade'];
				$dep_id = $_POST['dep_id'];
	
				$stmt = $con->prepare("UPDATE student 
								   		SET name = ?, age = ?, grade = ?, dep_id = ?
								    	WHERE id = ? ");
				$stmt->execute(array($name , $age, $grade, $dep_id, $id));

				echo "Updated Successfully";
				header('Location: http://127.0.0.1/school_system/students.php');
				exit();
			}

	} elseif ($do == 'Delete'){

			$stmt = $con->prepare("DELETE FROM  student WHERE id = :I");
			$stmt-> bindParam(":I", $_GET["st_id"]);
			$stmt->execute();
			echo "Deleted Successfully";
			header('Location: http://127.0.0.1/school_system/students.php');
			exit();



	}
?>