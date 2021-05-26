<?php

	include 'connect.php';
	$stmt = $con->prepare("SELECT * FROM users");
	$stmt->execute();
	$rows = $stmt->fetchAll();
	?>
	<h1>Manage Members</h1>

	<table>
		<tr>
			<td>ID</td>
			<td>First name</td>
			<td>Last name</td>
			<td>age</td>
		</tr>
	<tr>
	<?php 
		foreach ($rows as $row) {
			echo "<tr>";
				echo "<td>" . $row['id'] . "</td>";
				echo "<td>" . $row['first_name'] . "</td>";
				echo "<td>" . $row['last_name'] . "</td>";
				echo "<td>" . $row['age'] . "</td>";
				echo "<td>" . "</td>";
				echo "<td>
						<a href='members.php?do=Edit&userid=" . $row['UserID'] . "''>Edit</a>
						<a href='members.php?do=Delete&userid=" . $row['UserID'] . "'>Delete</a>";
															 
					echo"</td>";
			echo "</tr>";
		}
	?>	
	</tr>
	</table>

	<a href="members.php?do=Add">Add New Member</a>

<?php
	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	if ($do == 'Manage') {


	} elseif ($do == 'Add') { 


	} elseif ($do == 'Insert') {


	} elseif ($do == 'Edit') {


	} elseif ($do == 'Update') {


	} elseif ($do == 'Delete') {


	} elseif ($do == 'Activate') {
	
	}

?>