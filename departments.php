<?php

	include 'connect.php';
	$stmt = $con->prepare("SELECT * FROM department");
	$stmt->execute();
	$rows = $stmt->fetchAll();


	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	if ($do == 'Manage') {
?>
	<h1>Manage Departments</h1>

	<table>
		<tr>
			<td>#ID</td>
			<td>Name</td>
		</tr>
	<tr>
<?php 
	foreach ($rows as $row) {
		echo "<tr>";
			echo "<td>" . $row['id'] . "</td>";
			echo "<td>" . $row['name'] . "</td>";
			echo "<td>" . "</td>";
			echo "<td>
				<a href='departments.php?do=Edit&dep_id=" . $row['id'] . "''>Edit</a>
				<a href='departments.php?do=Delete&dep_id=" . $row['id'] . "'>Delete</a>";
			echo"</td>";
		echo "</tr>";
	}
	?>	
	</tr>
	</table>
	<br>
	<a href="departments.php?do=Add">Add New Department</a>
<?php
	} elseif ($do == 'Add'){
?>
						<!-- HTML Add FORM -->

			<form class="login" action="<?php echo "?do=Insert"?>" method="POST" >
				<h2 class="">Add new Department</h2>				
				<input type="text" name="id" autocomplete="off" required="required" />ID<br>
				<input type="text" name="name" autocomplete="off" required="required" />Name<br>
				<input class= "btn" type="submit" value="Add Course" />
			</form>

<?php
	} elseif ($do == 'Insert'){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){

				echo "<h1>Insert Department</h1>";

				$id 	= $_POST['id'];
				$name 	= $_POST['name'];

				$stmt = $con->prepare(" INSERT INTO 
											department(id, name)
											VALUES (:I, :N)");
				$stmt->execute(array(
									 'I' => $id,
									 'N' => $name));
					

				echo "Inserted Successfully";
				header('Location: http://127.0.0.1/school_system/departments.php');
				exit();
		}

	} elseif ($do == 'Edit'){
			$stmt = $con->prepare("SELECT * 
								   FROM  department 
								   WHERE id = ? 
								   LIMIT 1 ");
			$stmt->execute(array($_GET["dep_id"]));
			$row = $stmt->fetch();

?>
									<!-- HTML EDIT FORM -->
		 	<form class="login" action="<?php echo "?do=Update"?>" method="POST" >
				<h2 class="">Edit Department</h2>
				<input type="hidden" name="code" value="<?php echo $_GET["dep_id"] ?>" />	
				<input class="form-control" type="text" name="name" value="<?php echo $row['name'] ?>" autocomplete="off" required="required" />Name<br>
				<input class= "btn" type="submit" value="Update" />
			</form>

<?php
	} elseif ($do == 'Update') {
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){

				$id 	= $_POST['id'];
				$name 	= $_POST['name'];
	
				$stmt = $con->prepare("UPDATE department 
								   		SET name = ?
								    	WHERE id = ? ");
				$stmt->execute(array($name , $id));

				echo "Updated Successfully";
				header('Location: http://127.0.0.1/school_system/departments.php');
				exit();
			}

	} elseif ($do == 'Delete'){

			$stmt = $con->prepare("DELETE FROM  department WHERE id = :I");
			$stmt-> bindParam(":I", $_GET["dep_id"]);
			$stmt->execute();
			echo "Deleted Successfully";
			header('Location: http://127.0.0.1/school_system/departments.php');
			exit();



	}
?>